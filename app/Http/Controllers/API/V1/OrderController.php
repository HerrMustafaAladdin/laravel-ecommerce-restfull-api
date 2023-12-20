<?php

namespace App\Http\Controllers\API\V1;

use App\Models\API\V1\Order;
use App\Models\API\V1\OrderItem;
use App\Models\API\V1\Product;
use App\Models\API\V1\Transaction;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;

class OrderController extends ApiController
{
    use ApiResponser;

    public static function create($request, $amounts, $token)
    {

        DB::beginTransaction();

        $order = Order::query()->create([
            'user_id'          =>  $request->user_id,
            'total_amount'     =>  $amounts['total_amount'],
            'delivery_amount'  =>  $amounts['delivery_amount'],
            'paying_amount'    =>  $amounts['paying_amount'],
            'status'           =>  0,
            'description'      =>  ''
        ]);

        foreach($request->order_items as $order_item)
        {
            $product = Product::findOrfail($order_item['product_id']);

            OrderItem::query()->create([
                'order_id'      =>  $order->id,
                'product_id'    =>  $product->id,
                'price'         =>  $product->price,
                'quantity'      =>  $order_item['quantity'],
                'subtotal'      =>  ($product->price * $order_item['quantity'])
            ]);
        }

        Transaction::query()->create([
            'user_id'       =>  $request->user_id,
            'order_id'      =>  $order->id,
            'amount'        =>  $amounts['paying_amount'],
            'token'         =>  $token,
            'request_from'  =>  $request->request_from,
            'trans_id'      =>  0,
            'status'        =>  0
        ]);

        DB::commit();

    }


    public static function update($token, $transId)
    {
        DB::beginTransaction();

        $transaction = Transaction::query()->where('token', $token)->firstOrFail();
        $transaction->update([
            'status'    =>  1,
            'trans_id'  =>  $transId
        ]);


        $order = Order::findOrFail($transaction->order_id);
        $order->update([
            'status'            =>  1,
            'payment_status'    =>  1
        ]);

        foreach(OrderItem::query()->where('order_id', $order->id)->get() as $order_item)
        {
            $product = Product::find($order_item->product_id);
            $product->update([
                'quantity'  =>  ($product->quantity - $order_item->quantity)
            ]);
        }

        DB::commit();
    }

}
