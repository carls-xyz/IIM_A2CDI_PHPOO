<h2><?= htmlspecialchars($activity['nom']) ?></h2>

<p><strong>Description :</strong> <?= htmlspecialchars($activity['description']) ?></p>
<p><strong>Type :</strong> <?= htmlspecialchars($activity['type_id']) ?></p>
<p><strong>Date de début :</strong> <?= htmlspecialchars($activity['datetime_debut']) ?></p>
<p><strong>Durée :</strong> <?= htmlspecialchars($activity['duree']) ?></p>
<p><strong>Places disponibles :</strong> <?= htmlspecialchars($activity['places_disponibles']) ?></p>

<?php if (isset($_SESSION['user'])): ?>
    <?php

    $activityModel = new ActivityModel();
    $placesLeft = $activityModel->getPlacesLeft($activity['id']);
    ?>
    
    <?php if ($placesLeft > 0): ?>
        <a href="<?= $base_url ?>/reservation/create?id=<?= $activity['id'] ?>" class="button">Réserver cette activité</a>
        <p><em><?= $placesLeft ?> place(s) restante(s)</em></p>
    <?php else: ?>
        <p style="color: red;"><strong>Complet - Aucune place disponible</strong></p>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
        <hr>
        <h3>Actions administrateur</h3>
        <a href="<?= $base_url ?>/activity/edit?id=<?= $activity['id'] ?>" class="button">Modifier</a>
        <form method="POST" action="<?= $base_url ?>/activity/delete?id=<?= $activity['id'] ?>" style="display: inline;">
            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette activité ?')">Supprimer</button>
        </form>
    <?php endif; ?>
<?php else: ?>
    <p><em>Connectez-vous pour réserver cette activité</em></p>
<?php endif; ?>

<br><br>
<a href="<?= $base_url ?>/">Retour à la liste</a>