<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Concession;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('concessions')->latest()->paginate(5);
        
        return view('orders.index', compact('orders'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $concessions = Concession::all();
        return view('orders.create', compact('concessions'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        $validated = $request->validate([
            'concessions' => 'required|array',
            'concessions.*' => 'exists:concessions,id',
            'send_to_kitchen_time' => 'required|date|after_or_equal:now',
        ]);

        // Generate order_no
        $today = Carbon::now()->format('ymd');
        $prefix = 'ON' . $today;

        $latestOrder = Order::where('order_no', 'like', $prefix . '%')->orderBy('order_no', 'desc')->first();

        if ($latestOrder) {
            $lastSeq = (int) substr($latestOrder->order_no, -3);
            $nextSeq = str_pad($lastSeq + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextSeq = '001';
        }

        $order_no = $prefix . $nextSeq;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_no' => $order_no,
                'send_to_kitchen_time' => $validated['send_to_kitchen_time'],
                'status' => 'Pending',
            ]);

            $order->concessions()->attach($validated['concessions']);

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function sendToKitchen(Order $order)
    {
        if ($order->status === 'Pending') {
            $order->status = 'In-Progress';
            $order->save();

            return redirect()->route('orders.index')->with('success', 'Order sent to kitchen successfully.');
        }

        return redirect()->route('orders.index')->with('error', 'Order cannot be sent to kitchen.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->concessions()->detach();
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }
}
