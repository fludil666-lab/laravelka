<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_UNDER_REVIEW = 'under_review';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'customer_id', 'specialist_profile_id', 'address', 'scheduled_date', 'scheduled_time',
        'description', 'status'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function specialistProfile()
    {
        return $this->belongsTo(SpecialistProfile::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_UNDER_REVIEW,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELLED,
        ];
    }

    public static function statusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Новый',
            self::STATUS_UNDER_REVIEW => 'На рассмотрении',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETED => 'Выполнен',
            self::STATUS_CANCELLED => 'Отменен',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }
}
