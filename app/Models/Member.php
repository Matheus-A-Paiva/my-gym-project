<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'cpf',
        'height',
        'weight',
        'gender',
        'birthday',
        'start_date',
        'status',
    ];

    public function gymPlans()
    {
        return $this->belongsToMany(GymPlan::class, 'gym_plan_members');
    }


}
