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
     * @param $requestUri
     * @param $controllerName
     */
    public function rest($requestUri, $controllerName)
    {
        $uriWithId = $this->addIdToUri($requestUri);
        
        $this->add(HttpRequest::GET, $requestUri, $this->addActionToController($controllerName, self::ACTION_GET_LIST));
        $this->add(HttpRequest::GET, $uriWithId, $this->addActionToController($controllerName, self::ACTION_GET));
        $this->add(HttpRequest::POST, $requestUri, $this->addActionToController($controllerName, self::ACTION_CREATE));
        $this->add(HttpRequest::PUT, $uriWithId, $this->addActionToController($controllerName, self::ACTION_UPDATE));
        $this->add(HttpRequest::DELETE, $uriWithId, $this->addActionToController($controllerName, self::ACTION_DELETE));
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
