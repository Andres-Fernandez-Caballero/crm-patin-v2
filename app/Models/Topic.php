<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'price'];

    public function tickets()
    {
        return $this->morphedByMany(Ticket::class, 'topicable');
    }

    public function students()
    {
        return $this->morphedByMany(Student::class, 'topicable');
    }
}
