<?php

class ReservationModel extends Bdd
{
    /**
     * Crée une nouvelle réservation
     * @param int $userId ID de l'utilisateur
     * @param int $activityId ID de l'activité
     * @return bool Succès de l'opération
     */
    public function createReservation(int $userId, int $activityId): bool
    {
        $stmt = $this->co->prepare(
            'INSERT INTO reservations (user_id, activite_id, date_reservation, etat) 
             VALUES (:user_id, :activity_id, :date_reservation, :etat)'
        );
        
        $result = $stmt->execute([
            'user_id' => $userId,
            'activity_id' => $activityId,
            'date_reservation' => date('Y-m-d H:i:s'),
            'etat' => 1 // true = 1 en base de données
        ]);
        
        return $result;
    }

    /**
     * Récupère toutes les réservations d'un utilisateur
     * @param int $userId ID de l'utilisateur
     * @return array Liste des réservations
     */
    public function getReservationsByUserId(int $userId): array
    {
        $stmt = $this->co->prepare(
            'SELECT r.*, a.nom as activite_nom, a.datetime_debut, a.duree 
             FROM reservations r
             JOIN activities a ON r.activite_id = a.id
             WHERE r.user_id = :user_id
             ORDER BY r.date_reservation DESC'
        );
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère une réservation par son ID
     * @param int $id ID de la réservation
     * @return array|false Données de la réservation ou false
     */
    public function getReservationById(int $id): array|false
    {
        $stmt = $this->co->prepare(
            'SELECT r.*, a.nom as activite_nom, a.datetime_debut, a.duree, 
                    u.prenom, u.nom as user_nom, u.email
             FROM reservations r
             JOIN activities a ON r.activite_id = a.id
             JOIN users u ON r.user_id = u.id
             WHERE r.id = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Annule une réservation (met l'état à false/0)
     * @param int $reservationId ID de la réservation
     * @return bool Succès de l'opération
     */
    public function cancelReservation(int $reservationId): bool
    {
        $stmt = $this->co->prepare(
            'UPDATE reservations SET etat = 0 WHERE id = :reservation_id'
        );
        return $stmt->execute(['reservation_id' => $reservationId]);
    }

    /**
     * Récupère toutes les réservations (pour admin)
     * @return array Liste de toutes les réservations
     */
    public function getAllReservations(): array
    {
        $stmt = $this->co->prepare(
            'SELECT r.*, a.nom as activite_nom, u.prenom, u.nom as user_nom, u.email
             FROM reservations r
             JOIN activities a ON r.activite_id = a.id
             JOIN users u ON r.user_id = u.id
             ORDER BY r.date_reservation DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Vérifie si une réservation appartient à un utilisateur
     * @param int $reservationId ID de la réservation
     * @param int $userId ID de l'utilisateur
     * @return bool True si la réservation appartient à l'utilisateur
     */
    public function belongsToUser(int $reservationId, int $userId): bool
    {
        $stmt = $this->co->prepare(
            'SELECT COUNT(*) as count FROM reservations 
             WHERE id = :reservation_id AND user_id = :user_id'
        );
        $stmt->execute([
            'reservation_id' => $reservationId,
            'user_id' => $userId
        ]);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
}