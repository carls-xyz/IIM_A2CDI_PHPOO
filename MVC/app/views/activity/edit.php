<h2>Modifier l'activité</h2>

<form method="POST" action="<?= $base_url ?>/activity/update">
    <input type="hidden" name="id" value="<?= $activity['id'] ?>">
    
    <div style="margin-bottom: 15px;">
        <label for="nom">Nom de l'activité :</label><br>
        <input type="text" name="nom" id="nom" required 
               value="<?= htmlspecialchars($activity['nom']) ?>"
               style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="type_id">Type d'activité :</label><br>
        <select name="type_id" id="type_id" required 
                style="width: 100%; padding: 8px; margin-top: 5px;">
            <option value="1" <?= $activity['type_id'] == 1 ? 'selected' : '' ?>>Sport</option>
            <option value="2" <?= $activity['type_id'] == 2 ? 'selected' : '' ?>>Culture</option>
            <option value="3" <?= $activity['type_id'] == 3 ? 'selected' : '' ?>>Aventure</option>
            <option value="4" <?= $activity['type_id'] == 4 ? 'selected' : '' ?>>Détente</option>
        </select>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="places_disponibles">Nombre de places disponibles :</label><br>
        <input type="number" name="places_disponibles" id="places_disponibles" min="1" required 
               value="<?= htmlspecialchars($activity['places_disponibles']) ?>"
               style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="description">Description :</label><br>
        <textarea name="description" id="description" rows="5" required 
                  style="width: 100%; padding: 8px; margin-top: 5px;"><?= htmlspecialchars($activity['description']) ?></textarea>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="datetime_debut">Date et heure de début :</label><br>
        <input type="datetime-local" name="datetime_debut" id="datetime_debut" required 
               value="<?= date('Y-m-d\TH:i', strtotime($activity['datetime_debut'])) ?>"
               style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="duree">Durée :</label><br>
        <input type="text" name="duree" id="duree" required 
               value="<?= htmlspecialchars($activity['duree']) ?>"
               style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <button type="submit" style="padding: 10px 20px; background-color: #ffc107; color: black; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">
        Enregistrer les modifications
    </button>
    <a href="<?= $base_url ?>/activity/show?id=<?= $activity['id'] ?>" 
       style="padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px;">
        Annuler
    </a>
</form>