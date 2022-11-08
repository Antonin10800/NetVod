<?php

namespace netvod\render;

/**
 * interface Render
 * permet de faire un rendu
 */
interface Render {

    /** fonction render qui permet un rendu
     * @return string le rendu
     */
    public function render() : string;

}
