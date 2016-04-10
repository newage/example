<?php

namespace Example\Core\Test;

class AbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Call protected/private method
     * @param $class
     * @param $name
     * @return \ReflectionMethod
     */
    protected static function getMethod($class, $name)
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
