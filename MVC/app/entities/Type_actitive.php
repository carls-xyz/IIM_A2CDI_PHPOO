<?php 
class TypeActivite
{
    private int $id;
    private string $nom;

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
}
