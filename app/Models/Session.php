<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    public function modules()
    {
        return $this->belongsTo(Module::class);
    }
    
    public function polls()
    {
        return $this->hasMany(Poll::class);
    }
}
