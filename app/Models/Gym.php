<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    /** @use HasFactory<\Database\Factories\GymFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'network_id',
    ];

    public function gymPlans()
    {
        return $this->hasMany(GymPlan::class);
    }
}
