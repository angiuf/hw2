<html>
    <head>
        <title>PizzaLivery login</title>
        <meta name="viewport"content="width=device-width, initial-scale=1"> 
        <link rel="stylesheet" href="{{ url('css/login.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">     
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400&display=swap" rel="stylesheet">
        <script src="{{ url('js/login.js') }}" defer charset="UTF-8"></script> 
    </head>

    <body>
        <h1 id='logo'>PizzaLivery</h1>

        <div>
            <div id='block'>
                <div id='form_block'>
                    <h3>
                        <span id='login_button'>Log in</span><span>|</span><span id='iscriviti_button'>Iscriviti</span>
                    </h3>

                    <div class='form'>                        
                        
                        <form name='login' method='post' id='login' @if(isset($iscr_old_username)) class='hidden' @endif>
                            <input type='hidden' name='_token' value='{{ $csrf_token }}'>
                            <p>
                                <label>Username<br>
                                <input type='text' name='login_username' value='{{ $login_old_username }}' @if(isset($login_old_username)) class='in_error' @endif></label>
                            </p>
                            <p>
                                <label>Password<br>
                                <input type='password' name='password' @if(isset($login_old_username)) class='in_error' @endif></label>
                            </p>
                            <p>
                                <label class='Ricordami'><input type='checkbox' name='ricordami' value='ricordami'>Ricordami</label>
                            </p>
                            <p>
                                <label class='invia'>&nbsp;<input type='submit'></label>
                            </p>
                            <input type='hidden' name='tipo' value='login'>

                        </form>

                        
                        <form name='iscrizione' method='post' id='iscrizione' @if(!isset($iscr_old_username)) class='hidden' @endif>
                            <input type='hidden' name='_token' value='{{ $csrf_token }}'>
                            <p>
                                <label>Nome<br>
                                <input type='text' name='nome' value='{{ $iscr_old_nome }}'></label>
                            </p>
                            <p>
                                <label>Cognome<br>
                                <input type='text' name='cognome' value='{{ $iscr_old_cognome }}'></label>
                            </p>
                            <p>
                                <label>Indirizzo email<br>
                                @if(isset($email_error) && $email_error)
                                    <input type='text' name='email' value='{{ $iscr_old_email }}' class='in_error'>
                                @else
                                    <input type='text' name='email' value='{{ $iscr_old_email }}'>
                                @endif
                                </label>
                            </p>
                            <p>
                                <label>Username<br>
                                @if(isset($username_error) && $username_error)
                                    <input type='text' name='iscr_username' value='{{ $iscr_old_username }}' class='in_error'>
                                @else
                                    <input type='text' name='iscr_username' value='{{ $iscr_old_username }}'>
                                @endif
                                </label>
                            </p>
                            <p>
                                <label>Password<br>
                                <input type='password' name='password'></label>
                            </p>
                            <p>
                                <label>Conferma password<br>
                                <input type='password' name='conf_password'></label><br>
                            </p>
                            <p>
                                <label>Indirizzo<br>
                                <input type='text' name='indirizzo' value='{{ $iscr_old_indirizzo }}'></label>
                            </p>
                            <p>
                                <label>Cellulare<br>
                                <input type='text' name='cellulare' value='{{ $iscr_old_cellulare }}'></label>
                            </p>
                            <p class='invia'>
                                <label class='invia'>&nbsp;<input type='submit'></label>
                            </p>
                            <input type='hidden' name='tipo' value='iscrizione'>
                        </form>
                    </div>
                    <h5 class='error @if(!isset($login_old_username)) hidden @endif' id='err_cred' >Credenziali errate</h5>

                    <h5 class='error hidden' id='err_campi'>Compila tutti i campi</h5>
                    <h5 class='error hidden' id='err_pwd'>Le password non coincidono</h5>
                    <h5 class='error hidden' id='err_pwd_len'>La password deve essere tra 8 e 20 caratteri</h5>
                    <h5 class='error hidden' id='err_pwd_sc'>La password deve contenere almeno una maiuscola, una minuscola, un numero e un carattere speciale</h5>
                    <h5 class='error hidden' id='err_cell'>Inserisci un cellulare valido</h5>

                    @if(isset($email_error) && $email_error) 
                        <h5 class='error' id='err_email' >Email già in uso</h5>
                    @endif                    
                    @if(isset($username_error) && $username_error) 
                    <h5 class='error' id='err_username'>Username già in uso</h5> 
                    @endif  
                                           
                    <h4 id='succ_iscr' @if (!isset($iscr_succ)) class='hidden' @endif>Iscrizione avvenuta<br> con successo</h4>
                    
                    
                </div>
            </div>
        </div>
    </body>

</html>