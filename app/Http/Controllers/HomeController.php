<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    
    public function index() {
        $messages = Message::where('user_id', Auth::id())->latest()->get();
        return view('home', compact('messages'));
    }


    public function sendMessage(Request $request) {
        $request->validate([
            'subject' => 'required|max:255',
            'content' => 'required',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'content' => $request->content,
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Message sent successfully!');
    }
}