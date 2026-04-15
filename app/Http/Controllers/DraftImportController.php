<?php

namespace App\Http\Controllers;

use App\Models\ImportDraft;
use App\Models\User;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class DraftImportController extends Controller
{
    public function index()
    {
        $drafts = ImportDraft::with('user')->where('status', 'draft')->latest()->get();
        return view('admin.drafts.index', compact('drafts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
            'type' => 'required|string',
            'start_row' => 'nullable|integer|min:1',
            'col_nia' => 'required',
            'col_name' => 'required',
            'col_pokok' => 'nullable',
            'col_wajib' => 'nullable',
            'col_monosuko' => 'nullable',
            'col_dpu' => 'nullable',
        ]);

        $file = $request->file('file');
        $type = $request->type;
        $startRow = $request->start_row ?? 3;

        // Configuration for columns
        $config = [
            'nia' => $request->col_nia,
            'name' => $request->col_name,
            'pokok' => $request->col_pokok,
            'wajib' => $request->col_wajib,
            'monosuko' => $request->col_monosuko,
            'dpu' => $request->col_dpu,
        ];

        try {
            // Use local logic to parse instead of full Maatwebsite for speed/flexibility
            $data = Excel::toArray(new class {}, $file);
            $rows = $data[0]; // First sheet
            
            $draftRows = [];
            $slicedRows = array_slice($rows, $startRow - 1);

            foreach ($slicedRows as $row) {
                $nia = isset($row[$config['nia']]) ? trim((string)$row[$config['nia']]) : '';
                $name = isset($row[$config['name']]) ? trim((string)$row[$config['name']]) : '';

                if (empty($nia) && empty($name)) continue;

                $draftRows[] = [
                    'nia' => $nia,
                    'name' => $name,
                    'pokok' => isset($config['pokok']) ? $this->parseCurrency($row[$config['pokok']] ?? 0) : 0,
                    'wajib' => isset($config['wajib']) ? $this->parseCurrency($row[$config['wajib']] ?? 0) : 0,
                    'monosuko' => isset($config['monosuko']) ? $this->parseCurrency($row[$config['monosuko']] ?? 0) : 0,
                    'dpu' => isset($config['dpu']) ? $this->parseCurrency($row[$config['dpu']] ?? 0) : 0,
                ];
            }

            ImportDraft::create([
                'user_id' => Auth::id(),
                'file_name' => $file->getClientOriginalName(),
                'type' => $type,
                'data' => $draftRows,
                'status' => 'draft'
            ]);

            return redirect()->route('admin.drafts.index')
                ->with('success', 'Data berhasil disimpan sebagai draft.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan draft: ' . $e->getMessage());
        }
    }

    /**
     * Store a draft from the manual spreadsheet editor (JSON payload via AJAX).
     */
    public function storeManual(Request $request)
    {
        $request->validate([
            'rows' => 'required|array|min:1',
            'rows.*.nia' => 'required|string',
            'rows.*.name' => 'required|string',
        ]);

        $draftRows = [];
        foreach ($request->rows as $row) {
            $draftRows[] = [
                'nia' => trim($row['nia']),
                'name' => trim($row['name']),
                'pokok' => $this->parseCurrency($row['pokok'] ?? 0),
                'wajib' => $this->parseCurrency($row['wajib'] ?? 0),
                'monosuko' => $this->parseCurrency($row['monosuko'] ?? 0),
                'dpu' => $this->parseCurrency($row['dpu'] ?? 0),
            ];
        }

        $draft = ImportDraft::create([
            'user_id' => Auth::id(),
            'file_name' => 'Input Manual — ' . now()->format('d M Y H:i'),
            'type' => 'anggota',
            'data' => $draftRows,
            'status' => 'draft',
        ]);

        return response()->json(['success' => true, 'draft_id' => $draft->id, 'message' => 'Draft berhasil disimpan.']);
    }

    /**
     * Add a single row to an existing draft via AJAX.
     */
    public function addRow(Request $request, ImportDraft $draft)
    {
        $data = $draft->data;
        $data[] = [
            'nia' => trim($request->nia ?? ''),
            'name' => trim($request->name ?? ''),
            'pokok' => $this->parseCurrency($request->pokok ?? 0),
            'wajib' => $this->parseCurrency($request->wajib ?? 0),
            'monosuko' => $this->parseCurrency($request->monosuko ?? 0),
            'dpu' => $this->parseCurrency($request->dpu ?? 0),
        ];
        $draft->update(['data' => $data]);
        return response()->json(['success' => true, 'new_index' => count($data) - 1]);
    }

    public function show(ImportDraft $draft)
    {
        return view('admin.drafts.show', compact('draft'));
    }

    public function update(Request $request, ImportDraft $draft)
    {
        // Update specific row in draft JSON
        $data = $draft->data;
        $rowIndex = $request->row_index;
        
        if (isset($data[$rowIndex])) {
            $data[$rowIndex]['nia'] = $request->nia;
            $data[$rowIndex]['name'] = $request->name;
            $data[$rowIndex]['pokok'] = $this->parseCurrency($request->pokok);
            $data[$rowIndex]['wajib'] = $this->parseCurrency($request->wajib);
            $data[$rowIndex]['monosuko'] = $this->parseCurrency($request->monosuko);
            $data[$rowIndex]['dpu'] = $this->parseCurrency($request->dpu);
            
            $draft->update(['data' => $data]);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    public function destroy(ImportDraft $draft)
    {
        $draft->delete();
        return back()->with('success', 'Draft berhasil dihapus.');
    }

    public function removeRow(Request $request, ImportDraft $draft)
    {
        $data = $draft->data;
        $rowIndex = $request->row_index;

        if (isset($data[$rowIndex])) {
            unset($data[$rowIndex]);
            $draft->update(['data' => array_values($data)]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function confirm(ImportDraft $draft)
    {
        DB::beginTransaction();
        try {
            $data = $draft->data;
            $count = 0;

            foreach ($data as $row) {
                if (empty($row['nia']) || empty($row['name'])) continue;

                // 1. User Creation/Update
                $user = User::firstOrCreate(
                    ['no_anggota' => $row['nia']],
                    [
                        'name' => $row['name'],
                        'nik' => '-',
                        'alamat' => '-',
                        'no_hp' => '-',
                        'password' => Hash::make($row['nia']),
                        'role' => 'user'
                    ]
                );

                // 2. Savings Creation
                $savings = [
                    'Pokok' => $row['pokok'],
                    'Wajib' => $row['wajib'],
                    'Monosuko' => $row['monosuko'],
                    'DPU' => $row['dpu']
                ];

                foreach ($savings as $jenis => $jumlah) {
                    if ($jumlah > 0) {
                        Simpanan::create([
                            'user_id' => $user->id,
                            'jenis_simpanan' => $jenis,
                            'jumlah' => $jumlah,
                            'tanggal_transaksi' => now(),
                            'keterangan' => 'Konfirmasi dari Draft: ' . $draft->file_name
                        ]);
                    }
                }
                $count++;
            }

            $draft->update(['status' => 'confirmed']);
            DB::commit();

            return redirect()->route('admin.dashboard')
                ->with('success', "Berhasil mengonfirmasi $count data dari draft ke database utama.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal konfirmasi: ' . $e->getMessage());
        }
    }

    private function parseCurrency($value)
    {
        if (empty($value) && $value !== '0' && $value !== 0) return 0;
        if (is_int($value) || is_float($value)) return (float) $value;

        $v = (string) $value;
        $v = preg_replace('/[^0-9\.,\-]/', '', $v);
        if (empty($v)) return 0;

        $dotCount = substr_count($v, '.');
        $commaCount = substr_count($v, ',');

        if ($dotCount > 0 && $commaCount > 0) {
            $lastDot = strrpos($v, '.');
            $lastComma = strrpos($v, ',');
            if ($lastDot > $lastComma) { $v = str_replace(',', '', $v); } 
            else { $v = str_replace('.', '', $v); $v = str_replace(',', '.', $v); }
        } elseif ($dotCount > 1) { $v = str_replace('.', '', $v); } 
        elseif ($commaCount > 1) { $v = str_replace(',', '', $v); } 
        else {
            if ($commaCount === 1) {
                $parts = explode(',', $v);
                $v = strlen($parts[1]) === 3 ? str_replace(',', '', $v) : str_replace(',', '.', $v);
            } elseif ($dotCount === 1) {
                $parts = explode('.', $v);
                if (strlen($parts[1]) === 3) $v = str_replace('.', '', $v);
            }
        }
        return (float) $v;
    }
}
