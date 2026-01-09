<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'material', 
        'material_document', 
        'material_description'
        ];

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
