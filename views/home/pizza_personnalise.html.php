<?php

use App\AppRepoManager;
use Core\Session\Session;




$user_id = Session::get(Session::USER)->id;
?>


<main class="container-pizza-perso">
    <h1 class="title title-perso">Je crée ma pizza ! 🧑‍🍳</h1>

    <form action="/add-pizza-perso-form" method="post" class="form-perso">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <div class="box-perso-name">
            <label class="sub-title test">Nom de ma pizza</label>
            <input type="text" class="form-control name-perso" name="name">
        </div>
        <div class="img-container-perso">
            <h2 class="sub-title">Je choisis les ingrédients (5maximum)</h2>
            <div class="box-pizza-perso list-ingredient">
                <!-- on affiche la liste des ingredients -->
                <?php foreach (AppRepoManager::getRm()->getIngredientRepository()->getIngredientActive() as $ingredient) : ?>
                    <div class="form-check">
                        <input name="ingredients[]" value="<?= $ingredient->id ?>" class="form-check-input form-perso ingredient-checkbox" type="checkbox" role="switch" id="defaultCheck1" onclick="limitCheckbox()">
                        <label class="form-check-label footer-description m-1" for="defaultCheck1"><?= $ingredient->label ?></label>

                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <div class="box-perso-size list-size">
            <label class="sub-title test">Je choisis la taille</label>
            <?php
            $sizes = AppRepoManager::getRm()->getSizeRepository()->getAllSize();
            $sizeCount = count($sizes);
            for ($i = 0; $i < $sizeCount; $i++) :
                $size = $sizes[$i];
            ?>
                <div class="form-check">
                    <input class="size" type="radio" name="size_id" value="<?= $size->id ?>"  ?>">
                    <label class="footer-description" for="defaultCheck<?= $size->id ?>"><?= $size->label ?></label>
                </div>
            <?php endfor; ?>
        </div>
        <button type="submit" class="call-action btn-perso">Créer la pizza 🍕!</button>
    </form>
</main>
</form>
           

<!-- Javascript  -->
<script>
    // Fonction pour limiter le nombre de cases à cocher
    function limitCheckbox() {
        // On définit  le nombre maximal de cases à cocher 
        const maxChecked = 5;
       // console.log("Nombre max autorisé de cases cochées : ", maxChecked);
        // On récupère tous les éléments du DOM avec la classe 'ingredient-checkbox'
        const checkboxes = document.querySelectorAll('.ingredient-checkbox');
        // Calcul du nombre de cases actuellement cochées
        const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
        //console.log("Nombre actuel de cases cochées : ", checkedCount);
        // Parcours de chaque checkbox
        checkboxes.forEach(cb => {
            // Désactivation des cases non cochées si le nombre maximal est atteint
            if (!cb.checked) {
                cb.disabled = checkedCount >= maxChecked;
            }
        });
    }
</script>
