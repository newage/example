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
        $routeMatch = $route->read('/', HttpRequest::GET);
        $this->assertEquals('AbstractRestController', $routeMatch->getController());
        $this->assertEquals('getList', $routeMatch->getAction());

        $routeMatch = $route->read('/1', HttpRequest::GET);
        $this->assertEquals('AbstractRestController', $routeMatch->getController());
        $this->assertEquals('get', $routeMatch->getAction());

        $routeMatch = $route->read('/', HttpRequest::POST);
        $this->assertEquals('AbstractRestController', $routeMatch->getController());
        $this->assertEquals('create', $routeMatch->getAction());

        $routeMatch = $route->read('/1', HttpRequest::PUT);
        $this->assertEquals('AbstractRestController', $routeMatch->getController());
        $this->assertEquals('update', $routeMatch->getAction());

        $routeMatch = $route->read('/1', HttpRequest::DELETE);
        $this->assertEquals('AbstractRestController', $routeMatch->getController());
        $this->assertEquals('delete', $routeMatch->getAction());
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
