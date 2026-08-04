<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RelevantStateDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        District::truncate();
        State::truncate();

        // Create only the states that are actually used by dealers
        $bihar = State::create([
            'name' => 'Bihar',
            'code' => 'BR',
            'is_active' => true,
        ]);

        $jharkhand = State::create([
            'name' => 'Jharkhand',
            'code' => 'JH',
            'is_active' => true,
        ]);

        $tamilNadu = State::create([
            'name' => 'Tamil Nadu',
            'code' => 'TN',
            'is_active' => true,
        ]);

        $andhraPradesh = State::create([
            'name' => 'Andhra Pradesh',
            'code' => 'AP',
            'is_active' => true,
        ]);

        $karnataka = State::create([
            'name' => 'Karnataka',
            'code' => 'KA',
            'is_active' => true,
        ]);

        // Create only the districts/cities that are actually used by dealers
        // Bihar districts
        District::create(['name' => 'Patna', 'state_id' => $bihar->id, 'is_active' => true]);

        // Jharkhand districts
        District::create(['name' => 'Ranchi', 'state_id' => $jharkhand->id, 'is_active' => true]);
        District::create(['name' => 'Jamshedpur', 'state_id' => $jharkhand->id, 'is_active' => true]);

        // Tamil Nadu districts
        District::create(['name' => 'Chennai', 'state_id' => $tamilNadu->id, 'is_active' => true]);

        // Andhra Pradesh districts
        District::create(['name' => 'Rayachoti', 'state_id' => $andhraPradesh->id, 'is_active' => true]);
        District::create(['name' => 'Madanapalli', 'state_id' => $andhraPradesh->id, 'is_active' => true]);

        // Karnataka districts
        District::create(['name' => 'Kudligi Town', 'state_id' => $karnataka->id, 'is_active' => true]);
    }
}
