<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user'])
            ->when($request->filled('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->filled('from_date'), function ($query) use ($request) {
                return $query->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function ($query) use ($request) {
                return $query->whereDate('created_at', '<=', $request->to_date);
            })
            ->when($request->filled('order_no'), function ($query) use ($request) {
                return $query->where('order_tracking_number', $request->order_no);
            })
            ->get();
        return view('admin.orders.index', compact('orders'));
    }
    
    public function show(Request $request)
    {
        $order = Order::with(['user', 'items'])->findOrFail($request->order_id);
        return view('admin.orders._details', compact('order'))->render();
    }


    public function update_status(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required'
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->status = $request->status;
        
        if($request->status == Order::CONFIRMED && empty($order->start_processing_at)){
            $order->start_processing_at = Carbon::now();

        }elseif($request->status == Order::PROCESSING && empty($order->packaged_at)){
            $order->packaged_at = Carbon::now();

        }elseif($request->status == Order::SHIPPED && empty($order->shipped_at)){
            $order->shipped_at = Carbon::now();

        }elseif($request->status == Order::COMPLETED && empty($order->completed_at)){
            $order->completed_at = Carbon::now();

        }

        $order->save();
        return response()->json(['message' => 'Status updated']);
    }

    public function print_invoice($id){
        $order = Order::with(['user'])->findOrFail($id);

        $groupedItems = $order->items->groupBy('product_id')
                                ->map(function ($group) {
                                    $first = $group->first();
                                    return (object)[
                                        'product'     => $first->product,
                                        'quantity'    => $group->sum('quantity'),
                                        'price'  => $first->price, // assuming unit price is same
                                        'total_price' => $group->sum(function ($item) {
                                            return $item->unit_price * $item->quantity;
                                        }),
                                    ];
                                })
                                ->values();
        return view('admin.orders.invoices', compact('order', 'groupedItems'));
    }
}
