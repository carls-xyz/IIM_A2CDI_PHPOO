<?php
abstract class Bdd
{
    protected ?PDO $co = null;

    public function __construct()
    {
        $this->connect();
    }

    public function connect(): void
    {
        if ($this->co === null) {
            $this->co = new PDO(
                'mysql:host=127.0.0.1;port=8889;dbname=parc_activite',
                'root',
                'root',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }
    }

    protected function getCo(): PDO
    {
        if ($this->co === null) {
            $this->connect();
        }
        return $this->co;
    }
}