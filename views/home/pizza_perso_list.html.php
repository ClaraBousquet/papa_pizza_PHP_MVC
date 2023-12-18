<?php

use App\AppRepoManager;
use App\Model\Pizza;
$pizzas = $AppRepoManager->getPizzaRepository()->getPizzasCustom($user_id) ?>
<div class="container-pizza-perso-list"> 
<h1 class="title ">Mes pizzas crées</h1>
<div class="d-flex justify-content-center">

    <div class="d-flex flex-row flex-wrap my-3 justify-content-center col-lg-10-align-self-center">
    </div>
</div>
</div>