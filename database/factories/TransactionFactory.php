<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Webservice model name of factory
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * fields of model should set into database
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'webservice_id' => WebserviceFactory::class,
            'amount' => $this->faker->randomFloat(null, 1000, 10000),
            'type' => array_rand(array_values(Transaction::TYPES)),
        ];
    }
}
