<?php

use App\AppRepoManager;
use Core\Session\Session;

function getDefaultPrice($sizeLabel)
{
    switch ($sizeLabel) {
        case 'small (24cm)':
            return 5;
        case 'medium (32cm)':
            return 8;
        case 'large (40cm)':
            return 10;
        default:
            return 0;
    }
}


$user_id = Session::get(Session::USER)->id;
?>


<main class="container-pizza-perso">
    <h1 class="title title-perso">Je crée ma pizza ! 🧑‍🍳</h1>
    <!-- on va afficher les erreurs s'il y en a -->

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
                    <input class="size" type="radio" name="size_id" value="<?= $size->id ?>" data-price="<?= getDefaultPrice($size->label) ?>">
                    <label class="footer-description" for="defaultCheck<?= $size->id ?>"><?= $size->label ?></label>
                    <span class="price-display"><?= getDefaultPrice($size->label) ?> €</span>
                </div>

            <?php endfor; ?>
        </div>



        <button type="submit" class="call-action btn-perso">Créer la pizza 🍕!</button>
    </form>

    <!-- tableau pour afficher le prix -->


</main>
</form>

<script>
    function limitCheckbox() {
        const maxChecked = 5;
        const checkboxes = document.querySelectorAll('.ingredient-checkbox');
        const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
        checkboxes.forEach(cb => {
            if (!cb.checked) cb.disabled = checkedCount >= maxChecked;
        });
    }



</script>