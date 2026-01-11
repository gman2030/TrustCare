<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function dashboard()
    {
        
        $tasks = Message::where('worker_name', Auth::user()->name)
                        ->latest()
                        ->get();

        return view('worker.dashboard', compact('tasks'));
    }

    public function acceptTask($id)
    {
        $task = Message::findOrFail($id);

    
        if ($task->worker_name !== Auth::user()->name) {
            return back()->with('error', 'Unauthorized action.');
        }

        
        $task->update(['status' => 'accepted']);

        return back()->with('success', 'Task accepted! You can start working on it.');
    }
}