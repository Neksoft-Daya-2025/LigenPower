<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    protected $fillable = [
        'pincode',
        'city',
        'state',
        'district',
        'is_serviceable',
    ];

    protected $casts = [
        'is_serviceable' => 'boolean',
    ];

    public function scopeServiceable($query)
    {
        return $query->where('is_serviceable', true);
    }

    public function scopeSearch($query, $term)
    {
        if (empty($term)) {
            return $query;
        }
        return $query->where(function ($q) use ($term) {
            $q->where('pincode', 'like', "%{$term}%")
              ->orWhere('city', 'like', "%{$term}%")
              ->orWhere('state', 'like', "%{$term}%")
              ->orWhere('district', 'like', "%{$term}%");
        });
    }
}
