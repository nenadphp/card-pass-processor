<?php

namespace Database\Seeders;

use App\Models\ObjectModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ObjectModel::factory()->create([
            'name' => 'GeekFit',
            'object_uuid' => Hash::make('GeekFitObjectUid'),
        ]);

        ObjectModel::factory()
            ->count(50)
            ->create();
    }
}
