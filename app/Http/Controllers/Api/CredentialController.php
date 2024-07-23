<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Credential\StoreCredentialRequest;
use App\Http\Requests\Credential\UpdateCredentialRequest;
use App\Models\Credential;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class CredentialController extends Controller
{
    public function index(): JsonResponse
    {
        return Response::json(
            Credential::where('user_id', auth()->user()->getAuthIdentifier())->paginate()
        );
    }

    public function store(StoreCredentialRequest $request): JsonResponse
    {
        return Response::json(
            Credential::create([
                ...$request->validated(),
                'user_id' => auth()->user()->getAuthIdentifier(),
            ]),
            HttpResponse::HTTP_CREATED
        );
    }

    public function show(Credential $credential): JsonResponse
    {
        return Response::json($credential);
    }

    public function update(UpdateCredentialRequest $request, Credential $credential): JsonResponse
    {
        $credential->update($request->validated());
        return Response::json(
            $credential->fresh()
        );
    }

    public function destroy(Credential $credential): JsonResponse
    {
        return Response::json($credential->delete());
    }
}
