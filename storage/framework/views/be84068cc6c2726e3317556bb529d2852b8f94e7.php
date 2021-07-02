<html>
    <head>
        <title>PizzaLivery</title>
        <link rel="stylesheet" href="<?php echo e(url('css/home.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('css/pizze_preferite.css')); ?>">
        <meta name="viewport"content="width=device-width, initial-scale=1"> 
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">     
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> 
        <script src="<?php echo e(url('js/pizze_preferite.js')); ?>" defer charset="UTF-8"></script>
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
            <div id="pizze_pref"></div>
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
    </body>
</html><?php /**PATH C:\xampp\htdocs\hw2\resources\views/pizze_preferite.blade.php ENDPATH**/ ?>