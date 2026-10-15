<?php

class Attraction {
    private $id;
    private $nom;
    private $description;
    private $statut;
    private $taille_cm;
    private $url_img;

    public function __construct(int $id, string $nom, string $description, int $statut, int $taille_cm, string $url_img)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->statut = $statut;
        $this->taille_cm = $taille_cm;
        $this->url_img = $url_img;
    }
}