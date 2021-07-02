<html>
    <head>
        <title>PizzaLivery login</title>
        <meta name="viewport"content="width=device-width, initial-scale=1"> 
        <link rel="stylesheet" href="<?php echo e(url('css/login.css')); ?>">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">     
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400&display=swap" rel="stylesheet">
        <script src="<?php echo e(url('js/login.js')); ?>" defer charset="UTF-8"></script> 
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
                        
                        <form name='login' method='post' id='login' <?php if(isset($iscr_old_username)): ?> class='hidden' <?php endif; ?>>
                            <input type='hidden' name='_token' value='<?php echo e($csrf_token); ?>'>
                            <p>
                                <label>Username<br>
                                <input type='text' name='login_username' value='<?php echo e($login_old_username); ?>' <?php if(isset($login_old_username)): ?> class='in_error' <?php endif; ?>></label>
                            </p>
                            <p>
                                <label>Password<br>
                                <input type='password' name='password' <?php if(isset($login_old_username)): ?> class='in_error' <?php endif; ?>></label>
                            </p>
                            <p>
                                <label class='Ricordami'><input type='checkbox' name='ricordami' value='ricordami'>Ricordami</label>
                            </p>
                            <p>
                                <label class='invia'>&nbsp;<input type='submit'></label>
                            </p>
                            <input type='hidden' name='tipo' value='login'>

                        </form>

                        
                        <form name='iscrizione' method='post' id='iscrizione' <?php if(!isset($iscr_old_username)): ?> class='hidden' <?php endif; ?>>
                            <input type='hidden' name='_token' value='<?php echo e($csrf_token); ?>'>
                            <p>
                                <label>Nome<br>
                                <input type='text' name='nome' value='<?php echo e($iscr_old_nome); ?>'></label>
                            </p>
                            <p>
                                <label>Cognome<br>
                                <input type='text' name='cognome' value='<?php echo e($iscr_old_cognome); ?>'></label>
                            </p>
                            <p>
                                <label>Indirizzo email<br>
                                <?php if(isset($email_error) && $email_error): ?>
                                    <input type='text' name='email' value='<?php echo e($iscr_old_email); ?>' class='in_error'>
                                <?php else: ?>
                                    <input type='text' name='email' value='<?php echo e($iscr_old_email); ?>'>
                                <?php endif; ?>
                                </label>
                            </p>
                            <p>
                                <label>Username<br>
                                <?php if(isset($username_error) && $username_error): ?>
                                    <input type='text' name='iscr_username' value='<?php echo e($iscr_old_username); ?>' class='in_error'>
                                <?php else: ?>
                                    <input type='text' name='iscr_username' value='<?php echo e($iscr_old_username); ?>'>
                                <?php endif; ?>
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
                                <input type='text' name='indirizzo' value='<?php echo e($iscr_old_indirizzo); ?>'></label>
                            </p>
                            <p>
                                <label>Cellulare<br>
                                <input type='text' name='cellulare' value='<?php echo e($iscr_old_cellulare); ?>'></label>
                            </p>
                            <p class='invia'>
                                <label class='invia'>&nbsp;<input type='submit'></label>
                            </p>
                            <input type='hidden' name='tipo' value='iscrizione'>
                        </form>
                    </div>
                    <h5 class='error <?php if(!isset($login_old_username)): ?> hidden <?php endif; ?>' id='err_cred' >Credenziali errate</h5>

                    <h5 class='error hidden' id='err_campi'>Compila tutti i campi</h5>
                    <h5 class='error hidden' id='err_pwd'>Le password non coincidono</h5>
                    <h5 class='error hidden' id='err_pwd_len'>La password deve essere tra 8 e 20 caratteri</h5>
                    <h5 class='error hidden' id='err_pwd_sc'>La password deve contenere almeno una maiuscola, una minuscola, un numero e un carattere speciale</h5>
                    <h5 class='error hidden' id='err_cell'>Inserisci un cellulare valido</h5>

                    <?php if(isset($email_error) && $email_error): ?> 
                        <h5 class='error' id='err_email' >Email già in uso</h5>
                    <?php endif; ?>                    
                    <?php if(isset($username_error) && $username_error): ?> 
                    <h5 class='error' id='err_username'>Username già in uso</h5> 
                    <?php endif; ?>  
                                           
                    <h4 id='succ_iscr' <?php if(!isset($iscr_succ)): ?> class='hidden' <?php endif; ?>>Iscrizione avvenuta<br> con successo</h4>
                    
                    
                </div>
            </div>
        </div>
    </body>

</html><?php /**PATH C:\xampp\htdocs\hw2\resources\views/login.blade.php ENDPATH**/ ?>