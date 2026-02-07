<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Routing\Controllers\HasMiddleware; // سطر جديد
use Illuminate\Routing\Controllers\Middleware;    // سطر جديد

class Supplychain_controller extends Controller
{

    public function index()
    {
        if (trim(Auth::user()->role) !== 'supply') {
            abort(403, 'Your role is: "' . Auth::user()->role . '" but we need "supply"');
        }
        if (Auth::user()->role !== 'supply') {
            abort(403, 'Your role is: ' . Auth::user()->role . ' but you need to be supply');
        }

        $products = Product::latest()->get();
        return view('supplychain.supply_chain', compact('products'));
    }
    // لفتح صفحة الإضافة
    public function create()
    {
        return view('Supplychain.add_product');
    }

    // لحفظ المنتج والعودة للمخزن
    public function store(Request $request)
    {
        // 1. التحقق من صحة البيانات المدخلة
        $request->validate([
            'name' => 'required|max:255',
            'serial_number' => 'required|unique:products,serial_number', // للتأكد من عدم تكرار الرقم التسلسلي
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // 2. إنشاء كائن جديد من موديل المنتج
        $product = new \App\Models\Product();
        $product->name = $request->name;
        $product->serial_number = $request->serial_number;
        $product->price = 0;    // قيمة افتراضية
        $product->quantity = 0; // قيمة افتراضية

        // 3. معالجة ورفع الصورة إذا وجدت
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }

        // 4. الحفظ في قاعدة البيانات
        $product->save();

        // 5. إعادة التوجيه لجدول المخزون مع رسالة نجاح
        return redirect()->route('supply.dashboard')->with('success', 'Product registered successfully!');
    }

    public function updateStock($id, $action)
    {
        $product = Product::findOrFail($id);

        if ($action == 'increase') {
            $product->increment('quantity');
        } elseif ($action == 'decrease' && $product->quantity > 0) {
            $product->decrement('quantity');
        }

        return back()->with('success', 'Stock updated!');
    }
    public function edit($id)
    {
         $product = Product::with('spareParts')->findOrFail($id);

        // فتح صفحة التعديل (تأكد من اسم الملف edit.blade.php)
        return view('supplychain.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // تحديث البيانات مع التأكد من أسماء الحقول
        $product->name     = $request->input('name');
        $product->serial_number  = $request->input('sn');
        $product->price    = $request->input('price', 0); // إذا لم تصل القيمة يضع 0
        $product->quantity = $request->input('quantity', 0);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }

        $product->save();
        return redirect()->route('supply.dashboard')->with('success', 'Updated!');
    }

}
