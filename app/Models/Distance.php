<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    use HasFactory;

    protected $fillable = [
        'cm',
        'timestamp',
        'session_id',
    ];

    public $timestamps = false;

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
