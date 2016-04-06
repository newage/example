<?php

namespace Example\Core\Route;

interface RouteInterface
{
    /**
     * Add route to map
     *
     * @param string $method
     * @param string $url
     * @param string $controller
     * @param bool   $force
     */
    public function add($method, $url, $controller, $force = false);

    /**
     * Get controller from map of route
     *
     * @param string     $uri
     * @param bool $method
     * @return null|string
     */
    public function read($uri, $method = false);
}
