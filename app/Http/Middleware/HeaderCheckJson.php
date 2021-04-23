<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\JsonResponse;

class HeaderCheckJson
{
    use ApiResponse;

    /**
     * @param $request
     * @param Closure $next
     *
     * @return JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            return $next($request);
        } else {
            return $this->errorResponse([], 'Json header not set.', 400);
        }
    }
}
