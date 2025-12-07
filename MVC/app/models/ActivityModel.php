<?php

class ActivityModel extends Bdd
{ 
    /**
     * Récupère toutes les activités
     * @return array Liste des activités
     */
    public function getAllActivities(): array
    {
        $stmt = $this->co->prepare('SELECT * FROM activities ORDER BY datetime_debut ASC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Récupère une activité par son ID
     * @param int $id ID de l'activité
     * @return array|false Données de l'activité ou false
     */
    public function getActivityById(int $id): array|false
    {
        $stmt = $this->co->prepare('SELECT * FROM activities WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Calcule le nombre de places restantes pour une activité
     * @param int $activityId ID de l'activité
     * @return int Nombre de places restantes
     */
    public function getPlacesLeft(int $activityId): int
    {
        // Récupérer le nombre de places disponibles
        $stmt = $this->co->prepare(
            'SELECT places_disponibles FROM activities WHERE id = :id'
        );
        $stmt->execute(['id' => $activityId]);
        $activity = $stmt->fetch();
        
        if (!$activity) {
            return 0;
        }
        
        $placesDisponibles = (int)$activity['places_disponibles'];
        
        // Compter le nombre de réservations actives (etat = 1)
        $stmt = $this->co->prepare(
            'SELECT COUNT(*) as count FROM reservations 
             WHERE activite_id = :id AND etat = 1'
        );
        $stmt->execute(['id' => $activityId]);
        $result = $stmt->fetch();
        $reservationsActives = (int)$result['count'];
        
        // Calculer les places restantes
        return max(0, $placesDisponibles - $reservationsActives);
    }
}