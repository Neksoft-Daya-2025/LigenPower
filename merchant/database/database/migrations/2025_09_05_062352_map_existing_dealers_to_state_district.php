<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Dealer;
use App\Models\State;
use App\Models\District;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Map existing dealers to state and district IDs
        $stateMapping = [
            'Bihar' => 'Bihar',
            'Jharkhand' => 'Jharkhand', 
            'Tamil Nadu' => 'Tamil Nadu',
            'Andhra Pradesh' => 'Andhra Pradesh',
            'Karnataka' => 'Karnataka'
        ];

        $cityDistrictMapping = [
            'Bihar' => [
                'Patna' => 'Patna'
            ],
            'Jharkhand' => [
                'Ranchi' => 'Ranchi',
                'Jamshedpur' => 'Jamshedpur'
            ],
            'Tamil Nadu' => [
                'Chennai' => 'Chennai'
            ],
            'Andhra Pradesh' => [
                'Rayachoti' => 'Rayachoti',
                'Madanapalli' => 'Madanapalli'
            ],
            'Karnataka' => [
                'Kudligi Town' => 'Kudligi Town'
            ]
        ];

        foreach ($stateMapping as $oldStateName => $newStateName) {
            $state = State::where('name', $newStateName)->first();
            if (!$state) continue;

            $dealers = Dealer::where('state', $oldStateName)->get();
            
            foreach ($dealers as $dealer) {
                // Update state_id
                $dealer->state_id = $state->id;
                
                // Find matching district
                if (isset($cityDistrictMapping[$oldStateName][$dealer->city])) {
                    $districtName = $cityDistrictMapping[$oldStateName][$dealer->city];
                    $district = District::where('name', $districtName)
                                      ->where('state_id', $state->id)
                                      ->first();
                    if ($district) {
                        $dealer->district_id = $district->id;
                    }
                }
                
                $dealer->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset state_id and district_id to null
        Dealer::whereNotNull('state_id')->update(['state_id' => null]);
        Dealer::whereNotNull('district_id')->update(['district_id' => null]);
    }
};
