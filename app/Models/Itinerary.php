<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $fillable = [
    'titre',
    'categorie',
    'duration',
    'image',
    'user_id'
];

public function destinations(){
    return $this->hasMany(Destination::class);
}

public function user(){
    return $this ->belongsTo(User::class);
}

public function favorites () {
        return $this->hasMany(Favorite::class);
    }

    
}
