<?php

use App\AppRepoManager;
use Core\Session\Session; ?>


<main class="container-form">
    <h1 class="title">Nouvelle star</h1>
    <!-- on va afficher les erreurs s'il y en a -->
    <?php if ($form_result && $form_result->hasErrors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $form_result->getErrors()[0]->getMessage() ?>
        </div>
    <?php endif ?>


    <form class="auth-form" action="/add-pizza-form" method="POST" enctype="multipart/form-data">
        <!-- on ajoute un input de type hidden pour envoyer l'id de l'utilisateur en session -->
        <input type="hidden" name="user_id" value="<?= Session::get(Session::USER)->id ?>">
        <div class="box-auth-input">
            <label class="detail-description">Nom de la pizza</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="box-auth-input">
            <label class="detail-description">Charger une image</label>
            <input type="file" class="form-control" name="image_path">
        </div>
        <div class="box-auth-input list-ingredient">
            <!-- on affiche la liste des ingredients -->
            <?php foreach (AppRepoManager::getRm()->getIngredientRepository()->getIngredientActive() as $ingredient) : ?>
                <div class="form-check form-switch list-ingredient-input">
                    <input name="ingredients[]" value="<?= $ingredient->id ?>" class="form-check-input" type="checkbox" role="switch">
                    <label class="form-check-label footer-description m-1"><?= $ingredient->label ?></label>
                </div>
            <?php endforeach ?>
        </div>
        <div class="box-auth-input list-size">
            <label class="header-description">Prix par taille</label>
            <?php foreach (AppRepoManager::getRm()->getSizeRepository()->getAllSize() as $size) : ?>
                <div class="list-size-input">
                    <input type="hidden" name="size_id[]" value="<?= $size->id ?>">
                    <label class="footer-description"> <?= $size->label ?></label>
                    <input type="number" step="0.01" class="form-control" name="price[]">
                </div>
            <?php endforeach ?>
        </div>
        <button type="submit" class="call-action">Créer la PIZZA !!!!!</button>
    </form>

</main>