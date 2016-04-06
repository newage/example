<?php

namespace Example\Test\Core;

use Example\Core\Application;
use Example\Core\Request\HttpRequest;
use Example\Core\Route\HttpRoute;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    protected $application;

    public function setUp()
    {
        $this->application = new Application();
    }

    /**
     * @param $name
     * @return \ReflectionMethod
     */
    protected static function getMethod($name)
    {
        $class = new \ReflectionClass('Example\Core\Application');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public function testGetRoute()
    {
        $originalRoute = new HttpRoute();
        $application = new Application();
        $application->setRoute($originalRoute);
        $returnRoute = $application->getRoute();
        $this->assertEquals($originalRoute, $returnRoute);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetRouteException()
    {
        $application = new Application();
        $application->getRoute();
    }

    public function testGetRequest()
    {
        $originalRequest = new HttpRequest();
        $application = new Application();
        $application->setRequest($originalRequest);
        $returnRequest = $application->getRequest();
        $this->assertEquals($originalRequest, $returnRequest);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetRequestException()
    {
        $application = new Application();
        $application->getRequest();
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testCallController()
    {
        $controllerName = 'Example\Core\Controller\AbstractRestController::getList';
        $method = self::getMethod('callController');
        $method->invoke($this->application, $controllerName, []);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testIncorrectCallController()
    {
        $controllerName = 'Example\Core\Controller\AbstractRestController';
        $method = self::getMethod('callController');
        $method->invoke($this->application, $controllerName, []);
    }
    
//    public function testRunApplication()
//    {
//        $route = $this->getMockBuilder('Example\Core\Route\HttpRoute')
//            ->setMethods(['read'])
//            ->getMock();
//        $route->method('read')
//            ->will($this->returnValue('Example\Core\Controller\RestController::create'));
//
//        $request = $this->getMockBuilder('Example\Core\Request\HttpRequest')
//            ->setMethods(['getCurrentUri', 'getCurrentMethod'])
//            ->getMock();
//        $request->method('getCurrentUri')
//            ->will($this->returnValue('/'));
//        $request->method('getCurrentMethod')
//            ->will($this->returnValue('GET'));
//
//        $application = new Application();
//        $application->setRoute($route);
//        $application->setRequest($request);
//        $application->run();
//    }
}
