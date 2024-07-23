<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AWSCredential\StoreAWSCredentialRequest;
use App\Http\Requests\AWSCredential\UpdateAWSCredentialRequest;
use App\Models\AWSCredential;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class AWSCredentialController extends Controller
{
    public function index(): JsonResponse
    {
        return Response::json(
            AWSCredential::where('user_id', auth()->user()->getAuthIdentifier())->paginate()
        );
    }

    public function store(StoreAWSCredentialRequest $request): JsonResponse
    {
        return Response::json(
            AWSCredential::create([
                ...$request->validated(),
                'user_id' => auth()->user()->getAuthIdentifier(),
            ]),
            HttpResponse::HTTP_CREATED
        );
    }

    public function show(AWSCredential $aWSCredential): JsonResponse
    {
        return Response::json($aWSCredential);
    }

    public function update(UpdateAWSCredentialRequest $request, AWSCredential $aWSCredential): JsonResponse
    {
        $aWSCredential->update($request->validated());
        return Response::json(
            $aWSCredential->fresh()
        );
    }

    public function destroy(AWSCredential $aWSCredential): JsonResponse
    {
        return Response::json($aWSCredential->delete());
    }
}
