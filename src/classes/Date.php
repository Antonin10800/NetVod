<?php


class Date
{
    private int $jour;
    private int $mois;
    private int $annee;

    /**
     * constructeur de la class Date qui prends en paramètre
     * tout les attributs de la class
     */
    public function __construct(string $date)
    {
        $res = explode("-", $date);
        $this->annee = intval($res[0]);
        $this->mois = intval($res[1]);
        $this->jour = intval($res[2]);
    }

    /**
     * getter Magique
     */
    public function __get($name)
    {
        return $this->$name;
    }
}