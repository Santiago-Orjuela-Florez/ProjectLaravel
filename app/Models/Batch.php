<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['batch', 'registro_id', 'quantity'];

    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }
}

