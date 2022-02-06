<?php

namespace Database\Seeders;

use App\Models\Card;
use Database\Factories\CardFactory;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Card::factory()
            ->count(50)
            ->create();
    }
}
