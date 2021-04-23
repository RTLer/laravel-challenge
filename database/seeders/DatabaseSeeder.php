<?php

namespace Database\Seeders;

use App\Models\Webservice;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Webservice::factory()
            ->hasTransactions(5000)->
            create();
    }
}
