<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    
    public function dashboard() {
        $messages = Message::with('user')->latest()->get();
        return view('admin.dashboard', compact('messages'));
    }


    public function assignWorker(Request $request, $id) {
        $message = Message::findOrFail($id);
        $message->update([
            'worker_name' => $request->worker_name,
            'status' => 'Assigned'
        ]);

        return back()->with('success', 'Worker assigned!');
    }

    
    public function deleteUser($id) {
        if (Auth::id() == $id) {
            return back()->with('error', 'You cannot delete yourself!');
        }

        User::destroy($id);
        return back()->with('success', 'User removed successfully.');
    }
}