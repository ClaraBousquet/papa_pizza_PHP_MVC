
<?php use Core\Session\Session; 
use Core\Form\FormResult;
$form_result = Session::get('form_result');
?>
<div class="admin-container">
    <h1 class="title">Vos pizzas</h1>
        <!-- on va afficher les erreurs s'il y en a -->
        <?php if ($form_result && $form_result->hasErrors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $form_result->getErrors()[0]->getMessage() ?>
            </div>
        <?php endif ?>
    <table class="table-user">
        <thead>
            <tr>
                <th class="footer-description">Nom</th>
                <th class="footer-description"> Taille et Prix</th>
                <th class="footer-description">Ingredients</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pizzas as $pizza) : ?>
                <tr>
                    <td class="footer-description"><?= $pizza->name ?></td>
                    <td class="footer-description">
                        <?php foreach($pizza->prices as $price): ?>
                            <p><?= $price->size->label ?> : <?= number_format($price->price, 2, ',', ' ') ?></p>
                        <?php endforeach ?>
                    </td>
                    <td class="footer-description">
                        <?php foreach($pizza->ingredients as $ingredient) : ?>
                            <p><?= $ingredient->label ?></p>
                        <?php endforeach ?>
                    </td>
                  
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>   