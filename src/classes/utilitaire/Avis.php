<?php

namespace netvod\utilitaire;

class Avis{

    private float $note;
    private string $commentaire;
    private string $nomUtilisateur;

    public function __construct(float $note, string $commentaire, string $nomUtilisateur){
        $this->note = $note;
        $this->commentaire = $commentaire;
        $this->nomUtilisateur = $nomUtilisateur;
    }

    /**
     * getter Magique
     */
    public function __get($name)
    {
        return $this->$name;
    }

}