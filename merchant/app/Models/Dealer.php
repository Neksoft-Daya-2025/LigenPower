<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dealer extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'contact_person',
        'email',
        'phone',
        'alternate_phone',
        'type',
        'address',
        'city',
        'state',
        'pincode',
        'gst_number',
        'pan_number',
        'business_description',
        'website',
        'status',
        'state_id',
        'district_id'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function validationRules()
    {
        return [
            'business_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'nullable|email|unique:dealers,email',
            'phone' => 'required|string|max:15',
            'alternate_phone' => 'nullable|string|max:15',
            'type' => 'required|in:dealer,distributor',
            'address' => 'required|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'required|string|max:10',
            'gst_number' => 'nullable|string|max:15',
            'pan_number' => 'nullable|string|max:10',
            'business_description' => 'nullable|string',
            'website' => 'nullable|string|max:255',
            'state_id' => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id',
        ];
    }

    public static function updateValidationRules($id)
    {
        $rules = self::validationRules();
        $rules['email'] = 'nullable|email|unique:dealers,email,' . $id;
        return $rules;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPincode($query, $pincode)
    {
        return $query->where('pincode', $pincode);
    }

    public function scopeByState($query, $stateId)
    {
        return $query->where('state_id', $stateId);
    }

    public function scopeByDistrict($query, $districtId)
    {
        return $query->where('district_id', $districtId);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
