<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\Pinjaman;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AngsuranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all loans of the user, then get angsurans for those loans.
        $userId = Auth::id();
        $angsurans = Angsuran::with('pinjaman')->whereHas('pinjaman', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->latest()->get();

        $informasis = Informasi::active()
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.angsurans.index', compact('angsurans', 'informasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $userId = Auth::id();
        // Get active loans
        $pinjamans = Pinjaman::where('user_id', $userId)
            ->where('status', 'disetujui') // Only approved
            // ->where('status', '!=', 'lunas') // Logic for completed?
            ->get();
            
        // Preselect if pinjaman_id is passed
        $selectedPinjamanId = $request->query('pinjaman_id');

        return view('user.angsurans.create', compact('pinjamans', 'selectedPinjamanId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pinjaman_id' => 'required|exists:pinjamans,id',
            'jumlah_bayar' => 'required|numeric|min:1000',
            'angsuran_ke' => 'required|integer|min:1',
        ]);

        // Verify ownership
        $pinjaman = Pinjaman::findOrFail($request->pinjaman_id);
        if ($pinjaman->user_id !== Auth::id()) {
            abort(403);
        }

        Angsuran::create([
            'pinjaman_id' => $request->pinjaman_id,
            'angsuran_ke' => $request->angsuran_ke,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => now(),
            'status' => 'lunas', // Payment status
        ]);

        return redirect()->route('angsurans.index')->with('success', 'Pembayaran angsuran berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Angsuran $angsuran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Angsuran $angsuran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Angsuran $angsuran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Angsuran $angsuran)
    {
        //
    }
}
