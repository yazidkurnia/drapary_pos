<?php

namespace App\Modules\Auth\Domain\UseCases;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutUseCase
{
    public function execute(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
