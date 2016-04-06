<?php

namespace Example\Core\Route;

/**
 * Class for HTTP routing
 */
class HttpRoute implements RouteInterface
{
    protected $routeMap = [];

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
     * Get controller from map of route
     *
     * @param string     $uri
     * @param bool $method
     * @return null|string
     */
    public function read($uri, $method = false)
    {
        if (isset($this->routeMap[$uri][$method])) {
            return $this->routeMap[$uri][$method];
        }
        return null;
    }
}
