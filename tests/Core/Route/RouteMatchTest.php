<?php

namespace Example\Test\Core\Route;

use Example\Core\Route\RouteMatch;

class RouteMatchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RouteMatch
     */
    protected $routeMatch;

    public function setUp()
    {
        $this->routeMatch = new RouteMatch();
    }

    public function testSetController()
    {
        $controllerName = 'IndexController';
        $this->routeMatch->setController($controllerName);
        $returnControllerName = $this->routeMatch->getController();
        $this->assertEquals($controllerName, $returnControllerName);
    }

    public function testSetActionName()
    {
        $actionName = 'index';
        $this->routeMatch->setAction($actionName);
        $returnActionName = $this->routeMatch->getAction();
        $this->assertEquals($actionName, $returnActionName);
    }
}
