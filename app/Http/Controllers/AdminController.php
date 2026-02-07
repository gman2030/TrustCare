<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * --- قسم الأدمن (Admin Section) ---
     */

    // عرض جميع الطلبات للأدمن
    public function dashboard()
    {
        $messages = Message::with('user')->latest()->get();

        foreach ($messages as $msg) {
            $parts = explode(': ', $msg->subject);
            $msg->extracted_sn = isset($parts[1]) ? trim($parts[1]) : 'N/A';
        }

        return view('admin.dashboard', compact('messages'));
    }

    // عرض العمال والتحكم بهم
    public function workersPage()
    {
        $workers = User::where('role', 'worker')->get();
        return view('admin.workers-control', compact('workers'));
    }

    // إسناد مهمة لعامل
    public function assignTask(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'worker_id' => 'required'
        ]);

        $worker = User::find($request->worker_id);
        $customer = User::where('name', $request->customer_name)->first();

        if (!$worker || !$customer) {
            return back()->with('error', 'Worker or Customer not found.');
        }

        $message = Message::where('user_id', $customer->id)->latest()->first();

        if ($message) {
            $message->update([
                'worker_name' => $worker->name,
                'status' => 'Assigned'
            ]);
            return back()->with('success', "Task successfully assigned to " . $worker->name);
        }

        return back()->with('error', 'No active request found for this customer.');
    }
    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);

        // منع الأدمن من مسح نفسه بالخطأ
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
