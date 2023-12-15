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

    <form action="/user/update" method="post">

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
                    <td class="footer-description modif-user-table">
                        <span id="lastname-<?= $user->id ?>" contenteditable="false"><?= htmlspecialchars($user->lastname) ?></span>
                        <button type="button" onclick="rendreEditable('lastname-<?= $user->id ?>')"><i class="bi bi-pencil btn-modif"></i></button>
                    </td>

                    <!-- Prénom -->
                    <td class="footer-description ">
                        <span id="firstname-<?= $user->id ?>" contenteditable="false"><?= htmlspecialchars($user->firstname) ?></span>
                        <button type="button" onclick="rendreEditable('firstname-<?= $user->id ?>')"><i class="bi bi-pencil btn-modif"></i></button>
                    </td>

                    <!-- Email -->
                    <td class="footer-description">
                        <span id="email-<?= $user->id ?>" contenteditable="false"><?= htmlspecialchars($user->email) ?></span>
                        <button type="button" onclick="rendreEditable('email-<?= $user->id ?>')"><i class="bi bi-pencil btn-modif"></i></button>
                    </td>
                    <!-- Téléphone -->
                    <td class="footer-description">
                        <span id="phone-<?= $user->id ?>" contenteditable="false"><?= htmlspecialchars($user->phone) ?></span>
                        <button type="button" onclick="rendreEditable('phone-<?= $user->id ?>')"><i class="bi bi-pencil btn-modif "></i></button>
                    </td>
                    <!-- Adresse -->
                    <td class="footer-description">
                        <input type="text" id="address" placeholder="Entrez votre adresse">
                        <button type="button" onclick="rendreEditable('address')"><i class="bi bi-pencil btn-modif"></i></button>
                    </td>
                    <!-- Code postal -->
                    <td class="footer-description">
                        <input type="text" id="zipcode" placeholder="Entrez votre code postal">
                        <button type="button" onclick="rendreEditable('zipcode')"><i class="bi bi-pencil btn-modif"></i></button>
                    </td>
                    <!-- ville -->
                    <td class="footer-description">
                        <input type="text" id="city" placeholder="Entrez votre adresse">
                        <button type="button" onclick="rendreEditable('city')"><i class="bi bi-pencil btn-modif"></i></button>
                    </td>

                    <!-- TODO: Enregistrer -->
                    <button type="submit" class="call-action">Enregistrer les modifications
    </form>

    </tr>
    </tbody>
    </table>
</div>

<script>
    function rendreEditable(id) {
        var element = document.getElementById(id);
        if (element.tagName === "SPAN") {
            element.contentEditable = "true";
        } else {
            element.readOnly = false;
        }
        element.focus();
    }
</script>