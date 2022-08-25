<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Arr;

class I3dnetClientException extends Exception
{

    public function __construct($data)
    {
        parent::__construct($this->message($data), 500);
    }

    /**
     * @param array $data
     * @return string
     */
    private function message(array $data)
    {
        $message = [
            'Error: ' . Arr::get($data, 'errorMessage'),
            'Code: ' . Arr::get($data, 'errorCode'),
        ];

        if (Arr::exists($data, 'errors') && Arr::get($data, 'errors.0')) {
            $message[] = 'Property: ' . Arr::get($data, 'errors.0.property');
            $message[] = 'Message: ' . Arr::get($data, 'errors.0.message');
        };

        return join("\n",$message);
    }
}
