<?php

class Univers {
    private $id;
    private $nom;
    private $description;

    public function __construct(int $id, string $nom, string $description)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
    }
}