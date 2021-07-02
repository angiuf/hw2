<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pizzeria extends Model{
    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    public function favorite_users(){
        return $this->belongsToMany(User::class, "favorites");
    }
}
?>