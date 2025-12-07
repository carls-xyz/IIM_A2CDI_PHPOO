<h2>Réserver : <?= htmlspecialchars($activity['nom']) ?></h2>

<div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
    <p><strong>Description :</strong> <?= htmlspecialchars($activity['description']) ?></p>
    <p><strong>Date de début :</strong> <?= htmlspecialchars($activity['datetime_debut']) ?></p>
    <p><strong>Durée :</strong> <?= htmlspecialchars($activity['duree']) ?></p>
    <p><strong>Places restantes :</strong> <?= $places_left ?> / <?= $activity['places_disponibles'] ?></p>
</div>

<?php if ($places_left > 0): ?>
    <form method="POST" action="<?= $base_url ?>/reservation/store">
        <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>">
        
        <p>Confirmez-vous vouloir réserver cette activité ?</p>
        
        <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">
            Confirmer la réservation
        </button>
        <a href="<?= $base_url ?>/activity/show?id=<?= $activity['id'] ?>" style="padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px;">
            Annuler
        </a>
    </form>
<?php else: ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        Désolé, cette activité est complète.
    </div>
    <a href="<?= $base_url ?>/">Retour aux activités</a>
<?php endif; ?>