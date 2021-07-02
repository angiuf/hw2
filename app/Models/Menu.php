<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model{
    public function pizzeria(){
        return $this->hasMany(Pizzeria::class);
    }

    public function pizzas(){
        return $this->belongsToMany(Pizza::class);
    }
}

?>