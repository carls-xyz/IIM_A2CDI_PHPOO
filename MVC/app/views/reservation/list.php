<h2>Toutes les réservations (Administration)</h2>

<?php if (empty($reservations)): ?>
    <p>Aucune réservation dans le système.</p>
<?php else: ?>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">ID</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Utilisateur</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Email</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Activité</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Date réservation</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Statut</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?= $reservation['id'] ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?= htmlspecialchars($reservation['prenom']) ?> <?= htmlspecialchars($reservation['user_nom']) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?= htmlspecialchars($reservation['email']) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?= htmlspecialchars($reservation['activite_nom']) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?= htmlspecialchars($reservation['date_reservation']) ?>
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
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<br>
<a href="<?= $base_url ?>/">← Retour à l'accueil</a>