<?php

/*
 * Traits-good-evil
 */

namespace Tests\Trismegiste\Magic;

class SerializerTest extends \PHPUnit_Framework_TestCase
{

    protected $service;

    protected function setUp()
    {
        $this->service = new Unserializer();
    }

    public function testDump()
    {
        $dump = serialize(new Example());
        echo $dump;
        print_r($this->service->unserialObject($dump));
    }

}

class Example
{

    protected $bbb = array(222);
    public $ccc = "333";
    protected $ddd;
    private $aaa = 111;
    protected $other;

    public function __construct()
    {
        $this->other = new \ArrayObject();
        $this->ddd = new Embedded();
    }

}

class Embedded
{
    
}

class Unserializer
{

    public function unserialObject($str)
    {
        if (preg_match('#^O:(\d+):"([^"]+)":(\d+):\{(.*)\}$#', $str, $extract)) {
            $result = $this->unserialProp($extract[3], $extract[4]);
            $obj = $result['hash'];
            $obj['-fqcn'] = $extract[2];
        }

        return $obj;
    }

    protected function unserialProp($cpt, $str)
    {
        $property = [];
        for ($k = 0; $k < $cpt; $k++) {

            if ($str[0] == 's') {
                preg_match('#^s:(\d+):"([^"]+)";(.+)#', $str, $extract);
                $nameProp = $extract[2];
                if ($nameProp[0] == chr(0)) {
                    $splitted = explode(chr(0), $nameProp);
                    $nameProp = $splitted[2];
                }
                $ending = $extract[3];
            } else {
                preg_match('#^i:(\d+);(.+)#', $str, $extract);
                $nameProp = $extract[1];
                $ending = $extract[2];
            }

            switch ($ending[0]) {

                case 'a':
                    preg_match('#^a:(\d+):\{(.*)$#', $ending, $extract);
                    $unserialArray = $this->unserialProp($extract[1], $extract[2]);
                    $property[$nameProp] = $unserialArray['hash'];
                    $str = substr($unserialArray['rest'], 1);
                    break;

                case 's':
                    preg_match('#^s:(\d+):"(.*)$#', $ending, $extract);
                    $property[$nameProp] = substr($extract[2], 0, $extract[1]);
                    $str = substr($extract[2], $extract[1] + 2);
                    break;

                case 'i':
                    preg_match('#^i:([^;]+);(.*)$#', $ending, $extract);
                    $property[$nameProp] = (int) $extract[1];
                    $str = $extract[2];
                    break;

                case 'O':
                    preg_match('#^O:(\d+):"([^"]+)":(\d+):\{(.*)$#', $ending, $extract);
                    $unserialArray = $this->unserialProp($extract[3], $extract[4]);
                    $property[$nameProp] = $unserialArray['hash'];
                    $property[$nameProp]['-fqcn'] = $extract[2];
                    $str = substr($unserialArray['rest'], 1);
                    break;
            }
        }

        return ['hash' => $property, 'rest' => $str];
    }

}