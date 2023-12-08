<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- import de bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- import du fichier style -->
    <link rel="stylesheet" href="/style_homepage.css">
    <link rel="stylesheet" href="/style_pizza.css">
    <link rel="stylesheet" href="/auth_style.css">

</head>

<body>
    <!-- si l'utilisateur n'est pas en session on redirige sur connexion -->
    <?php

    use App\AppRepoManager;

    //if (!$auth::isAuth()) $auth::redirect('/connexion') 
    ?>
    <div id="container">

    <header>
<!-- Top bar -->
<div id="topbar">
    <div class="line1">
        <div class="box-phone">
            <i class="bi bi-telephone">04 68 89 65 22</i></div>
        <div class="box-social">
            <a href=""><img class="social-icons"  src="/assets/images/icon/facebook-fill.svg" alt="icone facebook"></a>
            <a href=""><img class="social-icons" src="/assets/images/icon/instagram.svg" alt="icone instagram"></a>
            <a href=""><img class="social-icons" src="/assets/images/icon/twitter.svg" alt="icone twitter"></a>
        </div>
    </div>
    <div class="line2">
        <div class="nav-logo">
            <a href="/">
                <img class="logo-papapizza" src="/assets/images/homepage/papapizza.svg" alt="logo papapizza">
            </a>
        </div>
        <div class="nav-list">
            <nav class="custom-nav">
                <ul class="custom-ul">
                    <li class="custom-link"><a href="/">Accueil</a></li>
                    <li  class="custom-link"><a href="/pizzas">Carte</a></li>
                    <li class="custom-link"><a href="#">Actualités</a></li>
                    <li class="custom-link"><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
        <div class="nav-profil">
        <nav class="custom-nav">
                <ul class="custom-ul-profil">
                    <li class="custom-link-profil"><a href="/connexion">Se connecter
                        <img src="/assets/images/icon/user.svg" alt="icone utilisateur">
                    </a></li>
                    <li  class="custom-link-profil end-link">
                        <a href="#">
                            <img src="/assets/images/icon/cart.svg" alt="icone panier">
                    </a></li>
                </ul>
            </nav>
        </div>
    </div>

</div>



<!-- Navbar -->

</header>