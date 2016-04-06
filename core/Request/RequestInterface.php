<?php

namespace Example\Core\Request;

interface RequestInterface
{
    /**
     * Get current request method from environment
     * @return string
     */
    public function getCurrentMethod();

    /**
     * Get request uri from environment
     * @return mixed
     */
    public function getCurrentUri();

    /**
     * Get variables from environment
     * @return mixed
     */
    public function getVariables();
}
