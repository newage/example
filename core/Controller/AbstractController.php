<?php

namespace Example\Core\Controller;

use Example\Core\Request\RequestInterface;
use Example\Core\Route\RouteInterface;

class AbstractController
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }
}
