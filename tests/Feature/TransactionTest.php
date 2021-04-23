<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\Webservice;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * @return void
     */
    public function test_pos_transaction_wrong_type_request()
    {
        $this->postJson("/api/transaction/test",)
            ->assertJsonValidationErrors(['amount', 'webservice_id', 'type'])
            ->assertJsonStructure($this->responseErrorStructure())
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_accept_type_transaction_success_request()
    {
        foreach (Transaction::TYPES as $type => $key) {
            $this->createTransactionSuccess($type);
        }
    }

    /**
     * @return void
     */
    public function test_create_transaction_failed_request()
    {
        foreach (Transaction::TYPES as $type => $key) {
            $this->createTransactionSFailed($type);
        }
    }

    /**
     * @return void
     */
    public function test_get_last_month_statistics()
    {
        $response = $this->getJson('/api/transactions');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'transactions' => [ // sum of amount beetween these ranges
                    '0to5000',
                    '5000to10000',
                    '10000to100000',
                    '100000toup',
                ],
                'summary' => [
                    'amount',
                    'web_count',
                    'pos_count',
                    'mobile_count',
                ],
            ]);
    }

    private function createTransactionSuccess($type)
    {
        $this->postJson(
            "/api/transaction/{$type}",
            [
                'amount' => 10000,
                'webservice_id' => Webservice::query()->first()->id
            ]
        )
            ->assertStatus(201)
            ->assertJsonStructure($this->responseResourceStructure([
                'id',
                'created_at',
                'amount',
                'type',
                'webservice' => [
                    'id', 'name'
                ],
                'created_at'
            ]));
    }

    private function createTransactionSFailed($type)
    {
        $response = $this->postJson(
            "/api/transaction/{$type}",
        );

        $response
            ->assertJsonValidationErrors(['amount', 'webservice_id'])
            ->assertStatus(422);
    }
}
