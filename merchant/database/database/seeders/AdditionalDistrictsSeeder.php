<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdditionalDistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing states
        $bihar = State::where('name', 'Bihar')->first();
        $jharkhand = State::where('name', 'Jharkhand')->first();
        $tamilNadu = State::where('name', 'Tamil Nadu')->first();
        $andhraPradesh = State::where('name', 'Andhra Pradesh')->first();
        $karnataka = State::where('name', 'Karnataka')->first();

        // Add missing districts for cities from dealer data
        if ($andhraPradesh) {
            District::firstOrCreate([
                'name' => 'Rayachoti',
                'state_id' => $andhraPradesh->id,
            ], ['is_active' => true]);
            
            District::firstOrCreate([
                'name' => 'Madanapalli',
                'state_id' => $andhraPradesh->id,
            ], ['is_active' => true]);
        }

        if ($karnataka) {
            District::firstOrCreate([
                'name' => 'Kudligi Town',
                'state_id' => $karnataka->id,
            ], ['is_active' => true]);
        }
    }
}
