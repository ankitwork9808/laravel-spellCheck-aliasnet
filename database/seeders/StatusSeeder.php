<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::insert([
            [
                'name' => 'Eingereicht',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'In Bearbeitung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Abgeschlossen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ablehnen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
