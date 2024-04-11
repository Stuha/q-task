<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\Interfaces\ClientServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        private readonly ClientServiceInterface $client,
        private readonly User $user)
    {}

    public function index(): View
    {
        return view('auth/login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $params = $request->validated();
        $responseContent = $this->client->login($params['email'], $params['password']);

        if (is_array($responseContent)) {
            return redirect()->route('home')->withErrors($responseContent);
        }

        $this->user->fill((array) $responseContent->user);
        $this->user->setRememberToken($responseContent->token_key);

        session(['token' => $responseContent->token_key]);
        session(['user' => $this->user]);

        return redirect()->route('dashboard');
    }

    public function logout(): RedirectResponse
    {
        session()->forget('token');
        session()->forget('user');

        return redirect()->route('home');
    }
}
