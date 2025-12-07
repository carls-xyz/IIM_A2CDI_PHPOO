<h2 style="text-align: center; color: #13587dff;">Liste des activités</h2>

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

<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
    <div style="margin-bottom: 20px; text-align: right;">
        <a href="<?= $base_url ?>/activity/create" 
           style="padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;">
            + Ajouter une activité
        </a>
    </div>
<?php endif; ?>

<?php if (empty($activities)): ?>
    <p>Aucune activité disponible pour le moment.</p>
<?php else: ?>
    <ul style="list-style: none; padding: 0;">
        <?php foreach ($activities as $activity): ?>
            <li style="margin-bottom: 15px; padding: 15px; background-color: #f9f9f9; border-radius: 5px;">
                <h3 style="margin: 0 0 10px 0;">
                    <a style="text-decoration: none; color: #13587dff;" 
                       href="<?= $base_url ?>/activity/show?id=<?= $activity['id'] ?>">
                        <?= htmlspecialchars($activity['nom']) ?>
                    </a>
                </h3>
                <p style="margin: 5px 0; color: #666;">
                    <strong>Date :</strong> <?= htmlspecialchars($activity['datetime_debut']) ?>
                    | <strong>Durée :</strong> <?= htmlspecialchars($activity['duree']) ?>
                    | <strong>Places :</strong> <?= htmlspecialchars($activity['places_disponibles']) ?>
                </p>
                <p style="margin: 10px 0 0 0; color: #333;">
                    <?= htmlspecialchars(substr($activity['description'], 0, 150)) ?><?= strlen($activity['description']) > 150 ? '...' : '' ?>
                </p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>