<?php

use App\AppRepoManager;
use Core\Session\Session;

$user_id = Session::get(Session::USER)->id;
?>


<main class="container-pizza-perso">
    <h1 class="title title-perso">Je crée ma pizza ! 🧑‍🍳</h1>
    <!-- on va afficher les erreurs s'il y en a -->

    <form action="/add-pizza-perso-form" method="post" class="form-perso">
        <div class="box-perso-name">
            <label class="sub-title test">Nom de ma pizza</label>
            <input type="text" class="form-control name-perso" name="name">
        </div>
        <div class="img-container-perso">
            <img class="pizzaperso" src="/assets/images/pizza/pizzaperso.png" alt="image de pizza par défaut">
            <h1 class="sub-title">Je choisis les ingrédients</h1>
            <div class="box-pizza-perso list-ingredient">
                <!-- TODO: Limiter la selection d'ingrédients à 5 et min 1 -->
                <!-- on affiche la liste des ingredients -->
                <?php foreach (AppRepoManager::getRm()->getIngredientRepository()->getIngredientActive() as $ingredient) : ?>

                    <div class="form-check ingre-perso">
                        <input name="ingredients[]" value="<?= $ingredient->id ?>" class="form-check-input form-perso" type="checkbox" role="switch" id="defaultCheck1">
                        <label class="form-check-label footer-description m-1" for="defaultCheck1"><?= $ingredient->label ?></label>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <div class="box-perso-size list-size">
            <label class="sub-title test">Je choisis la taille</label>
            <?php foreach (AppRepoManager::getRm()->getSizeRepository()->getAllSize() as $size) : ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="size_id[]" value="<?= $size->id ?>">
                    <label class="form-check-label footer-description" for="defaultCheck1"> <?= $size->label ?></label>
                </div>
            <?php endforeach ?>
        </div>

        <input type="hidden" name="user_id" value="<?= $user_id ?>">

        <button type="submit" class="call-action btn-perso">Créer la pizza 🍕!

</main>
</form>