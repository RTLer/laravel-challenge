<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

/**
 * Class BaseRequestValidator
 * @package App\Http\Requests
 */
class BaseRequestValidator  extends FormRequest
{

    /**
     * @return array
     * @throws ValidationException
     */
    public function validatedByRules(): array
    {
        return array_merge($this->validator->validated(),$this->only(array_keys($this->rules())) );
    }
}
