<?php

namespace Example\Test\Core\Route;

use Example\Core\Request\HttpRequest;
use Example\Core\Route\HttpRoute;

class HttpRouteTest extends \PHPUnit_Framework_TestCase
{
    public function testAddRoute()
    {
        $originControllerName = 'Controller::action';
        $originalMethod = HttpRequest::GET;
        $requestUri = '/';

        $route = new HttpRoute();
        $route->add($originalMethod, $requestUri, $originControllerName);
        $returnControllerName = $route->read($requestUri, $originalMethod);
        $this->assertEquals($originControllerName, $returnControllerName);
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

    public function testParseRouteVariables()
    {
        $expected = ['id' => 5];
        $_SERVER['REQUEST_URI'] = '/5';

        $route = new HttpRoute();
        $route->add(HttpRequest::GET, '/:id', 'AbstractRestController');
        $variables = $route->parseRouteVariables('/:id');
        $this->assertEquals($expected, $variables);
    }
}
