<?php

namespace PLG\Renderer;

/**
 * Render latexfile with Twig
 *
 * @author boeserfrosch
 */
class PhpRenderer extends Renderer { 
    private $vars;
    private $rendered;
    
    public function __construct() {
        
    }

    public function render($template, $data): String {
        $this->vars = $this->copyAndClearArray($data);
        
        unset($data);
        extract($this->vars);
        
 
        try {
            ob_start();
            $includeReturn = include $template;
            $this->rendered = ob_get_clean();
        } catch (\Exception $ex) {
            ob_end_clean();
            throw $ex;
        }
        
        if ($includeReturn === false && empty($this->rendered)) {
            throw new \Exception(sprintf(
                'Unable to render template "%s";',
                __METHOD__,
                $template
            ));
        }
        
        return $this->rendered;
    }

    public function checkUsability($template,$data) {
        $pathinfo = pathinfo($template);
        return strcasecmp($pathinfo['extension'], $this->getType()) == 0;
    }

    public function getType() {
        return 'php';
    }

    private function copyAndClearArray($array) {
        $tmpData = new ArrayObject($array);
        $this->vars = $tmpData->getArrayCopy();
        unset($tmpData);
        
        if (array_key_exists('this', $this->vars)) {
            unset($this->vars['this']);
        }        
    }
}
