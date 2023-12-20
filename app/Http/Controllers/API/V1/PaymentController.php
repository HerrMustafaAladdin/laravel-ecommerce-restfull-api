<?php

namespace App\Http\Controllers\API\V1;

use App\Models\API\V1\Product;
use App\Models\API\V1\Transaction;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends ApiController
{
    use ApiResponser;

    public function send(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'user_id'                       =>  'required',
            'order_items'                   =>  'required',
            'order_items.*.product_id'      =>  'required|integer',
            'order_items.*.quantity'        =>  'required|integer',
            'request_from'                  =>  'required'
        ]);

        if($validator->fails()){
            return $this->errorResponce($validator->messages(),422);
        }

        $totalAmount  = 0;
        $delivery_amount = 0;
        foreach ($request->order_items as $order_item)
        {
            $product = Product::findOrfail($order_item['product_id']);
            if($product->quantity < $order_item['quantity'])
            {
                return $this->errorResponce("The product quantity is incorrect",422);
            }

            $totalAmount += $product->price * $order_item['quantity'];
            $delivery_amount += $product->delivery_amount;
        }

        $paying_amount = $totalAmount + $delivery_amount;

        $amounts = [
            'total_amount'       =>  $totalAmount,
            'delivery_amount'   =>  $delivery_amount,
            'paying_amount'     =>  $paying_amount ,
        ];

        $api = env('PAY_IR_API_KEY');
        $amount = $paying_amount."0";
        $mobile = "شماره موبایل";
        $factorNumber = "شماره فاکتور";
        $description = "توضیحات";
        $redirect = env('PAY_IR_CALLBACK_URL');
        $result = $this->sendRequest($api, $amount, $redirect, $mobile, $factorNumber, $description);
        $result = json_decode($result);

        if ($result->status) {

            OrderController::create($request, $amounts, $result->token);

            $go = "https://pay.ir/pg/$result->token";
            return $this->successResponce([
                'URL'   =>  $go
            ],200);
        } else {
            return $this->errorResponce($result->errorMessage,422);
        }
    }


    public function verify(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'token'                         =>  'required',
        ]);

        if($validator->fails()){
            return $this->errorResponce($validator->messages(),422);
        }

        $api = env('PAY_IR_API_KEY');
        $token = $request->token;
        $result = json_decode($this->verifyRequest($api,$token));
        if(isset($result->status)){
            if($result->status == 1)
            {
                if(Transaction::query()->where('trans_id', $result->transId)->exists())
                {
                    return $this->errorResponce('This transaction has already been registered',422);
                }
                OrderController::update($token, $result->transId);
                return $this->successResponce('The transaction was successfully registered', 200);
            }else
            {
                return $this->errorResponce('The transaction encountered an error',422);
            }
        } else {
            if($request->status == 0){
                return $this->errorResponce('The transaction encountered an error',422);
            }
        }
    }


    public function sendRequest($api, $amount, $redirect, $mobile = null, $factorNumber = null, $description = null) {
        return $this->curl_post('https://pay.ir/pg/send', [
            'api'          => $api,
            'amount'       => $amount,
            'redirect'     => $redirect,
            'mobile'       => $mobile,
            'factorNumber' => $factorNumber,
            'description'  => $description,
        ]);
    }

    public function verifyRequest($api, $token) {
        return $this->curl_post('https://pay.ir/pg/verify', [
            'api' 	=> $api,
            'token' => $token,
        ]);
    }

    public function curl_post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

}
