<h2>Inscription</h2>

<?php if (isset($_SESSION['errors'])): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form method="POST" action="<?= $base_url ?>/user/register">
    <div style="margin-bottom: 15px;">
        <label for="prenom">Prénom :</label><br>
        <input type="text" name="prenom" id="prenom" 
               value="<?= htmlspecialchars($_SESSION['old_data']['prenom'] ?? '') ?>" 
               required style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="nom">Nom :</label><br>
        <input type="text" name="nom" id="nom" 
               value="<?= htmlspecialchars($_SESSION['old_data']['nom'] ?? '') ?>" 
               required style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="email">Email :</label><br>
        <input type="email" name="email" id="email" 
               value="<?= htmlspecialchars($_SESSION['old_data']['email'] ?? '') ?>" 
               required style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="motdepasse">Mot de passe (min. 6 caractères) :</label><br>
        <input type="password" name="motdepasse" id="motdepasse" 
               required minlength="6" style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <button type="submit" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">
        S'inscrire
    </button>
</form>

<p style="margin-top: 20px;">
    Déjà inscrit ? <a href="<?= $base_url ?>/user/login">Se connecter</a>
</p>

<?php unset($_SESSION['old_data']); ?>