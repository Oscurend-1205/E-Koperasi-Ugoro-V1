<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::with(['simpanans', 'pinjamans'])->orderBy('created_at', 'desc')->get();
        $totalAnggota = $users->count();
        $totalSimpanan = Simpanan::sum('jumlah');
        $totalPinjaman = Pinjaman::where('status', 'disetujui')->sum('jumlah_pinjaman');

        return view('admin.dashboard', compact('users', 'totalAnggota', 'totalSimpanan', 'totalPinjaman'));
    }

    public function dataAnggota(Request $request)
    {
        $query = User::with(['simpanans', 'pinjamans']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('no_anggota', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'Aktif') {
                $query->where('status', '!=', 'non-aktif');
            } elseif ($request->status === 'Nonaktif') {
                $query->where('status', 'non-aktif');
            }
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        if ($request->ajax()) {
            return view('admin.partials.data_anggota_rows', compact('users'));
        }

        return view('admin.dataAnggota', compact('users'));
    }

    public function inputSimpanan(Request $request)
    {
        $users = User::orderBy('name')->get();
        $selectedUser = null;
        
        if ($request->has('user_id')) {
            $selectedUser = User::with('simpanans')->find($request->user_id);
        }
        
        $simpanans = $selectedUser ? $selectedUser->simpanans()->latest('tanggal_transaksi')->get() : collect();

        return view('admin.inputSimpanan', compact('users', 'selectedUser', 'simpanans'));
    }

    public function storeSimpanan(Request $request)
    {
        if ($request->has('jumlah')) {
            $request->merge(['jumlah' => str_replace('.', '', $request->jumlah)]);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_simpanan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'tanggal_transaksi' => 'required|date'
        ]);

        Simpanan::create($request->only(['user_id', 'jenis_simpanan', 'jumlah', 'keterangan', 'tanggal_transaksi']));

        return back()->with('success', 'Berhasil menambahkan riwayat simpanan baru.');
    }

    public function inputPinjaman(Request $request)
    {
        $users = User::orderBy('name')->get();
        $selectedUser = null;

        if ($request->has('user_id')) {
            $selectedUser = User::with(['pinjamans.angsurans'])->find($request->user_id);
        }
        
        $pinjamans = $selectedUser ? $selectedUser->pinjamans()->with('angsurans')->latest()->get() : collect();

        $allPinjamans = Pinjaman::with(['user', 'angsurans'])->latest()->get();

        return view('admin.inputPinjaman', compact('users', 'selectedUser', 'pinjamans', 'allPinjamans'));
    }

    public function storePinjaman(Request $request)
    {
        if ($request->has('jumlah_pinjaman')) {
            $request->merge(['jumlah_pinjaman' => str_replace('.', '', $request->jumlah_pinjaman)]);
        }
        if ($request->has('bunga')) {
            $request->merge(['bunga' => str_replace('.', '', $request->bunga)]);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jumlah_pinjaman' => 'required|numeric|min:0',
            'tenor' => 'required|integer|min:1',
            'bunga' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
            'tanggal_pengajuan' => 'required|date'
        ]);

        $data = $request->only(['user_id', 'jumlah_pinjaman', 'tenor', 'keterangan', 'tanggal_pengajuan']);
        $data['status'] = 'disetujui';
        $data['bunga'] = $request->bunga ?? 0;

        Pinjaman::create($data);

        return back()->with('success', 'Berhasil memproses pencairan pinjaman baru.');
    }

    public function destroyPinjaman($id)
    {
        \App\Models\Pinjaman::findOrFail($id)->delete();
        return back()->with('success', 'Berhasil menghapus data pinjaman.');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
            'type' => 'required|string'
        ]);

        $file  = $request->file('file');
        $ext   = strtolower($file->getClientOriginalExtension());
        $type  = $request->type;

        try {
            // ── Import Data Anggota & Simpanan via MemberImport ──────────────
            if ($type === 'anggota' && in_array($ext, ['xls', 'xlsx', 'csv'])) {
                $import = new \App\Imports\MemberImport;
                \Maatwebsite\Excel\Facades\Excel::import($import, $file);

                return redirect()->route('admin.import')
                    ->with('success', 'Data Anggota & Simpanan berhasil diimport ke database!');
            }

            // ── Import via CSV (Simpanan / Pinjaman) ──────────────────────────
            if ($ext === 'csv') {
                $handle   = fopen($file->getPathname(), 'r');
                $header   = fgetcsv($handle, 1000, ','); // skip header row
                $rowCount = 0;

                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    if (count($data) < 2) continue;

                    $user = User::where('no_anggota', $data[0])->first();
                    if (!$user) continue;

                    if ($type === 'simpanan') {
                        $pokok = isset($data[2]) ? (float) $data[2] : 0;
                        $wajib = isset($data[3]) ? (float) $data[3] : 0;
                        if ($pokok > 0) Simpanan::create(['user_id' => $user->id, 'jenis_simpanan' => 'Pokok', 'jumlah' => $pokok, 'tanggal_transaksi' => now()]);
                        if ($wajib > 0) Simpanan::create(['user_id' => $user->id, 'jenis_simpanan' => 'Wajib',  'jumlah' => $wajib, 'tanggal_transaksi' => now()]);
                        $rowCount++;
                    } elseif ($type === 'pinjaman') {
                        $jumlah = isset($data[2]) ? (float) $data[2] : 0;
                        $tenor  = isset($data[3]) ? (int)   $data[3] : 12;
                        if ($jumlah > 0) {
                            Pinjaman::create(['user_id' => $user->id, 'jumlah_pinjaman' => $jumlah, 'tenor' => $tenor, 'status' => 'disetujui', 'tanggal_pengajuan' => now()]);
                            $rowCount++;
                        }
                    }
                }
                fclose($handle);

                return redirect()->route('admin.import')
                    ->with('success', $rowCount . ' baris berhasil diimport!');
            }

            return redirect()->route('admin.import')
                ->with('error', 'Format file atau tipe data tidak didukung.');

        } catch (\Exception $e) {
            return redirect()->route('admin.import')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroyUser(User $user)
    {
        if ($user->role === 'admin' || $user->role === 'Super Admin') {
            return back()->with('error', 'Super Admin atau Admin tidak dapat dihapus.');
        }

        $user->simpanans()->delete();
        $user->pinjamans()->delete();
        $user->delete();

        return back()->with('success', 'Anggota berhasil dihapus.');
    }

    public function bulkDestroyUsers(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || !is_array($ids)) {
            return back()->with('error', 'Tidak ada anggota yang dipilih.');
        }

        DB::beginTransaction();
        try {
            $deletedCount = 0;
            foreach ($ids as $id) {
                $user = User::find($id);
                if ($user) {
                    // Proteksi Super Admin
                    if ($user->role === 'admin' || $user->role === 'Super Admin') {
                        continue; // Lewati admin
                    }
                    $user->simpanans()->delete();
                    $user->pinjamans()->delete();
                    $user->delete();
                    $deletedCount++;
                }
            }
            DB::commit();
            
            if ($deletedCount === 0 && count($ids) > 0) {
                return back()->with('error', 'Tidak ada anggota yang dihapus (Admin dilindungi).');
            }

            return back()->with('success', $deletedCount . ' anggota berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus: ' . $e->getMessage());
        }
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->role === 'admin' || $user->role === 'Super Admin') {
            return back()->with('error', 'Status Super Admin atau Admin tidak dapat diubah.');
        }

        $user->status = ($user->status === 'non-aktif') ? 'aktif' : 'non-aktif';
        $user->save();

        $statusLabel = $user->status === 'non-aktif' ? 'dinonaktifkan' : 'diaktifkan kembali';
        return back()->with('success', "Anggota {$user->name} berhasil {$statusLabel}.");
    }

    public function impersonate(User $user)
    {
        session(['admin_impersonate' => Auth::id()]);
        Auth::login($user);
        
        return redirect()->route('dashboard')->with('success', 'Anda sedang masuk sebagai anggota (Impersonate Mode)');
    }

    public function leaveImpersonate()
    {
        if (session()->has('admin_impersonate')) {
            $adminId = session('admin_impersonate');
            Auth::loginUsingId($adminId);
            session()->forget('admin_impersonate');
            
            return redirect()->route('admin.dataAnggota')->with('success', 'Berhasil kembali ke mode Admin.');
        }
        
        return redirect()->route('dashboard');
    }
    public function messages()
    {
        $messages = \App\Models\ContactMessage::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.messages', compact('messages'));
    }

    public function markMessageRead($id)
    {
        $message = \App\Models\ContactMessage::findOrFail($id);
        $message->status = 'Dibaca';
        $message->save();

        return back()->with('success', 'Pesan telah ditandai sebagai dibaca.');
    }

    public function replyMessage(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string'
        ]);

        $message = \App\Models\ContactMessage::findOrFail($id);
        $message->reply = $request->reply;
        $message->replied_at = now();
        $message->status = 'Dibaca';
        $message->save();

        return back()->with('success', 'Berhasil memberikan informasi balasan ke anggota.');
    }
}
