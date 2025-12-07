<h2>Liste des utilisateurs (Administration)</h2>

<?php if (empty($users)): ?>
    <p>Aucun utilisateur inscrit.</p>
<?php else: ?>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">ID</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Nom</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Prénom</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Email</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Rôle</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?= $user['id'] ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?= htmlspecialchars($user['nom']) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?= htmlspecialchars($user['prenom']) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?= htmlspecialchars($user['email']) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                        <?php if ($user['role'] === 'admin'): ?>
                            <span style="color: #e74c3c; font-weight: bold;">Admin</span>
                        <?php else: ?>
                            <span style="color: #3498db;">Utilisateur</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<br>
<a href="<?= $base_url ?>/">← Retour à l'accueil</a>