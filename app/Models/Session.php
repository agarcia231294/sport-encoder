<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'max_distance',
        'average_distance',
        'max_speed',
        'average_speed',
        'kg',
        'user_id',
    ];

    public function distances()
    {
        return $this->hasMany(Distance::class);
    }
}
