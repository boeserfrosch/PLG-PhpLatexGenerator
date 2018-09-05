<?php

namespace PLG\Helper;

/**
 * Description of NamespaceHelper
 *
 * @author Guido
 */
class NamespaceHelper {
    public static function findNeighborClasses($className, $interface = null) {
        $reflector = new \ReflectionClass($className);
        $ns = $reflector->getNamespaceName();
        $fn = $reflector->getFileName();
        $neighbor = [];
        
        foreach (glob(dirname($fn) . DIRECTORY_SEPARATOR . "*.php") as $file) {
            $class = basename($file, '.php');
            if (is_null($interface) || $class instanceof $interface) {
                $neighbor[] = $ns . "\\" . $class;
            }
        }
        
        return $neighbor;
    }
    
    public static function getInstances(array $classes, ...$params) {
        $instances = [];
        
        foreach($classes as $class)
        {
            $instance = self::getInstance($class, $params);
            if (!is_null($instance)) {
                $instances[] = $instance;
            }
        }
        return $instances;
    }
    
    public static function getInstance(string $class, ...$params) {
        if (strcasecmp(substr($class, 0, 1), '\\') != 0) {
            $class = '\\' . $class;
        } 
        if (class_exists($class, TRUE)) {
            $reflect = new \ReflectionClass($class);
            if (!$reflect->isAbstract()) {
                return new $class($params);
            }
        }
        return null;
    }
}
