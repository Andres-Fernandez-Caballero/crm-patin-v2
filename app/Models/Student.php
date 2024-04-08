<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['names', 'last_name', 'dni', 'email', 'birth_date','meses_adeudados', 'state'];

    protected $casts = [
        'birth_date' => 'date'
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function topics(): MorphToMany
    {
        return $this->morphToMany(Topic::class, 'topicable');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
