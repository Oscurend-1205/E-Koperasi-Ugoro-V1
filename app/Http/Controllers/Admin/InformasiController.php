<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformasiController extends Controller
{
    public function index()
    {
        $informasis = Informasi::with('author')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.informasi.index', compact('informasis'));
    }

    public function create()
    {
        return view('admin.informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
        ]);

        Informasi::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'category' => $request->input('category'),
            'is_pinned' => $request->has('is_pinned'),
            'is_active' => $request->has('is_active'),
            'published_at' => now(),
            'author_id' => Auth::id() ?: 1,
        ]);

        return redirect()->route('admin.informasi.index')->with('success', 'Informasi berhasil dipublikasikan!');
    }

    public function edit(Informasi $informasi)
    {
        return view('admin.informasi.edit', compact('informasi'));
    }

    public function update(Request $request, Informasi $informasi)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
        ]);

        $informasi->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'category' => $request->input('category'),
            'is_pinned' => $request->has('is_pinned'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.informasi.index')->with('success', 'Informasi berhasil diperbarui!');
    }

    public function destroy(Informasi $informasi)
    {
        $informasi->delete();

        return redirect()->route('admin.informasi.index')->with('success', 'Informasi berhasil dihapus!');
    }

    public function togglePin(Informasi $informasi)
    {
        $informasi->update(['is_pinned' => !$informasi->is_pinned]);

        return back()->with('success', $informasi->is_pinned ? 'Informasi di-pin!' : 'Pin informasi dicabut.');
    }

    public function toggleActive(Informasi $informasi)
    {
        $informasi->update(['is_active' => !$informasi->is_active]);

        return back()->with('success', $informasi->is_active ? 'Informasi diaktifkan!' : 'Informasi dinonaktifkan.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $path = $request->file('image')->store('informasi-images', 'public');

        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $path),
        ]);
    }
}
