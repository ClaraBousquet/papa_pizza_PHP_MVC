<main class="container-form">
    <h1 class="title">Nouveau membre</h1>
    <!-- on va afficher les erreurs s'il y en a -->
    <?php if ($form_result && $form_result->hasErrors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $form_result->getErrors()[0]->getMessage() ?>
        </div>
    <?php endif ?>


    <form class="auth-form" action="/register-team" method="POST">
        <div class="box-auth-input">
            <label class="detail-description">Adresse email</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="box-auth-input">
            <label class="detail-description">Mot de passe</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="box-auth-input">
            <label class="detail-description">Confirmer mot de passe</label>
            <input type="password" class="form-control" name="password_confirm">
        </div>
        <div class="box-auth-input">
            <label class="detail-description">Son nom</label>
            <input type="text" class="form-control" name="lastname">
        </div>
        <div class="box-auth-input">
            <label class="detail-description">Son prénom</label>
            <input type="text" class="form-control" name="firstname">
        </div>
        <div class="box-auth-input">
            <label class="detail-description">Son téléphone</label>
            <input type="number" class="form-control" name="phone">
        </div>
        <button type="submit" class="call-action">Créer le membre !</button>
    </form>

</main>