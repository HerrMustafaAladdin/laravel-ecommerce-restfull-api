<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\AuthResponce;
use App\Models\API\V1\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'          =>  'required|min:3|max:100|string',
            'email'         =>  'required|email|min:5|max:255',
            'address'       =>  'required|min:10|max:255|string',
            'cellphone'     =>  'required|min:10|max:255|string',
            'province_id'   =>  'required|integer',
            'city_id'       =>  'required|integer',
            'password'      =>  'required|string|min:8|max:60',
            'c_password'    =>  'required|string|same:password'
        ]);

        if($validator->fails())
        {
            return $this->errorResponce($validator->messages(), 422);
        }


        $user = User::create([
            'name'          =>      $request->input('name'),
            'email'         =>      $request->input('email'),
            'address'       =>      $request->input('address'),
            'cellphone'     =>      $request->input('cellphone'),
            'province_id'   =>      $request->input('province_id'),
            'city_id'       =>      $request->input('city_id'),
            'password'      =>      Hash::make($request->password),
        ]);

        $user->save();

        $token = $user->createToken(env('APP_NAME'))->plainTextToken;

        return $this->successResponce([
            'User Details'  =>  $user,
            'Token'         =>  $token
        ],201);

    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'         =>  'required|email|min:5|max:255',
            'password'      =>  'required|string|min:8|max:60',
        ]);

        if($validator->fails())
        {
            return $this->errorResponce($validator->messages(), 422);
        }

        $user = User::query()->where('email',$request->email)->first();

        if(!$user)
        {
            return $this->errorResponce('User Not Found !', 422);
        }

        if(! Hash::check($request->password, $user->password))
        {
            return $this->errorResponce('User Not Found !', 422);
        }

        $token = $user->createToken(env('APP_NAME'))->plainTextToken;

        return $this->successResponce([
            'User Details'  =>  $user,
            'Token'         =>  $token
        ],200);
    }

}
