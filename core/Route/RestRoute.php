<?php

namespace Example\Core\Route;

use Example\Core\Request\HttpRequest;

class RestRoute extends HttpRoute
{
    const ACTION_GET_LIST = 'getList';
    const ACTION_GET = 'get';
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    /**
     * Set REST actions to controller
     *
     * @param string $method
     * @param string $requestUri
     * @param string $controller
     * @param bool   $force
     */
    public function add($method, $requestUri, $controller, $force = false)
    {
        $uriWithId = $this->addIdToUri($requestUri);
        
        parent::add(HttpRequest::GET, $requestUri, $this->addActionToController($controller, self::ACTION_GET_LIST));
        parent::add(HttpRequest::GET, $uriWithId, $this->addActionToController($controller, self::ACTION_GET));
        parent::add(HttpRequest::POST, $requestUri, $this->addActionToController($controller, self::ACTION_CREATE));
        parent::add(HttpRequest::PUT, $uriWithId, $this->addActionToController($controller, self::ACTION_UPDATE));
        parent::add(HttpRequest::DELETE, $uriWithId, $this->addActionToController($controller, self::ACTION_DELETE));
    }

    /**
     * Add id to uri
     * @param string $uri
     * @return string
     */
    protected function addIdToUri($uri)
    {
        return str_replace('//', '/', $uri . '/:id');
    }

    /**
     * Add action name to controller name and separate `::`
     *
     * @param string $controllerName
     * @param string $actionName
     *
     * @return string
     */
    protected function addActionToController($controllerName, $actionName)
    {
        if ($pos = strpos($controllerName, ':')) {
            $controllerName = substr($controllerName, 0, $pos);
        }

        return $controllerName . '::' . $actionName;
    }
}
