<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $simpanans = $user->simpanans()->latest()->get();
        
        $totalPokok = $simpanans->where('jenis_simpanan', 'Pokok')->sum('jumlah');
        $totalWajib = $simpanans->where('jenis_simpanan', 'Wajib')->sum('jumlah');
        $totalSukarela = $simpanans->where('jenis_simpanan', 'Sukarela')->sum('jumlah');
        $totalMonosuko = $simpanans->where('jenis_simpanan', 'Monosuko')->sum('jumlah');
        $totalDPU = $simpanans->where('jenis_simpanan', 'DPU')->sum('jumlah');
        
        $totalSimpanan = $simpanans->sum('jumlah');

        // Targets Logic
        $targetPokok = 100000; // Contoh: Simpanan pokok wajib 100rb (bayar sekali di awal)
        $persenPokok = $targetPokok > 0 ? min(100, round(($totalPokok / $targetPokok) * 100)) : 100;

        // Wajib: 20rb x bulan keanggotaan
        $monthsActive = max(1, $user->created_at->diffInMonths(now()) + 1);
        $targetWajib = $monthsActive * 20000; 
        $persenWajib = $targetWajib > 0 ? min(100, round(($totalWajib / $targetWajib) * 100)) : 100;

        // Monosuko & DPU: Misalnya target fiktif 500rb
        $targetMonosuko = 500000;
        $persenMonosuko = min(100, round(($totalMonosuko / $targetMonosuko) * 100));

        $targetDPU = 250000;
        $persenDPU = min(100, round(($totalDPU / $targetDPU) * 100));

        // Sukarela: Target 1jt
        $targetSukarela = 1000000;
        $persenSukarela = min(100, round(($totalSukarela / $targetSukarela) * 100));

        $informasis = Informasi::active()
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // ── Chart Logic: 6 Bulan Pertumbuhan Simpanan ──
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
        $cumulativeTotal = $user->simpanans()->where('tanggal_transaksi', '<', $sixMonthsAgo)->sum('jumlah');
        
        $chartMonths = [];
        for ($i = 5; $i >= 0; $i--) {
            $targetMonth = now()->subMonths($i);
            $monthKey = $targetMonth->format('Y-m');
            
            $monthSum = $simpanans->filter(function($tx) use ($monthKey) {
                return \Carbon\Carbon::parse($tx->tanggal_transaksi)->format('Y-m') === $monthKey;
            })->sum('jumlah');
            
            $cumulativeTotal += $monthSum;
            
            $chartMonths[] = [
                'label' => $targetMonth->translatedFormat('M'),
                'total' => $cumulativeTotal,
            ];
        }

        $maxTotal = collect($chartMonths)->max('total');
        $maxTotal = $maxTotal > 0 ? $maxTotal : 1;
        
        foreach ($chartMonths as &$m) {
            $m['height'] = round(($m['total'] / $maxTotal) * 100);
            
            // Format to jutaan (e.g. Rp 2.5jt)
            if ($m['total'] >= 1000000) {
                $m['formatted'] = 'Rp ' . number_format($m['total'] / 1000000, 1, ',', '.') . 'jt';
            } elseif ($m['total'] > 0) {
                $m['formatted'] = 'Rp ' . number_format($m['total'] / 1000, 0, ',', '.') . 'rb';
            } else {
                $m['formatted'] = 'Rp 0';
            }
            
            $m['is_current'] = $m['label'] === now()->translatedFormat('M');
        }
        unset($m);

        $firstMonthTotal = $chartMonths[0]['total'];
        $lastMonthTotal = end($chartMonths)['total'];
        $growthPercentage = $firstMonthTotal > 0 ? (($lastMonthTotal - $firstMonthTotal) / $firstMonthTotal) * 100 : ($lastMonthTotal > 0 ? 100 : 0);
        $growthText = ($growthPercentage > 0 ? '+' : '') . number_format($growthPercentage, 1, ',', '.') . '%';
        $growthDir = $growthPercentage >= 0 ? 'up' : 'down';

        return view('user.simpanans.simpanan', compact(
            'simpanans', 'totalSimpanan', 'totalPokok', 'totalWajib', 'totalSukarela', 'totalMonosuko', 'totalDPU',
            'persenPokok', 'persenWajib', 'persenMonosuko', 'persenDPU', 'persenSukarela', 'informasis',
            'chartMonths', 'growthText', 'growthDir'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.simpanans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_simpanan' => 'required|in:Pokok,Wajib,Sukarela,Monosuko,DPU',
            'jumlah' => 'required|numeric|min:1000',
            'keterangan' => 'nullable|string',
        ]);

        Simpanan::create([
            'user_id' => Auth::id(),
            'jenis_simpanan' => $request->jenis_simpanan,
            'jumlah' => $request->jumlah,
            'tanggal_transaksi' => now(),
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('simpanans.index')->with('success', 'Simpanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Simpanan $simpanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Simpanan $simpanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Simpanan $simpanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Simpanan $simpanan)
    {
        //
    }
}
