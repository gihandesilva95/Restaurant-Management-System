<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendOrderToKitchen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:send-to-kitchen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Orders send to the kitchen based on their configured Send to Kitchen Times';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        try {
            $now = now();
    
            $orders = Order::where('status', 'Pending')
                ->whereNotNull('send_to_kitchen_time')
                ->where('send_to_kitchen_time', '<=', $now)
                ->get();
    
            foreach ($orders as $order) {
                $order->status = 'In-Progress';
                $order->save();
            }
    
            Log::info("Order #{$order->id} send to the kitchen.");
            $this->info($orders->count() . " Orders send to the kitchen");
    
        } catch (\Throwable $e) {
            Log::error("SendOrderToKitchen failed: " . $e->getMessage());
        }
    }
}

