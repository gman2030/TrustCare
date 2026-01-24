<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
   public function dashboard() {
    // جيب معلومات من db
    $messages = Message::with('user')->latest()->get();

    foreach ($messages as $msg) {
        // ns
        $parts = explode(': ', $msg->subject);
        $serial = isset($parts[1]) ? trim($parts[1]) : null;
        $msg->extracted_sn = $serial;

        //نتاع صورة المنتج
        if ($serial) {
            $product = Product::where('serial_number', $serial)->first();
            $msg->product_image = $product ? $product->image : null;
        } else {
            $msg->product_image = null;
        }
    }

    return view('admin.dashboard', compact('messages'));
}
    // تتعاود
    public function assignWorker(Request $request, $id) {
        $request->validate([
            'worker_name' => 'required|string'
        ]);

        $message = Message::findOrFail($id);
        $message->update([
            'worker_name' => $request->worker_name,
            'status' => 'Assigned' // 
        ]);

        return back()->with('success', 'Maintenance worker ' . $request->worker_name . ' has been assigned.');
    }

    // دالة حذف المستخدم (Kick)
    public function deleteUser($id) {
        // حماية: منع الأدمن من حذف نفسه
        if (Auth::id() == $id) {
            return back()->with('error', 'You cannot delete your own admin account!');
        }

        $user = User::find($id);
        if ($user) {
            $user->delete();
            return back()->with('success', 'User and all their records removed successfully.');
        }

        return back()->with('error', 'User not found.');
    }
}
