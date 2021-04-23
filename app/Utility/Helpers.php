<?php

use App\Http\Resources\ResourceCollectionBase;

if (!function_exists('response_resource')) {
    function response_resource($resource, $collect, $collect_param = []): ResourceCollectionBase
    {
        return new ResourceCollectionBase($resource, $collect, $collect_param);
    }
}
