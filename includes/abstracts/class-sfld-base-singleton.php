<?php

namespace SFLD\Includes\Abstracts;

abstract class SFLD_Base_Singleton {

    static protected $_instances = array();

    abstract protected function __construct();

    final public function __clone() {
    }

    final public function __wakeup() {
    }

    static public function getInstance() {

        $class = get_called_class();

        if (! array_key_exists($class, self::$_instances)) {
            self::$_instances[$class] = new $class();
        }

        return self::$_instances[$class];
    }

}