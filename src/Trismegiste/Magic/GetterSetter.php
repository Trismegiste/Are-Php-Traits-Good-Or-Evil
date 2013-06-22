<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace Trismegiste\Magic;

/**
 * GetterSetter is an implementation of getters/setters
 *
 */
trait GetterSetter
{

    public function __call($methodName, $args)
    {
        if (preg_match('#^(get|set)([A-Z][A-Za-z0-9]*)$#', $methodName, $extract)) {

            $propName = lcfirst($extract[2]);

            if (property_exists(get_called_class(), $propName)) {
                switch ($extract[1]) {
                    case 'set' :
                        $this->$propName = $args[0];
                        break;
                    case 'get' :
                        return $this->$propName;
                        break;
                }
            } else {
                throw new \BadMethodCallException("Property $propName is not defined in " . get_called_class());
            }
        } else {
            throw new \BadMethodCallException("Method $methodName is unknown");
        }
    }

}