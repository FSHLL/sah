<?php

namespace App\Http\Controllers;

use App\Http\Requests\Token\StoreTokenRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Laravel\Sanctum\PersonalAccessToken;

class TokensController extends Controller
{
    public function store(StoreTokenRequest $request): RedirectResponse
    {
        $token = $request->user()->createToken($request->input('name'));

        return Redirect::route('profile.edit')->with('token', $token->plainTextToken);
    }

    public function destroy(PersonalAccessToken $token): RedirectResponse
    {
        return Redirect::route('profile.edit')->with('token-deleted', $token->delete());
    }
}
