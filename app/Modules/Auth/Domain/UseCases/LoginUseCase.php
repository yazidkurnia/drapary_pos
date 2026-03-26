<?php

namespace App\Modules\Auth\Domain\UseCases;

use App\Modules\Auth\Application\DTOs\LoginDTO;
use App\Modules\Auth\Domain\Events\UserLoggedIn;
use App\Modules\Auth\Domain\Exceptions\InvalidCredentialsException;
use App\Modules\Auth\Domain\Repositories\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginUseCase
{
    public function __construct(private AuthRepositoryInterface $authRepository) {}

    public function execute(LoginDTO $dto, string $ip): void
    {
        $throttleKey = Str::transliterate(Str::lower($dto->email).'|'.$ip);

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw new InvalidCredentialsException();
        }

        if (!Auth::attempt(['email' => $dto->email, 'password' => $dto->password], $dto->remember)) {
            RateLimiter::hit($throttleKey);
            throw new InvalidCredentialsException();
        }

        RateLimiter::clear($throttleKey);
        event(new UserLoggedIn(Auth::user()));
    }
}
