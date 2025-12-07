<h2>Connexion</h2>

<?php if (isset($_SESSION['success'])): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form method="POST" action="<?= $base_url ?>/user/login">
    <div style="margin-bottom: 15px;">
        <label for="email">Email :</label><br>
        <input type="email" name="email" id="email" required 
               style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="motdepasse">Mot de passe :</label><br>
        <input type="password" name="motdepasse" id="motdepasse" required 
               style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <button type="submit" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">
        Se connecter
    </button>
</form>

<p style="margin-top: 20px;">
    Pas encore inscrit ? <a href="<?= $base_url ?>/user/register">Créer un compte</a>
</p>