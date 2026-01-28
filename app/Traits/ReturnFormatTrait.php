<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait ReturnFormatTrait
{
    protected function responseWithSuccess($message = '', $data = [], $status_code = 200)
    {
        $data['status']         = true;
        $data['status_text']    = $data['status_text'] ?? $message;
        $data['message']        = $data['message'] ?? $message;

        return [
            'status'    => true,
            'message'   => $message,
            'data'      => $data,
            'status_code'   => $status_code,
        ];
    }

    protected function responseWithError($message = '', $data = [], $status_code = 400)
    {
        $data['status']         = false;
        $data['status_text']    = $data['status_text'] ?? $message;
        $data['message']        = $data['message'] ?? $message;

        return [
            'status'    => false,
            'message'   => $message,
            'data'      => $data,
            'status_code'   => $status_code,
        ];
    }
}
