<?php

use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Pizzeria;

class HomeController extends Controller {

    //Restituisce la pagina home
    public function index() {
        //Se il cookie del login non è presente reindirizza al login
        $cookie_id = request()->cookie('user_id');
        $user = User::find($cookie_id);
        if (!isset($user))
            return redirect('login');
        
        //Restituisce la home con il csrf_token
        Session::put("user_id", $user->id);
        Session::put("user_username", $user->username);
        return view("home")->with("user", $user)->with("csrf_token", csrf_token());
    }

    //Restituisce il JSON con tutte le pizzerie
    public function pizzerie(){
        $pizzerie = Pizzeria::all();
        foreach($pizzerie as $pizzeria){
            $pizzas = $pizzeria->menu->pizzas;
            foreach($pizzas as $pizza){
                //Crea una stringa con tutti gli ingredienti separati da virgola
                $n_ingr = count($pizza->ingredients);
                $pizza["Ingredients_string"] = "";
                for($i = 0; $i < ($n_ingr - 1); $i++){
                    $pizza["Ingredients_string"] .= $pizza->ingredients[$i]["name"].", ";
                }
                //Tranne l'ultimo ingrediente
                $pizza["Ingredients_string"] .= $pizza->ingredients[$i]["name"];

                //Aggiunge il prezzo al JSON
                $row = DB::table('menu_pizza')->where('menu_id', $pizzeria->menu->id)->where('pizza_id', $pizza->id)->first();
                $pizza["Cost"] = $row->cost;
            }            
        }
        return $pizzerie;        
    }

    //Funzione che restituisce le pizzerie preferite di un utente
    public function preferiti(){
        $id = session("user_id");
        $user = User::find($id);
        return $user->favorite_pizzerias;
    }

    //Funzione che aggiunge una pizzeria ai preferiti dell'utente (nel DB)
    public function aggiungiPreferito($pizzeria_id) {
        $user_id = session()->get('user_id');
        return DB::table('favorites')->insert(['user_id' => $user_id, 'pizzeria_id' => $pizzeria_id]);
    }

    //Funzione che rimuove una pizzeria dai preferiti dell'utente (nel DB)
    public function rimuoviPreferito($pizzeria_id) {
        $user_id = session()->get('user_id');
        return DB::table('favorites')
            ->where('user_id', $user_id)
            ->where('pizzeria_id', $pizzeria_id)->delete();
    }

    //Funzione che restituisce se il carrello è vuoto o il totale dell'ordine
    public function isCartEmpty(){
        $c = array();
        $c["Empty"] = true;
        //Se il carrello non è vuoto restituisce false e la quantità e il prezzo totale dell'ordine. Altrimenti ritorna true
        if(session("carrello") !== null){
            if(count(session("carrello.Pizze")) !== 0){
                $c["Empty"] = false;
                $tot = 0;
                $el = 0;
                foreach(session("carrello.Pizze") as $pizza){
                    $tot += $pizza["cost"];
                    $el += $pizza["quantity"];
                }
                $c["Totale"] = $tot;
                $c["N_el"] = $el;
            }
        }
        return $c;
    }

    //Funzione per recuperare il JSON alla API REST "edamam"
    public function getRicette($ricetta){
        //Codici per la richiesta
        $app_id = "9eade77e";
        $app_key = "e09342358eaa3454f6f4cab68199a5b3";
        $max_count = 10;

        //Codifica il parametro passato dal js
        $ricetta = urlencode($ricetta);
        $url = "https://api.edamam.com/search?q=".$ricetta."&app_id=".$app_id."&app_key=".$app_key."&to=".$max_count;

        //Setta il curl
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "$url");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($curl);
        curl_close($curl);
        
        return $res;
    }
}
?>