<?php

namespace App\Modules\Auth\Domain\Exceptions;

use Exception;

class InvalidCredentialsException extends Exception
{
    public function __construct()
    {
        parent::__construct('Email atau password yang Anda masukkan salah.');
    }
}
