<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {

        $messages = Message::where('user_id', Auth::id())->latest()->get();
        return view('home', compact('messages'));
    }


    public function searchProduct($sn) {
    $product = Product::where('serial_number', $sn)->first();

    if ($product) {
        return response()->json([
            'success' => true,
            'product' => [
                'name' => $product->name,
                // تغيير المسار هنا من storage إلى uploads/products
                'image' => $product->image ? asset('uploads/products/' . $product->image) : asset('assets/no-image.png')
            ]
        ]);
    }
    return response()->json(['success' => false]);
}


public function sendMessage(Request $request) {
    // التحقق من الحقول
    $request->validate([
        'warranty_image' => 'required|image|mimes:jpeg,png,jpg,jfif|max:10240', // زدنا الحجم لـ 10 ميجا
        'serial_number'  => 'required|string',
        'content'        => 'required|min:3',
    ]);

    $path = null;
    if ($request->hasFile('warranty_image')) {
        // تخزين الصورة باسم فريد في مجلد warranties
        $path = $request->file('warranty_image')->store('warranties', 'public');
    }

    // حفظ في قاعدة البيانات
    Message::create([
        'user_id'        => auth()->id(),
        'subject'        => "Maintenance: " . $request->serial_number,
        'content'        => $request->content,
        'warranty_image' => $path, // تأكد أن الاسم يطابق اسم العمود في الجدول
        'status'         => 'pending',
    ]);

    return back()->with('success', 'Your request has been successfully submitted !');
}
}
