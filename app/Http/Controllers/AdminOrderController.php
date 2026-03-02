<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SparePartOrder;
class AdminOrderController extends Controller
{
    public function index()
{
    // جلب الطلبات مع بيانات العامل والمنتج وترتيبها من الأحدث
    $orders = SparePartOrder::with(['worker', 'product'])->latest()->get();

    return view('admin.orders.index', compact('orders'));
}
}
