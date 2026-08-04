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
        // Map dealers to the new relevant states and districts
        $stateMapping = [
            'Bihar' => State::where('name', 'Bihar')->first(),
            'Jharkhand' => State::where('name', 'Jharkhand')->first(),
            'Tamil Nadu' => State::where('name', 'Tamil Nadu')->first(),
            'Andhra Pradesh' => State::where('name', 'Andhra Pradesh')->first(),
            'Karnataka' => State::where('name', 'Karnataka')->first(),
        ];

        $cityDistrictMapping = [
            'Bihar' => [
                'Patna' => District::where('name', 'Patna')->whereHas('state', function($q) {
                    $q->where('name', 'Bihar');
                })->first(),
            ],
            'Jharkhand' => [
                'Ranchi' => District::where('name', 'Ranchi')->whereHas('state', function($q) {
                    $q->where('name', 'Jharkhand');
                })->first(),
                'Jamshedpur' => District::where('name', 'Jamshedpur')->whereHas('state', function($q) {
                    $q->where('name', 'Jharkhand');
                })->first(),
            ],
            'Tamil Nadu' => [
                'Chennai' => District::where('name', 'Chennai')->whereHas('state', function($q) {
                    $q->where('name', 'Tamil Nadu');
                })->first(),
            ],
            'Andhra Pradesh' => [
                'Rayachoti' => District::where('name', 'Rayachoti')->whereHas('state', function($q) {
                    $q->where('name', 'Andhra Pradesh');
                })->first(),
                'Madanapalli' => District::where('name', 'Madanapalli')->whereHas('state', function($q) {
                    $q->where('name', 'Andhra Pradesh');
                })->first(),
            ],
            'Karnataka' => [
                'Kudligi Town' => District::where('name', 'Kudligi Town')->whereHas('state', function($q) {
                    $q->where('name', 'Karnataka');
                })->first(),
            ],
        ];

        foreach ($stateMapping as $stateName => $state) {
            if (!$state) continue;

            $dealers = Dealer::where('state', $stateName)->get();
            
            foreach ($dealers as $dealer) {
                // Update state_id
                $dealer->state_id = $state->id;
                
                // Find matching district
                if (isset($cityDistrictMapping[$stateName][$dealer->city])) {
                    $district = $cityDistrictMapping[$stateName][$dealer->city];
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
