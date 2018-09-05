<?php
namespace PLG\Renderer;

use Twig_Loader_Filesystem;
use Twig\Environment as Twig_Environment;
/**
 * Render latexfile with Twig
 *
 * @author boeserfrosch
 */
class TwigRenderer extends Renderer {
    public function __construct() {
        
    }

    public function render($template, $data): String {
        $loader = new Twig_Loader_Filesystem('.');
        $twig = new Twig_Environment($loader);

        return $twig->render($template, $data);        
    }

    public function checkUsability($template,$data) {
        $pathinfo = pathinfo($template);
        return strcasecmp($pathinfo['extension'], $this->getType()) == 0;
    }

    public function getType() {
        return 'twig';
    }

}
