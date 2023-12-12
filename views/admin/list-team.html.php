<?php

use Core\Session\Session; ?>
<div class="admin-container">
    <h1 class="title">L'équipe</h1>
<!-- boutton pour ajouter un nouveau membre -->
<di class="admin-box-add"> 
    <a class="call-action btn btn-primary" href="/admin/team/add">Ajouter un membre</a>
</di>
    <?php if ($form_result && $form_result->hasErrors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $form_result->getErrors()[0]->getMessage() ?>
        </div>
    <?php endif ?>
    <table class="table-user">
        <thead>
            <tr>
                <th class="footer-description">Nom</th>
                <th class="footer-description">Prénom</th>
                <th class="footer-description">Email</th>
                <th class="footer-description">Telephone</th>
                <th class="footer-description">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td class="footer-description"><?= $user->lastname ?></td>
                    <td class="footer-description"><?= $user->firstname ?></td>
                    <td class="footer-description"><?= $user->email ?></td>
                    <td class="footer-description"><?= $user->phone ?></td>
                    <td class="footer-description">
                        <!-- on vérifrie que l'id de l'user en session soit différent de l'id de l'user -->
                        <?php
                        $session_id = Session::get(Session::USER)->id;
                        if ($user->id != $session_id) : ?>
                            <a onClick="return confirm('Voulez-vous supprimer ce membre ?')" class="button-delete" href="/admin/user/delete/<?= $user->id ?>"><i class="bi bi-trash"></i></a>
                        <?php else : ?>
                            <span class="badge text-bg-success">Connecté</span>
                        <?php endif ?>
                        
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>