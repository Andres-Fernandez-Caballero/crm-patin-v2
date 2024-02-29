<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_date_open',
        'payment_date_paid',
        'total_amount',
        'student_id',
        ];

    public function isPaid():Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['payment_date_paid'] != null? 'pago': 'pendiente');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
