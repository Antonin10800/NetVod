<?php

namespace netvod\utilitaire;

/**
 * class Avis
 * permet de faire des avis sur les series
 */
class Avis{

    /**
     * @var float $note la note de la serie
     * @var string $commentaire le commentaire de la serie
     * @var int $idSerie l'id de la serie
     */
    private float $note;
    private string $commentaire;
    private string $nomUtilisateur;
    private string $idUser;

    /**
     * constructeur de la classe Avis qui permet d'initialiser les attributs
     * @param float $note la note de la serie
     * @param string $commentaire le commentaire de la serie
     * @param string $nomUtilisateur le nom de l'utilisateur qui a fait l'avis
     */
    public function __construct(float $note, string $commentaire, string $nomUtilisateur, string $idUser){
        $this->note = $note;
        $this->commentaire = $commentaire;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->idUser = $idUser;
    }

    /**
     * getter Magique de la classe Avis
     */
    public function __get($name)
    {
        return $this->$name;
    }

}