<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = \App\Models\Karyawan::orderBy('type')->orderBy('order_num')->get();
        return view('admin.karyawan.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'type' => 'required|in:Pengurus,Pengawas,Karyawan',
            'nip' => 'nullable|string|max:255',
            'status' => 'required|string',
            'bio' => 'nullable|string',
            'order_num' => 'nullable|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('karyawan-photos', 'public');
        }

        \App\Models\Karyawan::create($data);

        return redirect()->route('karyawans.index')->with('success', 'Anggota struktur berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $karyawan = \App\Models\Karyawan::findOrFail($id);
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $karyawan = \App\Models\Karyawan::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'type' => 'required|in:Pengurus,Pengawas,Karyawan',
            'nip' => 'nullable|string|max:255',
            'status' => 'required|string',
            'bio' => 'nullable|string',
            'order_num' => 'nullable|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($karyawan->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($karyawan->photo);
            }
            $data['photo'] = $request->file('photo')->store('karyawan-photos', 'public');
        }

        $karyawan->update($data);

        return redirect()->route('karyawans.index')->with('success', 'Data struktur berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $karyawan = \App\Models\Karyawan::findOrFail($id);
        if ($karyawan->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($karyawan->photo);
        }
        $karyawan->delete();

        return redirect()->route('karyawans.index')->with('success', 'Anggota struktur berhasil dihapus.');
    }
}
