<?php

namespace Example\Test\Core\Route;

use Example\Core\Request\HttpRequest;
use Example\Core\Route\RestRoute;

class RestRouteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $name
     * @return \ReflectionMethod
     */
    protected static function getMethod($name)
    {
        $class = new \ReflectionClass('Example\Core\Route\RestRoute');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public function testSetRestRoute()
    {
        $originControllerName = 'AbstractRestController';

        $route = new RestRoute();
        $route->rest('/', $originControllerName);
        $returnControllerPath = $route->read('/', HttpRequest::GET);
        $this->assertEquals('AbstractRestController::getList', $returnControllerPath);

        $returnControllerPath = $route->read('/:id', HttpRequest::GET);
        $this->assertEquals('AbstractRestController::get', $returnControllerPath);

        $returnControllerPath = $route->read('/', HttpRequest::POST);
        $this->assertEquals('AbstractRestController::create', $returnControllerPath);

        $returnControllerPath = $route->read('/:id', HttpRequest::PUT);
        $this->assertEquals('AbstractRestController::update', $returnControllerPath);

        $returnControllerPath = $route->read('/:id', HttpRequest::DELETE);
        $this->assertEquals('AbstractRestController::delete', $returnControllerPath);
    }

    public function providerForUri()
    {
        return [
            ['', '/:id'],
            ['/', '/:id'],
            ['/user', '/user/:id'],
            ['/user/', '/user/:id'],
        ];
    }
    
    /**
     * @dataProvider providerForUri
     */
    public function testAddIdToUri($uri, $expected)
    {
        $route = new RestRoute();
        $method = self::getMethod('addIdToUri');
        $result = $method->invoke($route, $uri);
        $this->assertEquals($expected, $result);
    }

    public function providerAction()
    {
        return [
            ['AbstractRestController', 'getList', 'AbstractRestController::getList'],
            ['AbstractRestController::index', 'getList', 'AbstractRestController::getList'],
            ['AbstractRestController', 'create', 'AbstractRestController::create'],
            ['AbstractRestController::index', 'create', 'AbstractRestController::create'],
        ];
    }

    /**
     * @dataProvider providerAction
     */
    public function testAddActionToController($controllerName, $actionName, $expected)
    {
        $route = new RestRoute();
        $method = self::getMethod('addActionToController');
        $result = $method->invoke($route, $controllerName, $actionName);
        $this->assertEquals($expected, $result);
    }
}
