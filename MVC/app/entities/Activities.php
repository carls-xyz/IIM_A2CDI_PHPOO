<?php

class Activities
{
    private int $id;
    private string $nom;
    private int $type_id;
    private int $places_disponibles;
    private string $description;
    private string $datetime_debut;
    private string $duree;

public function getId(): int
{
    return $this->id;
}
public function setId(int $id): self
{
    $this->id = $id;
    return $this;
}
public function getNom(): string
{
    return $this->nom;
}
public function setNom(string $nom): self
{
    $this->nom = $nom;
    return $this;
}
public function getType_id(): int
{
    return $this->type_id;
}
public function setType_id(int $type_id): self
{
    $this->type_id = $type_id;
    return $this;
}
public function getPlaces_disponibles(): int
{
    return $this->places_disponibles;
}
public function setPlaces_disponibles(int $places_disponibles): self
{
    $this->places_disponibles = $places_disponibles;
    return $this;
}
public function getDescription(): string
{
    return $this->description;
}
public function setDescription(string $description): self
{
    $this->description = $description;
    return $this;
}
public function getDatetime_debut(): string
{
    return $this->datetime_debut;
}
public function setDatetime_debut(string $datetime_debut): self
{
    $this->datetime_debut = $datetime_debut;
    return $this;
}
public function getDuree(): string
{
    return $this->duree;
}
public function setDuree(string $duree): self
{
    $this->duree = $duree;
    return $this;
}
}