<h2>Créer une nouvelle activité</h2>

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

<form method="POST" action="<?= $base_url ?>/activity/store">
    <div style="margin-bottom: 15px;">
        <label for="nom">Nom de l'activité :</label><br>
        <input type="text" name="nom" id="nom" required 
               value="<?= htmlspecialchars($_SESSION['old_data']['nom'] ?? '') ?>"
               style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="type_id">Type d'activité :</label><br>
        <select name="type_id" id="type_id" required 
                style="width: 100%; padding: 8px; margin-top: 5px;">
            <option value="">-- Sélectionner --</option>
            <option value="1">Sport</option>
            <option value="2">Culture</option>
            <option value="3">Aventure</option>
            <option value="4">Détente</option>
        </select>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="places_disponibles">Nombre de places disponibles :</label><br>
        <input type="number" name="places_disponibles" id="places_disponibles" min="1" required 
               value="<?= htmlspecialchars($_SESSION['old_data']['places_disponibles'] ?? '10') ?>"
               style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="description">Description :</label><br>
        <textarea name="description" id="description" rows="5" required 
                  style="width: 100%; padding: 8px; margin-top: 5px;"><?= htmlspecialchars($_SESSION['old_data']['description'] ?? '') ?></textarea>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="datetime_debut">Date et heure de début :</label><br>
        <input type="datetime-local" name="datetime_debut" id="datetime_debut" required 
               value="<?= htmlspecialchars($_SESSION['old_data']['datetime_debut'] ?? date('Y-m-d\TH:i')) ?>"
               style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="duree">Durée (ex: 2h, 1h30) :</label><br>
        <input type="text" name="duree" id="duree" required 
               value="<?= htmlspecialchars($_SESSION['old_data']['duree'] ?? '2h') ?>"
               style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">
        Créer l'activité
    </button>
    <a href="<?= $base_url ?>/" style="padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px;">
        Annuler
    </a>
</form>

<?php unset($_SESSION['old_data']); ?>