<?php

use Core\Session\Session; ?>
<div class="admin-container">
    <h1 class="title">Les stars</h1>
    <!-- boutton pour ajouter un nouveau membre -->
    <di class="admin-box-add">
        <a class="call-action btn btn-primary" href="/admin/pizza/add">Ajouter une pizzas</a>
    </di>
    <?php if ($form_result && $form_result->hasErrors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $form_result->getErrors()[0]->getMessage() ?>
        </div>
    <?php endif ?>
    <table class="table-user">
        <thead>
            <tr>
                <th class="footer-description">Nom de la pizza</th>
                <th class="footer-description">Photo</th>
                <th class="footer-description">prix</th>
                <th class="footer-description">ingrédient</th>
                <th class="footer-description">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pizzas as $pizza) : ?>
                <tr>
                    <td class="footer-description"><?= $pizza->name ?></td>
                    <td class="footer-description">
                        <img class="admin-img-pizza" src="/assets/images/pizza/<?= $pizza->image_path ?>" alt="<?= $pizza->name ?>">
                    </td>

                    <td class="footer-description">
                        <?php foreach ($pizza->prices as $price) : ?>
                            <p><?= $price->size->label ?> : <?= number_format($price->price, 2, ',', '') ?>€</p>
                        <?php endforeach ?>
                    </td>
                    <td class="footer-description">
                        <?php foreach ($pizza->ingredients as $ingredient) : ?>
                            <p> <?= $ingredient->label ?></p>
                        <?php endforeach ?>
                    </td>
                    <td class="footer-description">

                        <!-- on vérifrie que l'id de l'user en session soit différent de l'id de l'user -->
                            <a onClick="return confirm('Voulez-vous supprimer cette pizza ?')" class="button-delete" href="/admin/pizza/delete/<?= $pizza->id ?>"><i class="bi bi-trash"></i></a>
                            <a onClick="return confirm('Voulez-vous supprimer cette pizza ?')" class="button-delete" href="/admin/pizza/edit/<?= $pizza->id ?>"><i class="bi bi-pencil"></i></a>

                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>