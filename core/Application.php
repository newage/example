<?php

namespace Example\Core;

use Example\Core\Request\RequestInterface;
use Example\Core\Route\RouteInterface;

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

//    public function run()
//    {
//        $uri = $this->getRequest()->getCurrentUri();
//        $method = $this->getRequest()->getCurrentMethod();
//        $controllerPath = $this->getRoute()->read($uri, $method);
//        $this->callController($controllerPath, $this->getRequest()->getVariables());
//    }

    protected function callController($controllerPath, $variables)
    {
        $parts = explode('::', $controllerPath);
        if (count($parts) != 2) {
            throw new \RuntimeException('Incorrect path to controller::action');
        }

        $controller = new $parts[0];
        return $controller->$parts[1]($variables);
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
