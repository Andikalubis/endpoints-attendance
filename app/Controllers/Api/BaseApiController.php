<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class BaseApiController extends ResourceController
{
    protected $format = 'json';

    protected function success($data = [], $message = 'Success', $code = 200)
    {
        return $this->respond([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($message = 'Error', $code = 400)
    {
        return $this->respond([
            'status' => $code,
            'error' => $message
        ], $code);
    }
}
