<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $pinjamans = $user->pinjamans()->latest()->get();
        // Ambil pinjaman yang sedang aktif (disetujui dan belum lunas)
        /** @var \App\Models\Pinjaman|null $pinjaman */
        $pinjaman = $user->pinjamans()
            ->where('status', 'disetujui')
            ->latest()
            ->first();

        if ($pinjaman instanceof Pinjaman) {
            $totalAngsuranTerbayar = $pinjaman->angsurans()->sum('jumlah_bayar');
            $pinjaman->sisa_pokok = max(0, (float)$pinjaman->jumlah_pinjaman - (float)$totalAngsuranTerbayar);
            
            $pokokPerBulan = $pinjaman->tenor > 0 ? ((float)$pinjaman->jumlah_pinjaman / (float)$pinjaman->tenor) : 0;
            $bungaBulan = (float)($pinjaman->bunga ?? 0);
            $bungaNominal = (float)$pinjaman->jumlah_pinjaman * ($bungaBulan / 100);
            
            $pinjaman->angsuran = $pokokPerBulan + $bungaNominal;
        }

        $informasis = Informasi::active()
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.pinjamans.index', compact('pinjamans', 'pinjaman', 'informasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.pinjamans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jumlah_pinjaman' => 'required|numeric|min:50000',
            'tenor' => 'required|integer|min:1|max:60', // months
            'keterangan' => 'nullable|string',
        ]);

        // Simple calculation logic (e.g., just principal / tenor)
        // Or adding interest. Let's keep it simple: 0 interest for now or small fee.
        // Prompt did not specify interest rate.
        
        Pinjaman::create([
            'user_id' => Auth::id(),
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'tenor' => $request->tenor,
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pinjamans.index')->with('success', 'Pengajuan pinjaman berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pinjaman $pinjaman)
    {
        // Maybe show details + installment schedule?
        return view('user.pinjamans.show', compact('pinjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pinjaman $pinjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pinjaman $pinjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pinjaman $pinjaman)
    {
        //
    }
}
