<?php

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pizza;

class PizzePreferiteController extends Controller {
    //Restituisce la pagina delle pizze
    public function index() {
        //Se il cookie del login non è presente reindirizza al login
        $cookie_id = request()->cookie('user_id');
        $user = User::find($cookie_id);
        if (!isset($user))
            return redirect('login');
        //Restituisce la pagina "pizze preferite" con il csrf_token
        return view('pizze_preferite')->with("user", $user)->with("csrf_token", csrf_token());        
    }

    //Restituisce il JSON con le pizze preferite
    public function getPizzaPreferita(){
        //Chiama la procedura sull'array 
        $user_id = session()->get("user_id");
        DB::select('call op1('.$user_id.')');
        $pizze_pref = DB::table('pizze_pref')->get();
        $json = array();

        foreach($pizze_pref as $p){
            $id = $p->ID_Pizza;
            $pizza = Pizza::find($id);
            $pizza["N_ordinate"] = $p->Num_pizze_ordinate;
            $n_ingr = count($pizza->ingredients);
            $pizza["Ingredients_string"] = "";
            for($i = 0; $i < ($n_ingr - 1); $i++){
                $pizza["Ingredients_string"] .= $pizza->ingredients[$i]["name"].", ";
            }
            $pizza["Ingredients_string"] .= $pizza->ingredients[$i]["name"];
            $json[] = $pizza;
        }
        return $json;
    }
}
?>