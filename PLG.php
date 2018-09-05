<?php

use PLG\Helper;
use PLG\Renderer;

namespace PLG;



/**
 * Description of PLG
 *
 * @author boeserfrosch
 */
class PLG {
    private $renderer;
    private $destiny;
    private $renderedFiles;
    private $generatedPDF;
            
    function __construct($destiny = null) {
        if(!is_string($destiny) && !is_null($destiny)) {
            throw new \Exception("destiny has to be a string");
        }
            
        $this->setDestiny($destiny);
        
        $this->renderer = Helper\NamespaceHelper::getInstances(Helper\NamespaceHelper::findNeighborClasses(Renderer\Renderer::class));
        
    }
    
    public function setDestiny($destiny) {
        $this->destiny = $destiny;
    }
    
    public function addRenderer($renderer) {
        $this->renderer[] = Helper\NamespaceHelper::getInstance($renderer);
    }
            


    public function render($filename, $template, $data, $rendererType = 'auto') {
        foreach($this->renderer as $renderer) {
            if(strcasecmp($rendererType,'auto')==0 && $renderer->checkUsability($template, $data)) {
                $this->renderedFiles[] = [
                    'content' => $renderer->render($template,$data),
                    'filename' => $filename
                ];
                return true;
            } elseif(strcasecmp($renderer->getType(),$rendererType)==0) {
                $this->renderedFiles[] = [
                    'content' => $renderer->render($template,$data),
                    'filename' => $filename
                ];
                return true;
            }
        }
        throw new \Exception(sprintf('Could not found needed renderer with renderer type: %s',$rendererType));
    }
    
    public function generate($file) {
        $this->createRenderedFiles();
        
        $filename = $this->destiny.DIRECTORY_SEPARATOR.$file;
        exec("pdflatex ".$filename);
        
        $parts = pathinfo($filename);
        $this->generatedPDF = $this->destiny.DIRECTORY_SEPARATOR.$parts['filename'].'.pdf';
    }
    
    public function download($name = null) {
        if(is_null($this->generatedPDF)) {
            return;
        }
        
        header("Content-type:application/pdf");
        
        if(is_null($name)) {
            $parts = pathinfo($this->generatedPDF);
            $name = $parts['filename'].".pdf";
        }            
        header("Content-Disposition:attachment;filename=".$name."");

        readfile($this->generatedPDF);
    }

        private function createRenderedFiles() {
        foreach($this->renderedFiles as $file) {
            $filename = $this->destiny.DIRECTORY_SEPARATOR.$file['filename'];
            file_put_contents($filename, $file["content"]);
        }
    }
}
