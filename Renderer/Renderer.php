<?php
namespace PLG\Renderer;

/**
 * Description of Renderer
 *
 * @author boeserfrosch
 */
abstract class Renderer {
    /**
     * @return String Reference to the rendered file
     */
    abstract function render($template,$data);
    abstract function checkUsability($template,$data);
    abstract function getType();
   
}
