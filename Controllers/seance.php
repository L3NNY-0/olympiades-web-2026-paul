<?php

class Seance {
    private $id;
    private $horaire;
    private $nb_places;

    public function __construct(int $id, string $horaire, int $nb_places)
    {
        $this->id = $id;
        $this->horaire = $horaire;
        $this->nb_places = $nb_places;
    }
}