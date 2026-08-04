<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create States
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

        // Create Districts for Bihar (including cities from dealer data)
        District::create(['name' => 'Patna', 'state_id' => $bihar->id, 'is_active' => true]);
        District::create(['name' => 'Gaya', 'state_id' => $bihar->id, 'is_active' => true]);
        District::create(['name' => 'Muzaffarpur', 'state_id' => $bihar->id, 'is_active' => true]);
        District::create(['name' => 'Bhagalpur', 'state_id' => $bihar->id, 'is_active' => true]);
        District::create(['name' => 'Darbhanga', 'state_id' => $bihar->id, 'is_active' => true]);

        // Create Districts for Jharkhand (including cities from dealer data)
        District::create(['name' => 'Ranchi', 'state_id' => $jharkhand->id, 'is_active' => true]);
        District::create(['name' => 'Jamshedpur', 'state_id' => $jharkhand->id, 'is_active' => true]);
        District::create(['name' => 'Dhanbad', 'state_id' => $jharkhand->id, 'is_active' => true]);
        District::create(['name' => 'Bokaro', 'state_id' => $jharkhand->id, 'is_active' => true]);
        District::create(['name' => 'Deoghar', 'state_id' => $jharkhand->id, 'is_active' => true]);

        // Create Districts for Tamil Nadu (including cities from dealer data)
        District::create(['name' => 'Chennai', 'state_id' => $tamilNadu->id, 'is_active' => true]);
        District::create(['name' => 'Coimbatore', 'state_id' => $tamilNadu->id, 'is_active' => true]);
        District::create(['name' => 'Madurai', 'state_id' => $tamilNadu->id, 'is_active' => true]);
        District::create(['name' => 'Tiruchirappalli', 'state_id' => $tamilNadu->id, 'is_active' => true]);
        District::create(['name' => 'Salem', 'state_id' => $tamilNadu->id, 'is_active' => true]);

        // Create Districts for Andhra Pradesh (including cities from dealer data)
        District::create(['name' => 'Visakhapatnam', 'state_id' => $andhraPradesh->id, 'is_active' => true]);
        District::create(['name' => 'Vijayawada', 'state_id' => $andhraPradesh->id, 'is_active' => true]);
        District::create(['name' => 'Guntur', 'state_id' => $andhraPradesh->id, 'is_active' => true]);
        District::create(['name' => 'Nellore', 'state_id' => $andhraPradesh->id, 'is_active' => true]);
        District::create(['name' => 'Kurnool', 'state_id' => $andhraPradesh->id, 'is_active' => true]);
        District::create(['name' => 'Rayachoti', 'state_id' => $andhraPradesh->id, 'is_active' => true]);
        District::create(['name' => 'Madanapalli', 'state_id' => $andhraPradesh->id, 'is_active' => true]);

        // Create Districts for Karnataka (including cities from dealer data)
        District::create(['name' => 'Bangalore', 'state_id' => $karnataka->id, 'is_active' => true]);
        District::create(['name' => 'Mysore', 'state_id' => $karnataka->id, 'is_active' => true]);
        District::create(['name' => 'Hubli', 'state_id' => $karnataka->id, 'is_active' => true]);
        District::create(['name' => 'Mangalore', 'state_id' => $karnataka->id, 'is_active' => true]);
        District::create(['name' => 'Belgaum', 'state_id' => $karnataka->id, 'is_active' => true]);
        District::create(['name' => 'Kudligi Town', 'state_id' => $karnataka->id, 'is_active' => true]);
    }
}
