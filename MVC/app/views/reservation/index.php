<h2>Mes réservations</h2>

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

<?php if (empty($reservations)): ?>
    <p>Vous n'avez aucune réservation pour le moment.</p>
    <a href="<?= $base_url ?>/" class="button">Voir les activités disponibles</a>
<?php else: ?>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Activité</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Date de début</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Durée</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Statut</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?= htmlspecialchars($reservation['activite_nom']) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?= htmlspecialchars($reservation['datetime_debut']) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?= htmlspecialchars($reservation['duree']) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                        <?php if ($reservation['etat']): ?>
                            <span style="color: green; font-weight: bold;">✓ Confirmée</span>
                        <?php else: ?>
                            <span style="color: red; font-weight: bold;">✗ Annulée</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                        <a href="<?= $base_url ?>/reservation/show?id=<?= $reservation['id'] ?>">Détails</a>
                        <?php if ($reservation['etat']): ?>
                            |
                            <a href="<?= $base_url ?>/reservation/cancel?id=<?= $reservation['id'] ?>" 
                               style="color: red;"
                               onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                Annuler
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>