<?php

namespace App\Traits;

trait ApiResponser
{

    public function successResponce($data, $statusCode)
    {
        return response()->json([
            'StatusMessage'     =>      'Success',
            'Message'           =>      'Your request has been successfully sent.',
            'Data'              =>      $data,
        ],$statusCode);
    }

    public function errorResponce($errorMessage, $statusCode)
    {
        return response()->json([
            'StatusMessage'     =>      'Error',
            'Message'           =>      $errorMessage,
        ],$statusCode);
    }

    public function deleteResponce($statusCode)
    {
        return response()->json([
            'StatusMessage'     =>      'Delete',
            'Message'           =>      'The deletion was successful.',
        ],$statusCode);
    }

}
