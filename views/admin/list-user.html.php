<div class="admin-container">
    <h1 class="title">Liste des Clients</h1>
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
            <?php foreach($users as $user): ?>
                <tr>
                    <td class="footer-description"><?= $user->lastname ?></td>
                    <td class="footer-description"><?= $user->firstname ?></td>
                    <td class="footer-description"><?= $user->email ?></td>
                    <td class="footer-description"><?= $user->phone ?></td>
                    <td class="footer-description">
                        <a onClick="return confirm('Voulez-vous supprimer ce client ?')" class="button-delete" href="/admin/user/delete/<?= $user->id ?>"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach ?>
        </tbody>
    </table>
</div>