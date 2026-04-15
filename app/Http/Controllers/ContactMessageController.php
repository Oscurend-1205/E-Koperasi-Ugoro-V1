<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function create()
    {
        $messages = \App\Models\ContactMessage::where('user_id', \Illuminate\Support\Facades\Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('user.contact.create', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'type' => 'required|string|in:Pesan,Bug Report',
            'message' => 'required|string',
        ]);

        \App\Models\ContactMessage::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'subject' => $request->subject,
            'type' => $request->type,
            'message' => $request->message,
            'status' => 'Belum Dibaca',
        ]);

        return redirect()->route('contact.create')->with('success', 'Pesan Anda berhasil dikirim ke Admin!');
    }
}
