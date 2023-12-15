


<form action="/admin/pizza/edit/<?= $pizza->id ?>" method="post" enctype="multipart/form-data">
        <h1 class="title title-detail">Modifier: <?= $pizza->name ?></h1>
        <?php if (isset($pizza)): ?>
<h1 class="title title-detail"><?= htmlspecialchars($pizza->name) ?></h1>
<!-- Plus de code pour afficher les détails de la pizza -->
<?php endif; ?>
<!-- Champ pour modifier le nom de la pizza -->
     <input type="text" name="name" value="<?= $pizza->name ?>">
<!-- Affichage et modification de l'image -->
        <div class="box-image-detail">
            <img class="image-detail" src="/assets/images/pizza/<?= $pizza->image_path ?>" alt="image de <?= $pizza->name ?>">
            <input type="file" name="image_path">
        </div>
<!-- Liste des ingrédients à cocher pour modification -->
    <div class="box-pizza-perso list-ingredient">
        <?php foreach ($allIngredients as $ingredient) : ?>
    <div class="form-check">
            <input name="ingredients[]" value="<?= $ingredient->id ?>" class="form-check-input" type="checkbox" <?= in_array($ingredient->id, $pizzaIngredientIds) ? 'checked' : '' ?>>
            <label class="form-check-label"><?= $ingredient->label ?></label>
    </div>
        <?php endforeach; ?>
    </div>
    <!-- Prix et tailles -->
    <!-- Prix et taille similaire à pizza_detail, avec possibilité de modification) -->



    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
</form>