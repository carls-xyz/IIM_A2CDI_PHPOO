<?php

class ActivityController
{
    use Render;

    /**
     * Affiche toutes les activités
     */
    public function index(): void
    {
        $activityModel = new ActivityModel();
        $activities = $activityModel->getAllActivities();
        
        $this->renderView('activity/index', [
            'activities' => $activities
        ]);
    }

    /**
     * Affiche les détails d'une activité
     * @param int $id ID de l'activité
     */
    public function show(int $id): void
    {
        $activityModel = new ActivityModel();
        $activity = $activityModel->getActivityById($id);
        
        if (!$activity) {
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }
        
        $this->renderView('activity/show', [
            'activity' => $activity
        ]);
    }

    /**
     * Affiche le formulaire de création d'activité (admin)
     */
    public function create(): void
    {
        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès non autorisé.";
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        $this->renderView('activity/create');
    }

    /**
     * Enregistre une nouvelle activité (admin)
     */
    public function store(): void
    {
        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès non autorisé.";
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->getBaseUrl() . '/activity/create');
            exit;
        }

        // Validation
        $errors = [];
        if (empty($_POST['nom'])) $errors[] = "Le nom est requis.";
        if (empty($_POST['type_id'])) $errors[] = "Le type est requis.";
        if (empty($_POST['places_disponibles']) || $_POST['places_disponibles'] < 1) {
            $errors[] = "Le nombre de places doit être supérieur à 0.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            header('Location: ' . $this->getBaseUrl() . '/activity/create');
            exit;
        }

        // Créer l'activité
        $activityModel = new ActivityModel();
        $stmt = $activityModel->getCo()->prepare(
            'INSERT INTO activities (nom, type_id, places_disponibles, description, datetime_debut, duree) 
             VALUES (:nom, :type_id, :places, :desc, :debut, :duree)'
        );
        
        $success = $stmt->execute([
            'nom' => htmlspecialchars($_POST['nom']),
            'type_id' => (int)$_POST['type_id'],
            'places' => (int)$_POST['places_disponibles'],
            'desc' => htmlspecialchars($_POST['description'] ?? ''),
            'debut' => $_POST['datetime_debut'] ?? date('Y-m-d H:i:s'),
            'duree' => htmlspecialchars($_POST['duree'] ?? '')
        ]);

        if ($success) {
            $_SESSION['success'] = "Activité créée avec succès !";
            header('Location: ' . $this->getBaseUrl() . '/');
        } else {
            $_SESSION['error'] = "Erreur lors de la création.";
            header('Location: ' . $this->getBaseUrl() . '/activity/create');
        }
        exit;
    }

    /**
     * Affiche le formulaire d'édition d'une activité (admin)
     * @param int $id ID de l'activité
     */
    public function edit(int $id): void
    {
        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès non autorisé.";
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        $activityModel = new ActivityModel();
        $activity = $activityModel->getActivityById($id);
        
        if (!$activity) {
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        $this->renderView('activity/edit', [
            'activity' => $activity
        ]);
    }

    /**
     * Met à jour une activité (admin)
     * @param int $id ID de l'activité (optionnel si en POST)
     * @param array $data Données de l'activité (optionnel)
     */
    public function update(int $id = 0, array $data = []): void
    {
        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès non autorisé.";
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $data = $_POST;
        }

        if (empty($id) || empty($data)) {
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        $activityModel = new ActivityModel();
        $stmt = $activityModel->getCo()->prepare(
            'UPDATE activities SET nom = :nom, type_id = :type_id, 
             places_disponibles = :places, description = :desc, 
             datetime_debut = :debut, duree = :duree WHERE id = :id'
        );
        
        $success = $stmt->execute([
            'id' => $id,
            'nom' => htmlspecialchars($data['nom']),
            'type_id' => (int)$data['type_id'],
            'places' => (int)$data['places_disponibles'],
            'desc' => htmlspecialchars($data['description'] ?? ''),
            'debut' => $data['datetime_debut'],
            'duree' => htmlspecialchars($data['duree'] ?? '')
        ]);

        if ($success) {
            $_SESSION['success'] = "Activité mise à jour avec succès !";
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour.";
        }

        header('Location: ' . $this->getBaseUrl() . '/activity/show?id=' . $id);
        exit;
    }

    /**
     * Supprime une activité et ses réservations (admin)
     * @param int $id ID de l'activité
     */
    public function delete(int $id): void
    {
        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès non autorisé.";
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        $activityModel = new ActivityModel();
        $reservationModel = new ReservationModel();
        
        // Supprimer d'abord les réservations associées
        $stmt = $reservationModel->getCo()->prepare(
            'DELETE FROM reservations WHERE activite_id = :id'
        );
        $stmt->execute(['id' => $id]);
        
        // Puis supprimer l'activité
        $stmt = $activityModel->getCo()->prepare(
            'DELETE FROM activities WHERE id = :id'
        );
        $success = $stmt->execute(['id' => $id]);

        if ($success) {
            $_SESSION['success'] = "Activité supprimée avec succès !";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression.";
        }

        header('Location: ' . $this->getBaseUrl() . '/');
        exit;
    }

    /**
     * Calcule l'URL de base
     * @return string URL de base
     */
    private function getBaseUrl(): string
    {
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        return ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;
    }
}