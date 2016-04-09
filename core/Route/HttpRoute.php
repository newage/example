<?php

namespace Example\Core\Route;

/**
 * Class for HTTP routing
 */
class HttpRoute implements RouteInterface
{
    protected $routeMap = [];

    protected $routeId;

    /**
     * Add route to map
     *
     * @param string $method
     * @param string $url
     * @param string $controller
     * @param bool   $force
     */
    public function add($method, $url, $controller, $force = false)
    {
        if (isset($this->routeMap[$url][$method]) && $force === false) {
            throw new \RuntimeException('Controller for uri is registered');
        }

        $this->routeMap[$url][$method] = $controller;
    }

    /**
     * Get controller from route map
     * @param string     $uri
     * @param bool $method
     * @return null|RouteMatch
     */
    public function read($uri, $method = false)
    {
        $route = $this->matchesRoute($uri);
        if (isset($this->routeMap[$route][$method])) {
            return $this->makeMatch($this->routeMap[$route][$method]);
        }
        return null;
    }

    /**
     * Validate controller and action and make an associate array
     * @param $controllerPath
     * @return RouteMatch
     */
    protected function makeMatch($controllerPath)
    {
        $parts = explode('::', $controllerPath);
        if (count($parts) != 2) {
            throw new \RuntimeException('Incorrect path to controller::action');
        }
        $routeMatch = new RouteMatch();
        $routeMatch->setController($parts[0]);
        $routeMatch->setAction($parts[1]);
        return $routeMatch;
    }

    /**
     * Match a real uri with registered routes
     * @param string $uri
     * @return bool|string
     */
    protected function matchesRoute($uri)
    {
        foreach ($this->routeMap as $route => $options) {
            if ($route == $uri) {
                return $route;
            }
            $pattern = str_replace(':id', '([\d]+)', $route);
            preg_match('~'.$pattern.'~', $uri, $matches);
            if (isset($matches[1])) {
                $this->setRouteId($matches[1]);
                return $route;
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getRouteId()
    {
        return $this->routeId;
    }

    /**
     * @param mixed $routeId
     */
    protected function setRouteId($routeId)
    {
        $this->routeId = $routeId;
    }
}
