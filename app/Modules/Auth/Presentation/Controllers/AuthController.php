<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Application\DTOs\LoginDTO;
use App\Modules\Auth\Application\Services\AuthService;
use App\Modules\Auth\Domain\Exceptions\InvalidCredentialsException;
use App\Modules\Auth\Presentation\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function showLogin(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->intended('/dashboard');
        }

        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            $dto = LoginDTO::fromRequest($request->validated());
            $this->authService->login($dto, $request->ip());
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        } catch (InvalidCredentialsException $e) {
            return back()->withErrors(['email' => $e->getMessage()])->withInput($request->only('email'));
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout($request);
        return redirect()->route('login');
    }
}
