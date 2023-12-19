<?php

use App\AppRepoManager;
use Core\Session\Session;
use App\Repository\UserRepository;

$user_id = Session::get(Session::USER)->id;
$userRepo = AppRepoManager::getRm()->getUserRepository();
$user = AppRepoManager::getRm()->getUserRepository()->findUserById(Session::get(Session::USER)->id);

?>

<div class="container-infos-user">
    <h1 class="title">Mon compte</h1>

    <form class="account-style" action="/user/update" method="post">

        <!-- création de tableau pour les données utilisateurs -->


        <table class="table-user">
            <thead>
                <tr>
                    <th class="footer-description">Nom </th>
                    <th class="footer-description">Prénom</th>
                    <th class="footer-description">Email</th>
                    <th class="footer-description">Telephone</th>
                    <th class="footer-description">Addresse</th>
                    <th class="footer-description">Code Postal</th>
                    <th class="footer-description">Ville</th>


                </tr>
            </thead>
            <tbody clas="modif-user">
                <tr>
                    <!-- Nom de famille -->
                    <input type="hidden"><?= $user->id ?></input>
                    <td class="footer-description modif-user-table">
                        <span name="lastname" id="lastname-<?= $user->id ?>" contenteditable="false"><?= htmlspecialchars($user->lastname) ?></span>
                        <button type="button" onclick="rendreEditable('lastname-<?= $user->id ?>')"><i class="bi bi-pencil btn-modif btn-acnt"></i></button>
                    </td>
                    <!-- Prénom -->
                    <td class="footer-description ">
                        <span name="firstname" id="firstname-<?= $user->id ?>" contenteditable="false"><?= htmlspecialchars($user->firstname) ?></span>
                        <button type="button" onclick="rendreEditable('firstname-<?= $user->id ?>')"><i class="bi bi-pencil btn-modif btn-acnt"></i></button>
                    </td>

                    <!-- Email -->
                    <td class="footer-description">
                        <span name="email" id="email-<?= $user->id ?>" contenteditable="false"><?= htmlspecialchars($user->email) ?></span>
                        <button type="button" onclick="rendreEditable('email-<?= $user->id ?>')"><i class="bi bi-pencil btn-modif btn-acnt"></i></button>
                    </td>
                    <!-- Téléphone -->
                    <td class="footer-description">
                        <span name="phone" id="phone-<?= $user->id ?>" contenteditable="false"><?= htmlspecialchars($user->phone) ?></span>
                        <button type="button" onclick="rendreEditable('phone-<?= $user->id ?>')"><i class="bi bi-pencil btn-modif btn-acnt"></i></button>
                    </td>
                    <!-- Adresse -->
                    <td class="footer-description">
                        <input name="addresse" class="inpt" type="text" id="address" placeholder="Entrez votre adresse">
                        <button type="button" onclick="rendreEditable('address')"><i class="bi bi-pencil btn-modif btn-acnt"></i></button>
                    </td>
                    <!-- Code postal -->
                    <td class="footer-description">
                        <input name="zipcode" type="text" id="zipcode" placeholder="Entrez votre code postal">
                        <button type="button" onclick="rendreEditable('zipcode')"><i class="bi bi-pencil btn-modif btn-acnt"></i></button>
                    </td>
                    <!-- ville -->
                    <td class="footer-description">
                        <input name="city" type="text" id="city" placeholder="Entrez votre adresse">
                        <button type="button" onclick="rendreEditable('city')"><i class="bi bi-pencil btn-modif btn-acnt"></i></button>
                    </td>

                    <!-- TODO: Enregistrer -->
                    <button type="submit" class="call-action">Enregistrer les modifications
    </form>

    </tr>
    </tbody>
    </table>
</div>

<!-- Javascript -->

<script>
    // Fonction pour rendre un élément éditable
    function rendreEditable(id) {
        // On récupère l'élément par son ID
        var element = document.getElementById(id);
        // On vérifie si l'élément est un élément <span>
        if (element.tagName === "SPAN") {
            // Si l'élément est span, on crée un nouvel élément <input>
            var inputElement = document.createElement("input");
            // On copie le contenu de l'élément <span> dans le nouvel élément <input>
            inputElement.value = element.textContent;
            // On récupère l'attribut "name" de l'élément <span>(si il en a un)
            var spanName = element.getAttribute("name");
            // On attribut le "name" au nouvel élément <input>
            if (spanName) {
                inputElement.setAttribute("name", spanName);
            }
            // On peut maintenant remplacer l'élément <span> par le nouvel élément <input> dans le DOM
            element.parentNode.replaceChild(inputElement, element);
            // On rend le nouvel élément <input> éditable
            inputElement.contentEditable = "true";
            // On met le focus sur le nouvel élément <input> (permet à l'user d'écrire directement)
            inputElement.focus();
        } else {
            // Si l'élément n'est pas un <span>, on retire le mode lecture seule pour le rendre éditable
            element.readOnly = false;
            // On met alors le focus sur cet élément
            element.focus();
        }
    }
</script>
