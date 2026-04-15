<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('info.landing_page');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

// Public route (no auth)
Route::get('/karyawan', function () {
    $pengurus = \App\Models\Karyawan::where('type', 'Pengurus')->orderBy('order_num')->get();
    $pengawas = \App\Models\Karyawan::where('type', 'Pengawas')->orderBy('order_num')->get();
    $karyawans = \App\Models\Karyawan::where('type', 'Karyawan')->orderBy('order_num')->get();
    return view('user.dataKaryawan', compact('pengurus', 'pengawas', 'karyawans'));
})->name('karyawan');

// ══════════════════════════════════════════════
// ADMIN ROUTES — Protected by auth + admin role
// ══════════════════════════════════════════════
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard & Data
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/data-anggota', [AdminController::class, 'dataAnggota'])->name('admin.dataAnggota');

    // Import
    Route::get('/import', function () { return view('admin.import.import'); })->name('admin.import');
    Route::get('/import/spreadsheet', function () { return view('admin.import.import-spreadsheet'); })->name('admin.import.spreadsheet');
    Route::get('/import/edit', function () { return view('admin.import.import_edit'); })->name('admin.import.edit');
    Route::post('/import/process', [AdminController::class, 'processImport'])->name('admin.import.process');
    
    // Draft Import Routes
    Route::get('/drafts', [App\Http\Controllers\DraftImportController::class, 'index'])->name('admin.drafts.index');
    Route::post('/drafts/store', [App\Http\Controllers\DraftImportController::class, 'store'])->name('admin.drafts.store');
    Route::get('/drafts/{draft}', [App\Http\Controllers\DraftImportController::class, 'show'])->name('admin.drafts.show');
    Route::put('/drafts/{draft}', [App\Http\Controllers\DraftImportController::class, 'update'])->name('admin.drafts.update');
    Route::delete('/drafts/{draft}', [App\Http\Controllers\DraftImportController::class, 'destroy'])->name('admin.drafts.destroy');
    // Using simple POST for row removal
    Route::post('/drafts/{draft}/remove-row', [App\Http\Controllers\DraftImportController::class, 'removeRow'])->name('admin.drafts.removeRow');
    Route::post('/drafts/{draft}/confirm', [App\Http\Controllers\DraftImportController::class, 'confirm'])->name('admin.drafts.confirm');
    Route::post('/drafts/store-manual', [App\Http\Controllers\DraftImportController::class, 'storeManual'])->name('admin.drafts.storeManual');
    Route::post('/drafts/{draft}/add-row', [App\Http\Controllers\DraftImportController::class, 'addRow'])->name('admin.drafts.addRow');

    // Excel Import Member System (As requested)
    Route::get('/import-member', [\App\Http\Controllers\MemberController::class, 'importForm'])->name('member.import.form');
    Route::post('/import-member', [\App\Http\Controllers\MemberController::class, 'importProcess'])->name('member.import.process');

    // Members CRUD
    Route::post('/members/store', function (Request $request) {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'no_anggota' => 'required|string|unique:users',
                'no_hp' => 'required|string',
                'alamat' => 'required|string',
            ]);
            
            $data['password'] = Hash::make($data['password']);
            $data['nik'] = $request->input('nik', (string) rand(1000000000000000, 9999999999999999));
            
            DB::beginTransaction();
            $user = User::create($data);
            
            \App\Models\Simpanan::create([
                'user_id' => $user->id,
                'jenis_simpanan' => 'Pokok',
                'jumlah' => 100000,
                'tanggal_transaksi' => now(),
                'keterangan' => 'Simpanan Pokok Awal Pendaftaran',
            ]);
            DB::commit();

            return redirect()->route('admin.dashboard')->with('success', 'Anggota baru berhasil didaftarkan dan data telah tersambung!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mendaftar anggota: ' . $e->getMessage());
        }
    })->name('admin.members.store');

    Route::delete('/members/{user}', [AdminController::class, 'destroyUser'])->name('admin.members.destroy');
    Route::post('/members/bulk-delete', [AdminController::class, 'bulkDestroyUsers'])->name('admin.members.bulkDestroy');
    Route::patch('/members/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.members.toggleStatus');

    // Impersonate
    Route::post('/impersonate/{user}', [AdminController::class, 'impersonate'])->name('admin.impersonate');
    Route::get('/impersonate/leave', [AdminController::class, 'leaveImpersonate'])->name('admin.impersonate.leave');

    // Simpanan
    Route::get('/input-simpanan', [AdminController::class, 'inputSimpanan'])->name('admin.inputSimpanan');
    Route::post('/input-simpanan', [AdminController::class, 'storeSimpanan'])->name('admin.storeSimpanan');

    // Pinjaman
    Route::get('/input-pinjaman', [AdminController::class, 'inputPinjaman'])->name('admin.inputPinjaman');
    Route::post('/input-pinjaman', [AdminController::class, 'storePinjaman'])->name('admin.storePinjaman');
    Route::delete('/input-pinjaman/{id}', [AdminController::class, 'destroyPinjaman'])->name('admin.destroyPinjaman');

    // Karyawan & Informasi
    Route::resource('karyawans', \App\Http\Controllers\Admin\KaryawanController::class);
    Route::post('informasi/upload-image', [\App\Http\Controllers\Admin\InformasiController::class, 'uploadImage'])->name('admin.informasi.uploadImage');
    Route::resource('informasi', \App\Http\Controllers\Admin\InformasiController::class)->names('admin.informasi');
    Route::patch('informasi/{informasi}/toggle-pin', [\App\Http\Controllers\Admin\InformasiController::class, 'togglePin'])->name('admin.informasi.togglePin');
    Route::patch('informasi/{informasi}/toggle-active', [\App\Http\Controllers\Admin\InformasiController::class, 'toggleActive'])->name('admin.informasi.toggleActive');

    // Contact Messages
    Route::get('/messages', [AdminController::class, 'messages'])->name('admin.messages');
    Route::post('/messages/{id}/read', [AdminController::class, 'markMessageRead'])->name('admin.messages.read');
    Route::post('/messages/{id}/reply', [AdminController::class, 'replyMessage'])->name('admin.messages.reply');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\SimpananController;

Route::resource('simpanans', SimpananController::class)
    ->middleware(['auth', 'verified']);

use App\Http\Controllers\ContactMessageController;

Route::get('/contact', [ContactMessageController::class, 'create'])->name('contact.create')->middleware(['auth', 'verified']);
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store')->middleware(['auth', 'verified']);

use App\Http\Controllers\PinjamanController;

Route::resource('pinjamans', PinjamanController::class)
    ->middleware(['auth', 'verified']);

use App\Http\Controllers\AngsuranController;

Route::resource('angsurans', AngsuranController::class)
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
