<?php

namespace Example\Core;

use Example\Core\Controller\AbstractController;
use Example\Core\Controller\AbstractRestController;
use Example\Core\Request\RequestInterface;
use Example\Core\Route\RestRoute;
use Example\Core\Route\RouteInterface;
use Example\Core\Route\RouteMatch;

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

    public function run()
    {
        $uri = $this->getRequest()->getCurrentUri();
        $method = $this->getRequest()->getCurrentMethod();
        $routeMatch = $this->getRoute()->read($uri, $method);
        $viewVariables = $this->callController($routeMatch);
        $this->renderView(
            $this->createViewPath('IndexController', 'get'),
            $viewVariables
        );
    }

    /**
     * Create path to view file
     * @param $controller
     * @param $action
     * @return mixed
     */
    protected function createViewPath($controller, $action)
    {
        $viewPath = sprintf(
            'src/view/%s_%s.php',
            strtolower(substr($controller, 0, -10)),
            strtolower($action)
        );
        return $viewPath;
    }

    /**
     * Render view
     * @param string $pathToView
     * @param array  $variables
     */
    protected function renderView($pathToView, array $variables)
    {
        if (!file_exists($pathToView)) {
            throw new \RuntimeException('A view file not exists. Please create a file: '.$pathToView);
        }

        extract($variables);
        require $pathToView;
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
        $controller = new $controllerName;
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
     * @param                                           $actionName
     *
     * @return mixed
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
            throw new \RuntimeException('Need setup ROUTE before call ->run()');
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
            throw new \RuntimeException('Need setup REQUEST before call ->run()');
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
