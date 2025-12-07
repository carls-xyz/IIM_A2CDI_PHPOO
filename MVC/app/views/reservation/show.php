<h2>Détails de la réservation #<?= $reservation['id'] ?></h2>

<div style="background-color: #f9f9f9; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
    <h3>Activité</h3>
    <p><strong>Nom :</strong> <?= htmlspecialchars($reservation['activite_nom']) ?></p>
    <p><strong>Date de début :</strong> <?= htmlspecialchars($reservation['datetime_debut']) ?></p>
    <p><strong>Durée :</strong> <?= htmlspecialchars($reservation['duree']) ?></p>
    
    <hr style="margin: 20px 0;">
    
    <h3>Réservation</h3>
    <p><strong>Date de réservation :</strong> <?= htmlspecialchars($reservation['date_reservation']) ?></p>
    <p><strong>Statut :</strong> 
        <?php if ($reservation['etat']): ?>
            <span style="color: green; font-weight: bold;">✓ Confirmée</span>
        <?php else: ?>
            <span style="color: red; font-weight: bold;">✗ Annulée</span>
        <?php endif; ?>
    </p>
    
    <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
        <hr style="margin: 20px 0;">
        <h3>Informations utilisateur (admin)</h3>
        <p><strong>Nom :</strong> <?= htmlspecialchars($reservation['prenom']) ?> <?= htmlspecialchars($reservation['user_nom']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($reservation['email']) ?></p>
    <?php endif; ?>
</div>

<?php if ($reservation['etat']): ?>
    <a href="<?= $base_url ?>/reservation/cancel?id=<?= $reservation['id'] ?>" 
       style="padding: 10px 20px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 5px; display: inline-block;"
       onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
        Annuler la réservation
    </a>
<?php endif; ?>

<br><br>
<a href="<?= $base_url ?>/reservation">← Retour à mes réservations</a>