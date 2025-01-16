<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymPlan extends Model
{
    /** @use HasFactory<\Database\Factories\GymPlanFactory> */
    use HasFactory;

    protected $table = 'gym_plans';

    protected $fillable = [
        'name',
        'description',
        'price'
    ];


    public function members()
    {
        return $this->belongsToMany(Member::class, 'gym_plan_members');
    }
}
