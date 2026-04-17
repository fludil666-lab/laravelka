<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'specialist_profile_id', 'user_id', 'rating', 'comment'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function specialistProfile()
    {
        return $this->belongsTo(SpecialistProfile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
