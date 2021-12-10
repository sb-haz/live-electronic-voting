<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    // Define the model it belongs to
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    // Define the models it has one-to-many relationship with
    public  function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
