<?php

/*
 * Traits-good-evil
 */

namespace Trismegiste\Magic;

/**
 * Serializable is a contract for serialization
 */
interface Serializable
{

    public function serialize();

    public function unserialize(array $data);
}