<?php

namespace Database\Seeders;

use App\Models\Service_content;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Service_ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service_content::factory(10)->create();
    }
}
