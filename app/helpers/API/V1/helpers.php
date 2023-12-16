<?php

use App\Http\Controllers\API\V1\ApiController;
use Illuminate\Support\Facades\Validator;


if(!function_exists('validatedData'))
{
    function validatedData($data, $rules)
    {
        return Validator::make($data, $rules);
    }
}
