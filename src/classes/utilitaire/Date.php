<?php

namespace netvod\utilitaire;

/**
 * class Date
 * permet de gerer les dates
 */
class Date
{
    /**
     * @var int $jour le jour de la date
     * @var int $mois le mois de la date
     * @var int $annee l'annee de la date
     */
    private int $jour;
    private int $mois;
    private int $annee;

    /**
     * constructeur de la class Date qui prends en paramètre
     * tout les attributs de la class Date et les initialises
     */
    public function __construct(string $date)
    {
        $res = explode("-", $date);
        $this->annee = intval($res[0]);
        $this->mois = intval($res[1]);
        $this->jour = intval($res[2]);
    }

    /**
     * getter Magique de la classe Date
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * methode toString qui permet d'afficher la date
     * @return string la date sous forme de string
     */
    public function toString() : string {
        return $this->jour . "/" . $this->mois . "/" . $this->annee;
    }
}