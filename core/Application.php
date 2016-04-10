<?php

namespace Example\Core;

use Example\Core\Controller\AbstractController;
use Example\Core\Controller\AbstractRestController;
use Example\Core\Request\HttpRequest;
use Example\Core\Request\RequestInterface;
use Example\Core\Route\RestRoute;
use Example\Core\Route\RouteInterface;
use Example\Core\Route\RouteMatch;
use Example\Core\View\AbstractView;

class Application
{
    /**
     * @var RouteInterface
     */
    protected $route = null;

    /**
     * @var RequestInterface
     */
    protected $request = null;

    /**
     * Run application
     */
    public function run()
    {
        $uri = $this->getRequest()->getCurrentUri();
        $method = $this->getRequest()->getCurrentMethod();
        $routeMatch = $this->getRoute()->read($uri, $method);
        $viewModel = $this->callController($routeMatch);
        echo $viewModel;
    }

    /**
     * Add route to Route object
     * @param null|string $method
     * @param string $url
     * @param string $controller
     * @param bool $force
     */
    public function route($method, $url, $controller, $force = false)
    {
        $this->getRoute()->add($method, $url, $controller, $force);
    }

    /**
     * Call controller and action
     * @param $routeMatch
     * @return mixed
     */
    protected function callController(RouteMatch $routeMatch)
    {
        /* @var $controller AbstractRestController */
        $controllerName = $routeMatch->getController();
        $controller = new $controllerName();
        if (!$controller instanceof AbstractController) {
            throw new \RuntimeException('Controller must be extends `AbstractController`');
        }
        
        $controller->setRequest($this->getRequest());
        $result = $this->setParametersToAction($controller, $routeMatch->getAction());

        return $result;
    }

    /**
     * Set variables to the REST actions
     *
     * @param AbstractController|AbstractRestController $controller
     * @param string                                    $actionName
     * @return AbstractView
     */
    protected function setParametersToAction(AbstractController $controller, $actionName)
    {
        switch ($actionName) {
            case RestRoute::ACTION_DELETE:
            case RestRoute::ACTION_GET:
                return $controller->$actionName($this->getRoute()->getRouteId());
                break;
            case RestRoute::ACTION_UPDATE:
                return $controller->$actionName($this->getRoute()->getRouteId(), $this->getRequest()->getVariables());
                break;
            case RestRoute::ACTION_CREATE:
                return $controller->$actionName($this->getRequest()->getVariables());
                break;
            case RestRoute::ACTION_GET_LIST:
            default:
                return $controller->$actionName();
                break;
        }
    }

    /**
     * Get route
     * @return RouteInterface
     */
    public function getRoute()
    {
        if ($this->route === null) {
            $this->route = new RestRoute();
        }
        return $this->route;
    }

    /**
     * Set route
     * @param RouteInterface $route
     * @return $this
     */
    public function setRoute(RouteInterface $route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        if ($this->request === null) {
            $this->request = new HttpRequest();
        }
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     * @return $this
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }
}
