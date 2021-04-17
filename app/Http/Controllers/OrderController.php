<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    public function getOrders()
    {
        return response()->json(["orders" => Order::all()], 200);
    }

    public function createOrder(OrderRequest $request)
    {
        $order = $request->all();

        $order['invoice'] = Str::random('8');

        Order::create($order);

        return response()->json(["status" => "Order successfully created"], 200);
    }
}
