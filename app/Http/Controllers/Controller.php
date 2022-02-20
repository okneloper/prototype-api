<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Returns a 'Successful' response
     */
    public function success(array $data = null): JsonResponse
    {
        return new JsonResponse($data);
    }

    /**
     * Returns a 'Created' response
     */
    public function created(array|Jsonable $data = null): JsonResponse
    {
        return new JsonResponse($data, 201);
    }

    public function validationFailed(array $errors = [])
    {
        return new JsonResponse([
            'errors' => $errors,
        ], 422);
    }
}
