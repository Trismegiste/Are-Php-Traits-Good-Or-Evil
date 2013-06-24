<?php

/*
 * Traits-good-evil
 */

namespace Trismegiste\Magic;

/**
 * SerializableImpl is an implementation for interface Serializable
 */
trait SerializableImpl
{

    public function serialize()
    {
        $dump = get_object_vars($this);
        $dump['-fqcn'] = get_called_class();
        foreach ($dump as $prop => $value) {
            if (is_object($value) && ($value instanceof Serializable)) {
                $dump[$prop] = $value->serialize();
            }
        }

        return $dump;
    }

    public function unserialize(array $dump)
    {
        foreach ($dump as $prop => $value) {
            if ((is_array($value)) && array_key_exists('-fqcn', $value)) {
                
            }
        }
    }

}