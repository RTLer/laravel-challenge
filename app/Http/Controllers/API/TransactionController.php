<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionCreateRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionSummaryResource;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * Class TransactionController
 *
 * @package App\Http\Controllers\API
 */
class TransactionController extends Controller
{

    /**
     * @var TransactionRepositoryInterface
     */
    private $transaction_repository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transaction_repository = $transactionRepository;
    }

    /**
     * List of transaction
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->successResponse(
            response_resource(
                $this->transaction_repository->viaFilters(true),
                TransactionResource::class
            )
        );
    }

    /**
     * Calculate summary with filter of transaction
     *
     * @return JsonResponse
     */
    public function indexSummary(): JsonResponse
    {
        $separateTypeWithCount = $this->transaction_repository->summary()->get();
        $queryTotal = $this->transaction_repository->viaFilters(false)->count();

        return $this->successResponse(
            response_resource(
                $separateTypeWithCount,
                TransactionSummaryResource::class,
                [
                    'settings' => '',
                    'total_amount' => $queryTotal,
                ]
            )
        );
    }

    /**
     * Create transaction by type
     *
     * @param TransactionCreateRequest $request
     * @param $type
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(TransactionCreateRequest $request, $type): JsonResponse
    {
        return $this->successResponse(
            new TransactionResource($this->transaction_repository->create($request->validatedByRules())),
            'Transaction created',
            201
        );
    }
}
