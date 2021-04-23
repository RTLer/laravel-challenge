<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TransactionResource
 * @package App\Http\Resources
 *
 * @mixin Transaction
 */
class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'webservice_id' => $this->webservice_id,
            'amount' => $this->amount,
            'type' => $this->type_name,
            'webservice' => new WebserviceResource($this->webservice),
            'created_at' => $this->created_at
        ];
    }
}
