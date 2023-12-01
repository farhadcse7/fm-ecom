<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['billing', 'orderdetails'])->latest('id')->paginate(15);
        return view('backend.pages.order.index', compact('orders'));
    }
}
