<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


if(!function_exists('validatedData'))
{
    function validatedData($data, $rules)
    {
        return Validator::make($data, $rules);
    }
}

if(!function_exists('generateFileNameImages'))
{
    function generateFileNameImages($fileImage)
    {
        return Carbon::now()->microsecond . "." . $fileImage->extension();
    }
}


if(!function_exists('upload_image'))
{
    function upload_image($request_image, $env_path_name ,$imageName)
    {
        return $request_image->storeAs(env('IMAGE_UPLOAD_PATH') . DIRECTORY_SEPARATOR . $env_path_name , $imageName , 'public');
    }
}
