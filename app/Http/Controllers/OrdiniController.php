<?php

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OrderInfo;

class OrdiniController extends Controller {
    //Restituisce la pagina carrello
    public function index() {
        //Se il cookie del login non è presente reindirizza al login
        $cookie_id = request()->cookie('user_id');
        $user = User::find($cookie_id);
        if (!isset($user))
            return redirect('login');

        //Restituisce la pagina "i miei ordini" con il csrf_token
        return view('orders')->with("user", $user)->with("csrf_token", csrf_token());        
    }

    //Restituisce il JSON con tutti gli ordini effettuati
    public function getOrdini(){
        $ordini = OrderInfo::where("user_id", session("user_id"))->whereNotNull("total")->get();

        $pizzerie = DB::table('pizzerias')->select('id', 'name as pizzeria_name');

        foreach($ordini as $ordine){
            $ordine["pizze_ordinate"] = DB::table('orders')
                ->where('order_info_id', $ordine->id)
                ->joinSub($pizzerie, 'pizzerias', function ($join) {
                    $join->on('orders.pizzeria_id', '=', 'pizzerias.id');
                })
                ->join('pizzas', 'orders.pizza_id', '=', 'pizzas.id')
                ->get();
        }

        return $ordini;
    }
}
?>