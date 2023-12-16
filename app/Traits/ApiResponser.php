<?php

namespace App\Traits;

use function PHPUnit\Framework\isEmpty;

trait ApiResponser
{

    public function successResponce($data, $statusCode)
    {
        return response()->json([
            'StatusMessage'     =>      'Success',
            'Message'           =>      'Your request has been successfully sent.',
            'Data'              =>      isEmpty($data) ? 'There is no information' : $data,
        ],$statusCode);
    }

}
