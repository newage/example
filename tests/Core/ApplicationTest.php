<?php

namespace Example\Test\Core;

use Example\Core\Application;
use Example\Core\Controller\AbstractRestController;
use Example\Core\Request\HttpRequest;
use Example\Core\Route\HttpRoute;
use Example\Core\Route\RestRoute;
use Example\Core\Route\RouteMatch;

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

    public function testCallController()
    {
        $routeMatch = new RouteMatch();
        $routeMatch->setController('Example\Core\Controller\AbstractRestController');
        $routeMatch->setAction('getList');
        $applicationMock = $this->getMockBuilder('Example\Core\Application')
            ->setMethods(['setParametersToAction', 'getRequest'])
            ->getMock();
        $applicationMock->method('setParametersToAction')
            ->will($this->returnValue(true));
        $applicationMock->method('getRequest')
            ->will($this->returnValue(new HttpRequest()));

        $method = self::getMethod('callController');
        $result = $method->invoke($applicationMock, $routeMatch);
        $this->assertTrue($result);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testIncorrectCallController()
    {
        $routeMatch = new RouteMatch();
        $routeMatch->setController('Example\Test\Core\ApplicationTest');
        $routeMatch->setAction('get');
        $applicationMock = $this->getMockBuilder('Example\Core\Application')
            ->setMethods(['setParametersToAction'])
            ->getMock();
        $applicationMock->method('setParametersToAction')
            ->will($this->returnValue(true));

        $method = self::getMethod('callController');
        $method->invoke($applicationMock, $routeMatch);
    }

    public function testRenderView()
    {
        $method = self::getMethod('renderView');
        ob_start();
        $method->invoke($this->application, 'tests/data/test_view.php', ['testVariable' => 5]);
        $result = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(5, $result);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testRenderException()
    {
        $method = self::getMethod('renderView');
        $method->invoke($this->application, 'test', ['testVariable' => 5]);
    }

    public function testCreateViewPath()
    {
        $method = self::getMethod('createViewPath');
        $result = $method->invoke($this->application, 'IndexController', 'index');
        $this->assertEquals('src/view/index_index.php', $result);
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testSetParametersForDelete()
    {
        $routeMock = $this->getMockBuilder('Example\Core\Route\HttpRoute')
            ->setMethods(['getRouteId'])
            ->getMock();
        $routeMock->method('getRouteId')
            ->will($this->returnValue(1));
        $this->application->setRoute($routeMock);
        $controller = new AbstractRestController();

        $method = self::getMethod('setParametersToAction');
        $method->invoke($this->application, $controller, RestRoute::ACTION_DELETE);
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testSetParametersForCreate()
    {
        $routeMock = $this->getMockBuilder('Example\Core\Route\HttpRoute')
            ->setMethods(['getRouteId'])
            ->getMock();
        $routeMock->method('getRouteId')
            ->will($this->returnValue(1));
        $this->application->setRoute($routeMock);
        $controller = new AbstractRestController();

        $method = self::getMethod('setParametersToAction');
        $method->invoke($this->application, $controller, RestRoute::ACTION_CREATE);
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testSetParametersForUpdate()
    {
        $routeMock = $this->getMockBuilder('Example\Core\Route\HttpRoute')
            ->setMethods(['getRouteId'])
            ->getMock();
        $routeMock->method('getRouteId')
            ->will($this->returnValue(1));
        $requestMock = $this->getMockBuilder('Example\Core\Request\HttpRequest')
            ->setMethods(['getVariables'])
            ->getMock();
        $requestMock->method('getVariables')
            ->will($this->returnValue([]));
        $this->application->setRoute($routeMock);
        $this->application->setRequest($requestMock);
        $controller = new AbstractRestController();

        $method = self::getMethod('setParametersToAction');
        $method->invoke($this->application, $controller, RestRoute::ACTION_UPDATE);
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testSetParameters()
    {
        $controller = new AbstractRestController();
        $method = self::getMethod('setParametersToAction');
        $method->invoke($this->application, $controller, RestRoute::ACTION_GET_LIST);
    }
}
