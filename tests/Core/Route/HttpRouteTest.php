<?php

namespace Example\Test\Core\Route;

use Example\Core\Request\HttpRequest;
use Example\Core\Route\HttpRoute;

class HttpRouteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $name
     * @return \ReflectionMethod
     */
    protected static function getMethod($name)
    {
        $class = new \ReflectionClass(HttpRoute::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public function testAddRoute()
    {
        $originControllerName = 'IndexController::action';
        $originalMethod = HttpRequest::GET;
        $requestUri = '/';

        $route = new HttpRoute();
        $route->add($originalMethod, $requestUri, $originControllerName);
        $routeMatch = $route->read($requestUri, $originalMethod);
        $this->assertEquals('IndexController', $routeMatch->getController());
        $this->assertEquals('action', $routeMatch->getAction());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testAddRouteException()
    {
        $originControllerName = 'Controller::action';
        $originalMethod = HttpRequest::GET;
        $requestUri = '/';

        $route = new HttpRoute();
        $route->add($originalMethod, $requestUri, $originControllerName);
        $route->add($originalMethod, $requestUri, $originControllerName);
    }

    public function testGetRouteNotExists()
    {
        $route = new HttpRoute();
        $returnControllerName = $route->read('/', HttpRequest::GET);
        $this->assertNull($returnControllerName);
    }

    public function testSetRouteId()
    {
        $originalId = 1;
        $route = new HttpRoute();
        $method = self::getMethod('setRouteId');
        $method->invoke($route, $originalId);
        $returnId = $route->getRouteId();
        $this->assertEquals($originalId, $returnId);
    }

    public function testFindUriWithId()
    {
        $realUri = '/5';
        $realMethod = HttpRequest::GET;
        $expectedController = 'AbstractRestController::getList';
        $_SERVER['REQUEST_URI'] = $realUri;

        $route = new HttpRoute();
        $route->add($realMethod, '/:id', $expectedController);
        $routeMatch = $route->read($realUri, $realMethod);
        $this->assertEquals('AbstractRestController', $routeMatch->getController());
        $this->assertEquals('getList', $routeMatch->getAction());

        $returnId = $route->getRouteId();
        $this->assertEquals(5, $returnId);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testMakeMatchException()
    {
        $route = new HttpRoute();
        $method = self::getMethod('makeMatch');
        $method->invoke($route, 'Controller');
    }
}
