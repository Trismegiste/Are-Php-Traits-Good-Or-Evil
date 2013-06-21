<?php

/*
 * Are-Php-Traits-Good-Or-Evil
 */

namespace Tests\Trismegiste\Observer;

/**
 * Here is an example of Implementation of SplSubject with trait
 *
 * If you use the trait, you MUST implement SplSubject, it is essential
 * for type-hinting
 */
class SubjectExample implements \SplSubject
{

    use \Trismegiste\Observer\SplSubjectImpl;
}


