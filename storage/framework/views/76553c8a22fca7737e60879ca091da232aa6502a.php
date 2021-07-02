<html>
    <head>
        <title>PizzaLivery</title>
        <link rel="stylesheet" href="<?php echo e(url('css/home.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('css/modale.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('css/pizze.css')); ?>">
        <meta name="viewport"content="width=device-width, initial-scale=1"> 
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">     
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> 
        <script src="<?php echo e(url('js/pizze.js')); ?>" defer charset="UTF-8"></script>
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    </head>
    <body>
        <nav>
            <div class='left'>
                <h1 class='logo' id='logo_1'>PizzaLivery</h1>
                <h1 class='logo' id='logo_2'>PL</h1>
                <div id='links'>
                    <a href="home">Home</a>
                    <a href="pizze">Pizze</a>                                                                  
                </div>
            </div>
            <div class='right'>
                <a href="carrello"><img src="images/cart_white.png"></a>
                <img src="images/account_logo_white.png" alt="logo" id='profile_pic'>
            </div>
            
            <div class='hidden' id='profile_block'>
                <h3><?php echo e(session("user_username")); ?></h3>
                <h6><a href='i_miei_ordini'>I miei ordini</a></h6>
                <h6><a href='pizze_preferite'>Pizze preferite</a></h6>
                <h6><a href='logout'>Logout</a></h6>
            </div>

        </nav>

        <article>
            <h1 id="titolo_pizze">Tutte le pizze</h1>
            <div id="pizze">                    
            </div>
            
            <a href="carrello" id="vai_a_carrello"></a>
        </article>

        <footer>
                <div class='footer_info'>
                    Andrea Giuffrida<br>
                    o46002237
                </div>
                <div class='footer_social'>
                    <img src='images/facebook.png'>
                    <img src='images/twitter.png'>
                    <img src='images/instagram.png'>
                </div>
        </footer>

        <div id="modale" class='hidden' tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
            <div id='menu_block'></div>
        </div>
    </body>
</html><?php /**PATH C:\xampp\htdocs\hw2\resources\views/pizze.blade.php ENDPATH**/ ?>