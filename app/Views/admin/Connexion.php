<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <?=link_tag('styles/admin/admin.css');?>
</head>
<body>

<div class="login-container">

    <h2>Espace de connexion</h2>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?= form_open('/gingembre/loginCheck'); ?>

    <div class="input-field">
        <?= form_input([
                'name' => 'user',
                'placeholder' => "Nom d'utilisateur",
                'required' => true,
                'value' => set_value('user')
        ]); ?>
    </div>

    <div class="input-field">
        <?= form_password([
                'name' => 'mdp',
                'placeholder' => "Mot de passe",
                'required' => true
        ]); ?>
    </div>

    <button class="btn-submit" type="submit">Se connecter</button>

    <?= form_close(); ?>

    <?= anchor('/', '⬅️ Retour au site', ['class' => 'btn-back']); ?>

</div>

</body>
</html>