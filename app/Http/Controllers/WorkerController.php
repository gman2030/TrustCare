<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
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
    public function workerDashboard()
    {
        $currentWorker = Auth::user()->name;

        $tasks = Message::where('worker_name', $currentWorker)
            ->whereNotIn('status', ['Completed', 'completed', 'COMPLETED'])
            ->with('user')
            ->latest()
            ->get();

        foreach ($tasks as $task) {
            $parts = explode(': ', $task->subject);
            $task->extracted_sn = isset($parts[1]) ? trim($parts[1]) : 'N/A';
        }

        return view('worker.dashboard', compact('tasks'));
    }

    // قبول المهمة
    public function acceptTask($id)
    {
        $message = Message::findOrFail($id);
        $message->update(['status' => 'Accepted']);

        return back()->with('success', 'Task accepted. You can start working now.');
    }

    // إتمام المهمة (تغيير الحالة لتختفي من القائمة ولكن تبقى في قاعدة البيانات)
    public function completeTask($id)
    {
        $message = Message::findOrFail($id);
        $message->update(['status' => 'COMPLETED']);

        return back()->with('success', 'Task marked as completed and moved to archive.');
    }

    // مسح المهمة نهائياً (حذف من قاعدة البيانات)
    public function destroyTask($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return back()->with('success', 'Task has been permanently deleted.');
    }
    // جلب وعرض قطع الغيار للعامل فقط (عرض فقط)
    public function sparePage()
    {
        $products = \App\Models\Product::all();
        return view('worker.spare', compact('products'));
    }
    public function searchProduct($sn)
    {
        // البحث عن القطعة بواسطة الرقم التسلسلي
        $product = Product::where('sn', $sn)->first();

        if (!$product) {
            return response()->json(['error' => 'No parts found for this serial number.'], 404);
        }

        // إرجاع البيانات بصيغة JSON ليفهمها كود الـ JavaScript في الصفحة
        return response()->json($product);
    }
}
