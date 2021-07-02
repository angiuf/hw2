<?php

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OrderInfo;

class CarrelloController extends Controller {
    //Restituisce la pagina carrello
    public function index() {
        //Se il cookie del login non è presente reindirizza al login
        $cookie_id = request()->cookie('user_id');
        $user = User::find($cookie_id);
        if (!isset($user))
            return redirect('login');

        //Restituisce la pagina carrello con il csrf_token
        return view('carrello')->with("user", $user)->with("csrf_token", csrf_token());        
    }

    //Funzione che aggiunge una pizza al carrello
    public function aggiungiCarrello(){
        //Controlla se esiste già il carrello; sennò lo crea e aggiunge l'ordine nel DB
        if(session("carrello") === null){
            $order = new OrderInfo;
            $order->date = date('Y/m/d', time());
            $order->user_id = session()->get("user_id");
            $order->save();

            session(["carrello" => array("id" => $order->id, "Pizze" => array())]);
        }

        $pizze_carrello = session("carrello.Pizze");
        
        //Cerca se la pizza è già nell'ordine
        $key = null;
        $i = 0;
        foreach($pizze_carrello as $p){
            //Controlla se la pizza di qualla pizzeria è già stata ordinata
            if($p["pizza_id"] === request()->post("pizza_id") && $p["pizzeria_id"] === request()->post("pizzeria_id")){
                $key = $i;
                break;
            }
            $i++;
        }

        //Se era già nell'ordine aggiorna solo la quantità e il prezzo
        if($key !== null){
            $pizze_carrello[$key]["quantity"] += request()->post('quantita');
            $pizze_carrello[$key]["cost"] += (float)request()->post('prezzo')*(int)request()->post('quantita');

            //Salva gli aggiornamenti nella sessione
            Session::put("carrello.Pizze", $pizze_carrello);

            return session("carrello.Pizze");
        }
        //Altrimenti aggiunge una nuova pizza all'ordine
        else{
            $pizza = array("pizza_id" => request()->post('pizza_id'), "name_pizza" => request()->post('nome_pizza'), "pizzeria_id" => request()->post('pizzeria_id'),
            "name_pizzeria" => request()->post('nome_pizzeria'), "quantity" => request()->post('quantita'), "cost" => (float)request()->post('prezzo')*(int)request()->post('quantita'));
            session()->push("carrello.Pizze", $pizza);

            return session("carrello.Pizze");
        }
        
    }

    //Funzione per rimuovere una pizza dal carrello
    public function rimuoviCarrello($pizza_id, $pizzeria_id){
        $carrello = session("carrello.Pizze");
        $i = 0;
        foreach($carrello as $pizza){
            if($pizza['pizza_id'] === $pizza_id && $pizza['pizzeria_id'] === $pizzeria_id){
                \array_splice($carrello, $i, 1);
            }
            $i++;
        }

        //Salva gli aggiornamenti nella sessione
        Session::put("carrello.Pizze", $carrello);
        return $carrello;
    }

    //Funzione che restituisce il JSON con tutte le pizze presenti nel carrello
    public function getCarrello(){
        if(session("carrello") != null)
            return session("carrello.Pizze");
        else
            return 0;
    }

    //Funzione che restituisce se il carrello è vuoto o il totale dell'ordine
    public function isCartEmpty(){
        $c = array();
        $c["Empty"] = true;
        //Se il carrello non è vuoto restituisce false e la quantità e il prezzo totale dell'ordine. Altrimenti ritorna true
        if(session("carrello") != null){
            if(count(session("carrello.Pizze")) != 0){
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

    //Funzione per completare e inviare l'ordine
    public function inviaOrdine(){
        //Creiamo prima tutti gli oggetti da aggiungere
        $q = array();
        foreach(session("carrello.Pizze") as $pizza){
            $p = array("order_info_id" => session("carrello.id"),
                    "pizzeria_id" => $pizza["pizzeria_id"],
                    "pizza_id" => $pizza["pizza_id"],
                    "cost" => $pizza["cost"],
                    "quantity" => $pizza["quantity"]);
            
            $q[] = $p;
        }
        
        //Insserisci l'array appena creato
        DB::table('orders')->insert($q);

        //Aggiorna il totale
        $order = OrderInfo::find(session("carrello.id"));
        $order->total = request()->post("Totale");
        $order->save();

        //Cancella tutto il carrello
        session()->forget("carrello");
    }
}
?>