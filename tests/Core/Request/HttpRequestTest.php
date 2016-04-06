<?php

namespace Example\Test\Core\Request;

use Example\Core\Request\HttpRequest;

class HttpRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCurrentRequestUri()
    {
        $expectedRequestUri = '/';
        $_SERVER['REQUEST_URI'] = $expectedRequestUri;
        $route = new HttpRequest();
        $returnRequestUri = $route->getCurrentUri();
        $this->assertEquals($expectedRequestUri, $returnRequestUri);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetRequestUriException()
    {
        $application = new HttpRequest();
        $application->getCurrentUri();
    }

    public function testGetCurrentMethod()
    {
        $originalMethod = HttpRequest::GET;
        $_SERVER['REQUEST_METHOD'] = $originalMethod;

        $route = new HttpRequest();
        $returnMethod = $route->getCurrentMethod();
        $this->assertEquals($originalMethod, $returnMethod);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetRequestMethodException()
    {
        $request = new HttpRequest();
        $request->getCurrentMethod();
    }

    public function testGetVariablesFromGet()
    {
        $_SERVER['REQUEST_METHOD'] = HttpRequest::GET;
        $originalVariables = ['key' => 'value'];
        $_GET = $originalVariables;
        
        $request = new HttpRequest();
        $returnVariables = $request->getVariables();
        $this->assertEquals($originalVariables, $returnVariables);
    }

    public function testGetVariablesFromPost()
    {
        $_SERVER['REQUEST_METHOD'] = HttpRequest::POST;
        $originalVariables = ['key' => 'value'];
        $_POST = $originalVariables;

        $request = new HttpRequest();
        $returnVariables = $request->getVariables();
        $this->assertEquals($originalVariables, $returnVariables);
    }
}
