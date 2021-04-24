<?php

namespace Database\Factories;

use App\Models\Webservice;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebserviceFactory extends Factory
{
    /**
     * Webservice model name of factory
     *
     * @var string
     */
    protected $model = Webservice::class;

    /**
     * fields of model should set into database
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
