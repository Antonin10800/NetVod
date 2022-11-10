<?php

namespace netvod\user;
use netvod\video\episode\Serie;

class Utilisateur 
{
    private int $IDuser;
    private string $email;
    private string $password;
    private string $nom;
    private string $prenom;
    private int $role;
    private string $sexe;
    private array $favoris = array();
    private array $enCours = array();

    /**
     * constructeur de la class Utilisateur qui prends en paramètre 
     * tout les attributs de la class
     */
    public function __construct(int $IDuser, string $email, string $password, string $nom, string $prenom, int $role, string $sexe)
    {
        $this->IDuser = $IDuser;
        $this->email = $email;
        $this->password = $password;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
        $this->sexe = $sexe;
    }

    /**
     * méthode ajouterFavoris
     * @param Serie $serie
     */
    public function ajouterFavoris(Serie $serie)
    {
        // pour ajouter en fin d'un tableau on met crochet vide :-)
        $this->favoris[] = $serie;
    }


    /**
     * méthode supprimerFavoris
     * @param Serie $serie
     */
    public function supprimerFavoris(Serie $serie)
    {
        // on cherche l'index de la série dans le tableau
        $index = array_search($serie, $this->favoris);
        // on supprime l'élément du tableau
        unset($this->favoris[$index]);
    }

    /**
     * @param Serie $serie
     */
    public function ajouterEnCours(Serie $serie)
    {
        // pour ajouter en fin d'un tableau on met crochet vide :-)
        $this->enCours[] = $serie;
    }
    /**
     * @param Serie $serie
     */
    public function supprimerEnCours(Serie $serie)
    {
        // on cherche l'index de la série dans le tableau
        $index = array_search($serie, $this->enCours);
        // on supprime l'élément du tableau
        unset($this->enCours[$index]);
    }

    /**
     * getter Magique
     */
    public function __get($name)
    {
        return $this->$name;
    }

    public function __toString()
    {
        return $this->nom . " " . $this->prenom;
    }
}