<?php

use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Pizza;

class PizzeController extends Controller {
    //Restituisce la pagina delle pizze
    public function index() {
        //Se il cookie del login non è presente reindirizza al login
        $cookie_id = request()->cookie('user_id');
        $user = User::find($cookie_id);
        if (!isset($user))
            return redirect('login');

        //Restituisce la pagina "i miei ordini" con il csrf_token
        return view('pizze')->with("user", $user)->with("csrf_token", csrf_token());        
    }

    //Restituisce il JSON con le pizze
    public function getPizze(){       
        $pizze = Pizza::get();
        foreach($pizze as $pizza){
            $n_ingr = count($pizza->ingredients);
            //Crea la stringa con gli ingredienti separati da virgola
            $pizza["Ingredients_string"] = "";
            for($i = 0; $i < ($n_ingr - 1); $i++){
                $pizza["Ingredients_string"] .= $pizza->ingredients[$i]["name"].", ";
            }

            $pizza["Ingredients_string"] .= $pizza->ingredients[$i]["name"];
            $menus = $pizza->menus;
            foreach($menus as $menu){
                //Aggiunge la pizzeria e il costo
                $menu->pizzeria;
                $row = DB::table('menu_pizza')->where('menu_id', $menu->id)->where('pizza_id', $pizza->id)->first();
                $menu["Cost"] = $row->cost;
            }
        }

        return $pizze;        
    }
}
?>