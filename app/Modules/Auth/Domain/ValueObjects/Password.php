<?php

namespace App\Modules\Auth\Domain\ValueObjects;

use InvalidArgumentException;

class Password
{
    private string $value;

    public function __construct(string $password)
    {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Password minimal 8 karakter.');
        }
        $this->value = $password;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
