<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\Town;
use App\Models\Barangay;

class PSGCSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Example seed data
        $province = Province::create(['province_id' => 1, 'name' => 'Bohol']);
        $town = Town::create(['town_id' => 1, 'province_id' => 1, 'name' => 'Tagbilaran City']);
        Barangay::create(['barangay_id' => 1, 'town_id' => 1, 'name' => 'Cogon']);
    }
}
