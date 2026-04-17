<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialistService extends Model
{
    use HasFactory;

    protected $fillable = ['specialist_profile_id', 'category_id', 'title', 'price_from', 'price_type'];

    public function specialistProfile()
    {
        return $this->belongsTo(SpecialistProfile::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
