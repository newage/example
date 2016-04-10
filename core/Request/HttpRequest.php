<?php

namespace Example\Core\Request;

class HttpRequest implements RequestInterface
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    /**
     * Get current request method from $_SERVER variable
     * @return string
     */
    public function getCurrentMethod()
    {
        if (!isset($_SERVER['REQUEST_METHOD'])) {
            throw new \RuntimeException('Don\'t set SERVER variable "REQUEST_METHOD"');
        }
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get request uri from $_SERVER variable
     * @return mixed
     */
    public function getCurrentUri()
    {
        if (!isset($_SERVER['REQUEST_URI'])) {
            throw new \RuntimeException('Don\'t set SERVER variable "REQUEST_URI"');
        }
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Get variables from HTTP
     * @return array
     */
    public function getVariables()
    {
        $variables = [];
        switch ($this->getCurrentMethod()) {
            case self::GET:
                $variables = $_GET;
                break;
            case self::POST:
                if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
                    $content = file_get_contents('php://input');
                    $variables = (array)json_decode($content);
                } else {
                    $variables = $_POST;
                }
                break;
            case self::DELETE:
            case self::PUT:
                $content = file_get_contents('php://input');
                if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
                    $variables = (array)json_decode($content);
                } else {
                    parse_str($content, $variables);
                }
                break;
        }

        return $variables;
    }
}
