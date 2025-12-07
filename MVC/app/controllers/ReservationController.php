<?php

class ReservationController
{
    use Render;

    /**
     * Affiche les réservations de l'utilisateur connecté
     */
    public function index(): void
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->getBaseUrl() . '/user/login');
            exit;
        }

        $reservationModel = new ReservationModel();
        $reservations = $reservationModel->getReservationsByUserId($_SESSION['user']['id']);
        
        $this->renderView('reservation/index', [
            'reservations' => $reservations
        ]);
    }

    /**
     * Affiche le formulaire de création de réservation
     * @param int $id ID de l'activité à réserver
     */
    public function create(int $id): void
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->getBaseUrl() . '/user/login');
            exit;
        }

        $activityModel = new ActivityModel();
        $activity = $activityModel->getActivityById($id);
        
        if (!$activity) {
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        // Vérifier les places disponibles
        $placesLeft = $activityModel->getPlacesLeft($id);
        
        $this->renderView('reservation/create', [
            'activity' => $activity,
            'places_left' => $placesLeft
        ]);
    }

    /**
     * Enregistre une nouvelle réservation
     */
    public function store(): void
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->getBaseUrl() . '/user/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        $activityId = (int)$_POST['activity_id'];
        $userId = $_SESSION['user']['id'];

        // Vérifier les places disponibles
        $activityModel = new ActivityModel();
        $placesLeft = $activityModel->getPlacesLeft($activityId);

        if ($placesLeft <= 0) {
            $_SESSION['error'] = "Désolé, cette activité est complète.";
            header('Location: ' . $this->getBaseUrl() . '/activity/show?id=' . $activityId);
            exit;
        }

        // Créer la réservation
        $reservationModel = new ReservationModel();
        $success = $reservationModel->createReservation($userId, $activityId);

        if ($success) {
            $_SESSION['success'] = "Réservation effectuée avec succès !";
            header('Location: ' . $this->getBaseUrl() . '/reservation');
        } else {
            $_SESSION['error'] = "Erreur lors de la réservation.";
            header('Location: ' . $this->getBaseUrl() . '/activity/show?id=' . $activityId);
        }
        exit;
    }

    /**
     * Affiche les détails d'une réservation
     * @param int $id ID de la réservation
     */
    public function show(int $id): void
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->getBaseUrl() . '/user/login');
            exit;
        }

        $reservationModel = new ReservationModel();
        $reservation = $reservationModel->getReservationById($id);

        if (!$reservation) {
            header('Location: ' . $this->getBaseUrl() . '/reservation');
            exit;
        }

        // Vérifier que la réservation appartient à l'utilisateur (sauf admin)
        if ($_SESSION['user']['role'] !== 'admin' && 
            $reservation['user_id'] !== $_SESSION['user']['id']) {
            $_SESSION['error'] = "Vous n'avez pas accès à cette réservation.";
            header('Location: ' . $this->getBaseUrl() . '/reservation');
            exit;
        }

        $this->renderView('reservation/show', [
            'reservation' => $reservation
        ]);
    }

    /**
     * Annule une réservation
     * @param int $id ID de la réservation
     */
    public function cancel(int $id): void
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->getBaseUrl() . '/user/login');
            exit;
        }

        $reservationModel = new ReservationModel();
        $reservation = $reservationModel->getReservationById($id);

        if (!$reservation) {
            $_SESSION['error'] = "Réservation introuvable.";
            header('Location: ' . $this->getBaseUrl() . '/reservation');
            exit;
        }

        // Vérifier que la réservation appartient à l'utilisateur (sauf admin)
        if ($_SESSION['user']['role'] !== 'admin' && 
            !$reservationModel->belongsToUser($id, $_SESSION['user']['id'])) {
            $_SESSION['error'] = "Vous ne pouvez pas annuler cette réservation.";
            header('Location: ' . $this->getBaseUrl() . '/reservation');
            exit;
        }

        // Annuler la réservation
        $success = $reservationModel->cancelReservation($id);

        if ($success) {
            $_SESSION['success'] = "Réservation annulée avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de l'annulation.";
        }

        header('Location: ' . $this->getBaseUrl() . '/reservation');
        exit;
    }

    /**
     * Liste toutes les réservations (admin seulement)
     */
    public function listAll(): void
    {
        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès non autorisé.";
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        $reservationModel = new ReservationModel();
        $reservations = $reservationModel->getAllReservations();

        $this->renderView('reservation/list', [
            'reservations' => $reservations
        ]);
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