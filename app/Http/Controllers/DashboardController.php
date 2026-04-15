<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use App\Models\Informasi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Totals
        $totalSimpanan = $user->simpanans()->sum('jumlah');
        $totalPinjaman = $user->pinjamans()->where('status', 'disetujui')->sum('jumlah_pinjaman');
        
        // Get active loans (status = disetujui means the loan is active/approved)
        $activeLoans = $user->pinjamans()->where('status', 'disetujui')->get();
        
        $sisaAngsuran = 0;
        $totalTerbayar = 0;
        $bulanTersisa = 0;

        foreach ($activeLoans as $loan) {
            $alreadyPaid = $loan->angsurans()->sum('jumlah_bayar');
            $sisaAngsuran += ($loan->jumlah_pinjaman - $alreadyPaid);
            $totalTerbayar += $alreadyPaid;
            
            $angsuranCount = $loan->angsurans()->count();
            $bulanTersisa += max(0, $loan->tenor - $angsuranCount);
        }

        $persenTerbayar = $totalPinjaman > 0 ? round(($totalTerbayar / $totalPinjaman) * 100) : 0;
        $persenSisa = $totalPinjaman > 0 ? round(($sisaAngsuran / $totalPinjaman) * 100) : 0;

        // Combined Simpanan Target Logic (Simplified for Dashboard)
        $targetTahunan = 2000000; // Contoh target 2jt per tahun
        $persenSimpanan = min(100, round(($totalSimpanan / $targetTahunan) * 100));

        // Build transactions list from simpanans and pinjamans
        $simpanans = $user->simpanans()->latest()->take(5)->get()->map(function($item) {
            return [
                'type' => 'in',
                'title' => 'Simpanan ' . $item->jenis_simpanan,
                'date' => Carbon::parse($item->tanggal_transaksi)->translatedFormat('d M Y'),
                'amount' => $item->jumlah,
                'status' => 'selesai',
                'created_at' => $item->created_at
            ];
        });

        $pinjamanTx = $user->pinjamans()->latest()->take(5)->get()->map(function($item) {
            return [
                'type' => 'out',
                'title' => 'Pengajuan Pinjaman',
                'date' => Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d M Y'),
                'amount' => $item->jumlah_pinjaman,
                'status' => $item->status,
                'created_at' => $item->created_at
            ];
        });

        $transactions = $simpanans->concat($pinjamanTx)->sortByDesc('created_at')->take(5)->values();

        // Chart data — use clone to avoid Carbon mutation from endOfMonth()
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $endOfMonth = (clone $date)->endOfMonth();
            $val = $user->simpanans()->where('tanggal_transaksi', '<=', $endOfMonth)->sum('jumlah');
            $chartData[] = [
                'month' => substr($date->translatedFormat('F'), 0, 3),
                'value' => $val > 0 ? $val : 0
            ];
        }

        // Informasi from admin
        $informasis = Informasi::active()
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('user.dashboard', compact(
            'user', 'totalSimpanan', 'totalPinjaman', 'sisaAngsuran', 
            'transactions', 'persenTerbayar', 'persenSisa', 'bulanTersisa', 'chartData', 
            'persenSimpanan', 'targetTahunan', 'informasis'
        ));
    }
}
