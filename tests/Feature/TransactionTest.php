<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\Webservice;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * @return void
     */
    public function test_pos_transaction_wrong_type_request()
    {
        $this->postJson("/api/transactions/test",)
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
    public function test_get_transactions()
    {

        $this->getJson('/api/transactions')->assertStatus(200)
            ->assertJsonStructure($this->responseResourceStructure([
                'items' => [
                    '*' => ['id', 'webservice_id', 'amount', 'type', 'webservice' => ['id', 'name'], 'created_at'],
                ]
            ]));
    }

    /**
     * @return void
     */
    public function test_get_last_month_by_id_filter_statistic()
    {
        $this->passTestByTransactionSummary('id');
    }

    /**
     * @return void
     */
    public function test_get_last_month_by_amount_filter_statistic()
    {
        $this->passTestByTransactionSummary('amount');
    }

    /**
     * @param $type
     */
    private function createTransactionSuccess($type)
    {
        $this->postJson(
            "/api/transactions/{$type}",
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

    /**
     * @param $type
     */
    private function createTransactionSFailed($type)
    {
        $response = $this->postJson(
            "/api/transactions/{$type}",
        );

        $response
            ->assertJsonValidationErrors(['amount', 'webservice_id'])
            ->assertStatus(422);
    }

    /**
     * @param $type
     */
    private function passTestByTransactionSummary($type)
    {
        $this->rangesIdOrAmount()->map(function ($range) use ($type) {

            $params = $this->generateParams($range, $type);

            $this->json('GET', '/api/transactions/summary', $params, [])->assertStatus(200)
                ->assertJsonStructure($this->responseResourceStructure([
                    'items' => [
                        '*' => ['type', 'total'],
                    ]
                ]));

        });
    }

    /**
     * @return Collection
     */
    private function rangesIdOrAmount(): Collection
    {
        return collect([
            [
                'start' => 0,
                'end' => 5000
            ], [
                'start' => 5000,
                'end' => 10000
            ],
            [
                'start' => 10000,
                'end' => 100000
            ],
            [
                'start' => 100000,
                'end' => 0
            ],
        ]);
    }

    /**
     * @param $range
     * @param $type
     * @return array
     */
    private function generateParams($range, $type): array
    {
        $paramsData = collect([]);
        $withoutEnd = $range['end'] === 0;


        $paramsData->put("{$type}_more_equal", $range['start']);
        if (!$withoutEnd) {
            $paramsData->put("{$type}_fewer", $range['end']);
        }
        return $paramsData->toArray();
    }

}
