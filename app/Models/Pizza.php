<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model{
    public function menus(){
        return $this->belongsToMany(Menu::class);
    }

    public function ingredients(){
        return $this->belongsToMany(Ingredient::class, "composition");
    }
}

?>