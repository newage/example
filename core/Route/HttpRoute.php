<?php

namespace Example\Core\Route;

/**
 * Class for HTTP routing
 */
class HttpRoute implements RouteInterface
{
    protected $routeMap = [];

    protected $routeVariables = [];

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

    /**
     * @param $uri
     * @return array
     */
    public function parseRouteVariables($uri)
    {
        $variables = [];
        $routeParts = explode('/', substr($uri, 1));
        $uriParts = explode('/', substr($_SERVER['REQUEST_URI'], 1));
        for ($i = 0; $i <= count($uriParts); $i++) {
            if (isset($routeParts[$i]) && strstr($routeParts[$i], ':')) {
                $variables[substr($routeParts[$i], 1)] = $uriParts[$i];
            }
        }
        return $variables;
    }
}
