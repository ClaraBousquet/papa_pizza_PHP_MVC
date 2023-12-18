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
                        <span class="name" id="name"><img class="admin-img-pizza" src="/assets/images/pizza/<?= $pizza->image_path ?>" alt="<?= $pizza->name ?>"></span>
                        <button type="button" onclick="rendreEditable('name')"><i class="bi bi-pencil btn-modif btn-acnt"></i></button>

                    </td>

                    <td class="footer-description">
                        <?php foreach ($pizza->prices as $price) : ?>
                            <span name="price" id="price"><?= $price->size->label ?> : <?= number_format($price->price, 2, ',', '') ?>€</span>
                        <?php endforeach ?>
                            <button type="button" onclick="rendreEditable('price')"><i class="bi bi-pencil btn-modif btn-acnt"></i></button>
                    </td>
                    <td class="footer-description">
                        <?php foreach ($pizza->ingredients as $ingredient) : ?>
                            <span class="ingredient" id="ingredient"> <?= $ingredient->label ?></span>

                        <?php endforeach ?>
                            <button type="button" onclick="rendreEditable('ingredient')"><i class="bi bi-pencil btn-modif btn-acnt"></i></button>
                    </td>
                    <td class="footer-description">

                        <!-- on vérifrie que l'id de l'user en session soit différent de l'id de l'user -->
                            <a onClick="return confirm('Voulez-vous supprimer cette pizza ?')" class="button-delete" href="/admin/pizza/delete/<?= $pizza->id ?>"><i class="bi bi-trash"></i></a>

                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>


<!-- javascript -->
<script>
  function rendreEditable(id) { 

    var element = document.getElementById(id); 
    if (element.tagName === "SPAN") { 
        // Créer un nouvel élément input 
        var inputElement = document.createElement("input"); 
        // Copie du contenu du span dans l'input 
        inputElement.value = element.textContent; 
        // Récupérer le nom du span 
        var spanName = element.getAttribute("name"); 
        // attribuer-le nom à l'input 
        if (spanName) { 
            inputElement.setAttribute("name", spanName); 
        } 
        // Remplacez le span par l'input 
        element.parentNode.replaceChild(inputElement, element); 
        // Rendez l'input éditable 
        inputElement.contentEditable = "true"; 
        // Donnez-lui le focus 
        inputElement.focus()
    } else { 
        element.readOnly = false; 
        element.focus(); 
    } 
} 
</script>