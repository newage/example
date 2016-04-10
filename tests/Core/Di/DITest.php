<?php

namespace Example\Test\Core\Di;

use Example\Core\Di\DI;
use Example\Core\Test\AbstractTest;

class DITest extends AbstractTest
{
    public function testGetConfig()
    {
        $config = [DI::class => []];
        $diObject = new DI($config);
        $method = parent::getProperty(DI::class, 'config');
        $result = $method->getValue($diObject);
        $this->assertEquals($config, $result);
    }

    public function testGetClass()
    {
        $config = [DI::class => ['inject']];
        $diObject = new DI($config);
        $method = parent::getMethod(DI::class, 'getClass');
        $result = $method->invoke($diObject, DI::class);
        $this->assertEquals(['inject'], $result);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetClassException()
    {
        $config = [];
        $diObject = new DI($config);
        $method = parent::getMethod(DI::class, 'getClass');
        $method->invoke($diObject, DI::class);
    }

    public function testGet()
    {
        $config = [
            DI::class => [
                'inject' => [
                    ['key' => 'value']
                ]
            ]
        ];
        $diObject = new DI($config);
        $method = parent::getMethod(DI::class, 'get');
        $result = $method->invoke($diObject, DI::class);
        $this->assertTrue(get_class($result) == DI::class);
    }
}
