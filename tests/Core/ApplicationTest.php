<?php

namespace Example\Test\Core;

use Example\Core\Application;
use Example\Core\Controller\AbstractRestController;
use Example\Core\Request\HttpRequest;
use Example\Core\Route\HttpRoute;
use Example\Core\Route\RestRoute;
use Example\Core\Route\RouteMatch;
use Example\Core\Test\AbstractTest;

class ApplicationTest extends AbstractTest
{
    /**
     * @var Application
     */
    protected $application;

    public function setUp()
    {
        $this->application = new Application();
    }

    public function testGetRoute()
    {
        $originalRoute = new HttpRoute();
        $application = new Application();
        $application->setRoute($originalRoute);
        $returnRoute = $application->getRoute();
        $this->assertEquals($originalRoute, $returnRoute);
    }

    public function testRoute()
    {
        $originalRoute = new RestRoute();
        $originalRoute->add(HttpRequest::GET, '/', 'IndexController');

        $application = new Application();
        $application->route(null, '/', 'IndexController');
        $returnRoute = $application->getRoute();
        $this->assertEquals($originalRoute, $returnRoute);
    }

    public function testGetRequest()
    {
        $originalRequest = new HttpRequest();
        $application = new Application();
        $application->setRequest($originalRequest);
        $returnRequest = $application->getRequest();
        $this->assertEquals($originalRequest, $returnRequest);
    }

    public function testGetEmptyRequest()
    {
        $originalRequest = new HttpRequest();

        $application = new Application();
        $returnRequest = $application->getRequest();
        $this->assertEquals($originalRequest, $returnRequest);
    }


    public function testCallController()
    {
        $routeMatch = new RouteMatch();
        $routeMatch->setController(AbstractRestController::class);
        $routeMatch->setAction('getList');
        $applicationMock = $this->getMockBuilder(Application::class)
            ->setMethods(['setParametersToAction', 'getRequest', 'callDi'])
            ->getMock();
        $applicationMock->method('setParametersToAction')
            ->will($this->returnValue(true));
        $applicationMock->method('getRequest')
            ->will($this->returnValue(new HttpRequest()));
        $applicationMock->method('callDi')
            ->will($this->returnValue(new AbstractRestController()));

        $method = parent::getMethod(Application::class, 'callController');
        $result = $method->invoke($applicationMock, $routeMatch);
        $this->assertTrue($result);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testIncorrectCallController()
    {
        $routeMatch = new RouteMatch();
        $routeMatch->setController(ApplicationTest::class);
        $routeMatch->setAction('get');
        $applicationMock = $this->getMockBuilder(Application::class)
            ->setMethods(['callDi'])
            ->getMock();
        $applicationMock->method('callDi')
            ->will($this->returnValue(new ApplicationTest()));

        $method = parent::getMethod(Application::class, 'callController');
        $method->invoke($applicationMock, $routeMatch);
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testSetParametersForDelete()
    {
        $routeMock = $this->getMockBuilder(HttpRoute::class)
            ->setMethods(['getRouteId'])
            ->getMock();
        $routeMock->method('getRouteId')
            ->will($this->returnValue(1));
        $this->application->setRoute($routeMock);
        $controller = new AbstractRestController();

        $method = parent::getMethod(Application::class, 'setParametersToAction');
        $method->invoke($this->application, $controller, RestRoute::ACTION_DELETE);
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testSetParametersForCreate()
    {
        $requestMock = $this->getMockBuilder(HttpRequest::class)
            ->setMethods(['getCurrentMethod'])
            ->getMock();
        $requestMock->method('getCurrentMethod')
            ->will($this->returnValue(HttpRequest::POST));

        $_SERVER['CONTENT_TYPE'] = 'application/form-data';
        $this->application->setRequest($requestMock);
        $controller = new AbstractRestController();

        $method = parent::getMethod(Application::class, 'setParametersToAction');
        $method->invoke($this->application, $controller, RestRoute::ACTION_CREATE);
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testSetParametersForUpdate()
    {
        $routeMock = $this->getMockBuilder(HttpRoute::class)
            ->setMethods(['getRouteId'])
            ->getMock();
        $routeMock->method('getRouteId')
            ->will($this->returnValue(1));
        $requestMock = $this->getMockBuilder(HttpRequest::class)
            ->setMethods(['getVariables'])
            ->getMock();
        $requestMock->method('getVariables')
            ->will($this->returnValue([]));
        $this->application->setRoute($routeMock);
        $this->application->setRequest($requestMock);
        $controller = new AbstractRestController();

        $method = parent::getMethod(Application::class, 'setParametersToAction');
        $method->invoke($this->application, $controller, RestRoute::ACTION_UPDATE);
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testSetParameters()
    {
        $controller = new AbstractRestController();
        $method = parent::getMethod(Application::class, 'setParametersToAction');
        $method->invoke($this->application, $controller, RestRoute::ACTION_GET_LIST);
    }

    public function testReadConfig()
    {
        $configFile = 'tests/data/config.php';
        $application = new Application();
        $method = parent::getMethod(Application::class, 'readConfig');
        $method->invoke($application, $configFile);

        $getMethod = parent::getProperty(Application::class, 'config');
        $returnConfig = $getMethod->getValue($application);
        $expectedConfig = require $configFile;
        $this->assertEquals($expectedConfig, $returnConfig);
    }

    public function testGetConfigElement()
    {
        $application = new Application();
        $property = parent::getProperty(Application::class, 'config');
        $property->setValue($application, ['di' => 'test']);

        $method = parent::getMethod(Application::class, 'getConfig');
        $returnConfig = $method->invoke($application, 'di');
        $this->assertEquals('test', $returnConfig);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetConfigElementException()
    {
        $application = new Application();
        $method = parent::getMethod(Application::class, 'getConfig');
        $method->invoke($application, 'di');
    }
    
    public function testCallDi()
    {
        
    }
}
