<?php

/**
 * interface SerieRender
 * permet le rendu d'une série
 */
interface SerieRender {

    /** fonction render qui permet le rendu d'une série
     * @param Serie $serie la série à retourner
     * @return void
     */
    public function render(Serie $serie) : void;

}
