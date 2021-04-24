<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($this->isAPI($request)) {
            return $this->handleAPIException($request,$e);
        }

        return parent::render($request, $e);
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse
     * @throws Throwable
     */
    protected function handleAPIException($request, Throwable $e)
    {

        if ($e instanceof ValidationException) {
            return $this->errorResponse($e->errors(), $e->getMessage(), 422);
        }
        return parent::render($request, $e);
    }

    private function isAPI($request): bool
    {
        return  $request->getContentType() && strpos($request->getRequestUri(), 'api') !== false;
    }
}
