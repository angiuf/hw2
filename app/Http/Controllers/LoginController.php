<?php

use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends BaseController{

    public function login(){
        // Verifichiamo se l'utente ha già fatto il login
        if(request()->cookie('user_id') != null){
            // Redirect alla home
            return redirect('home');
        }
        else{
            // Verifichiamo se c'è stato un errore nel login
            $login_old_username = request()->old('login_username');
            $iscr_old_nome = request()->old('nome');
            $iscr_old_cognome = request()->old('cognome');
            $iscr_old_email = request()->old('email');
            $iscr_old_username = request()->old('iscr_username');
            $iscr_old_indirizzo = request()->old('indirizzo');
            $iscr_old_cellulare = request()->old('cellulare');
            $iscr_succ = session('iscr_succ');
            $email_error = session('email_error');
            $username_error = session('username_error');

            return view('login')
                ->with("login_old_username", $login_old_username)
                ->with("iscr_old_nome", $iscr_old_nome)
                ->with("iscr_old_cognome", $iscr_old_cognome)
                ->with("iscr_old_email", $iscr_old_email)
                ->with("iscr_old_username", $iscr_old_username)
                ->with("iscr_old_indirizzo", $iscr_old_indirizzo)
                ->with("iscr_old_cellulare", $iscr_old_cellulare)
                ->with("iscr_succ", $iscr_succ)
                ->with("email_error", $email_error)
                ->with("username_error", $username_error)
                ->with('csrf_token', csrf_token());

        }
    }    
    
    //Verifica il login
    public function checkLogin(){         
        if(request('tipo') == 'login'){
            // Verifichiamo che l'utente esista
            $user = User::where('username', request('login_username'))->first();
            if(isset($user)){
                //E controlliamo la password
                $password = request('password');
                $hash = $user->password;
                if(password_verify($password, $hash)){
                    // Credenziali valide
                    if(request("ricordami") == "ricordami"){
                        //Se abbiamo impostato "Ricordami" imposta un cookie da 30 giorni
                        $minutes = 60*24*30;
                        return redirect('home')
                        ->withCookie(cookie('user_id', $user->id, $minutes));
                    }else{
                        return redirect('home')
                        ->withCookie(cookie('user_id', $user->id));
                    }
                }else{
                    // Credenziali non valide
                    return redirect('login')
                    ->with("errore_login", true)
                    ->withInput();
                }
            }else{
                // Credenziali non valide
                return redirect('login')
                ->with("errore_login", true)
                ->withInput();
            }
        }else{
            //Esegui l'iscrizione dell'utente
            $nome = request('nome');
            $cognome = request('nome');
            $email = request('email');
            $username = request('iscr_username');
            $password = request('password');
            //Fa l'hash della password da inserire nel db
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $indirizzo = request('indirizzo');
            $cellulare = request('cellulare');

            //Controlla la mail
            $userCheck = User::where('email', $email)->first();
            if(isset($userCheck)){
                $email_error = true;
            }else{
                $email_error = false;
            }

            //Controlla l'username
            $userCheck = User::where('username', $username)->first();
            if(isset($userCheck)){
                $username_error = true;
            }else{
                $username_error = false;
            }

            //Se non ci sono errori completa l'iscrizione
            if(!$email_error && !$username_error){
                $user = new User;
                $user->name = $nome;
                $user->surname = $cognome;
                $user->email = $email;
                $user->username = $username;
                $user->password = $hash;
                $user->address = $indirizzo;
                $user->phone = $cellulare;
                $user->save();
                return redirect('login')->with("iscr_succ", true);
            }else{
                return redirect('login')
                ->with("email_error", $email_error)
                ->with("username_error", $username_error)
                ->withInput();
            }
        }
    }

    //Controlla se esiste già l'email
    private function errorEmail($email){
        $user = User::where('email', $email)->first();
        if(isset($user)){
            return true;
        }
    }

    //Controlla se esiste già l'username
    private function errorUsername($username){
        $user = User::where('username', $username)->first();
        if(isset($user)){
            return true;
        }
    }

    //Fa il logout
    public function logout() {
        //Elimina la sessione e i cookie
        Session::flush();
        Cookie::queue(Cookie::forget('user_id'));
        
        //Reindirizza alla pagina di login
        return redirect('login');
    }
}

?>