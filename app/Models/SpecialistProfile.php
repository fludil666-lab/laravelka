<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialistProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'city', 'description', 'with_guarantee', 'works_by_contract',
        'passport_verified', 'is_organization', 'last_online_at', 'is_published'
    ];

    protected $casts = [
        'with_guarantee' => 'boolean',
        'works_by_contract' => 'boolean',
        'passport_verified' => 'boolean',
        'is_organization' => 'boolean',
        'last_online_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(SpecialistService::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating'), 1);
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}
