<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SparePartOrder;
use App\Notifications\NewOrderNotification;
use App\Models\User;

class AdminOrderController extends Controller
{
    public function index()
    {
        // جلب الطلبات مع بيانات العامل والمنتج وترتيبها من الأحدث
        $orders = SparePartOrder::with(['worker', 'product'])->latest()->get();
        $orders = SparePartOrder::where('status', 'pending')
            ->latest()
            ->get();
        return view('admin.orders.index', compact('orders'));
    }
    public function acceptOrder($id)
    {
        // البحث عن الطلب
        $order = SparePartOrder::findOrFail($id);

        // تحديث الحالة إلى 'accepted' لكي يظهر عند السبلاي شاين
        $order->status = 'accepted';
        $order->save();

        return redirect()->back()->with('success', 'Order has been sent to Supply Chain!');
    }
    public function store(Request $request)
    {
        // ... كود حفظ الطلبية ...
        $order = SparePartOrder::create([
            'worker_id'  => auth()->id(),             
            'product_id' => $request->product_id,
            'items'      => json_encode($request->items),
            'status'     => 'pending',
        ]);

        // جلب المستخدم الذي يملك صلاحية الآدمن
        $admin = User::where('role', 'admin')->first();

        // إرسال الإشعار
        $admin->notify(new NewOrderNotification($order));
    }
}
