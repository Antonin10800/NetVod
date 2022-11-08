<?php

/**
 * interface Render
 * permet le rendu d'un épisode
 */
interface Render {

    /** fonction render qui permet le rendu d'un épisode
     * @param Episode $episode l'épisode à retourner
     * @return string le rendu de l'épisode
     */
    public function render(Episode $episode) : string;

}
