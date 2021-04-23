<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class TransactionController
 * @author Navid Safavi
 * @package App\Http\Controllers\API
 */
class TransactionController extends Controller
{
    /**
     * List of transaction
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->successResponse([]);
    }

    /**
     * Create transaction by type
     *
     * @param $type
     *
     * @return JsonResponse
     */
    public function create($type): JsonResponse
    {
        return $this->successResponse(['type'=> $type]);
    }
}
