<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class LocalDataSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        User::factory()->count(20)->create();
    }
}
