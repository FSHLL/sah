<?php

namespace App\Http\Controllers;

use App\Actions\Credential\StoreOrUpdateCredential;
use App\Http\Requests\Credential\StoreCredentialRequest;
use App\Http\Requests\Credential\UpdateCredentialRequest;
use App\Models\Credential;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class CredentialsController extends Controller
{
    public function store(StoreCredentialRequest $request, StoreOrUpdateCredential $storeCredential): RedirectResponse
    {
        $credential = $storeCredential->handle($request);

        return Redirect::route('profile.edit')->with('credential', $credential);
    }

    public function update(UpdateCredentialRequest $request, Credential $credential, StoreOrUpdateCredential $updateCredential): RedirectResponse
    {
        $credential = $updateCredential->handle($request, $credential);

        return Redirect::route('profile.edit')->with('credential', $credential);
    }

    public function destroy(Credential $credential): RedirectResponse
    {
        return Redirect::route('profile.edit')->with('credential-deleted', $credential->delete());
    }
}
