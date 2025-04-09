<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class KitchenController extends Controller
{

    public function index()
    {
        $orders = Order::with('concessions')
            ->whereIn('status', ['In-Progress', 'Pending'])
            ->orderBy('send_to_kitchen_time')
            ->paginate(5);

        return view('kitchen.index', compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function completeOrder(Order $order)
    {
        if ($order->status === 'In-Progress') {
            $order->status = 'Completed';
            $order->save();

            return redirect()->route('kitchen.index')->with('success', 'Order is Compeleted.');

        } else{
            return redirect()->route('kitchen.index')->with('error', 'Order cannot be Compelete.');
        }


        return redirect()->route('kitchen.index')->with('error', 'Order cannot be Compelete.');
    }
    
}
