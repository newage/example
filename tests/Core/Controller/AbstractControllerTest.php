<?php

namespace Example\Test\Core\Controller;

use Example\Core\Controller\AbstractController;
use Example\Core\Request\HttpRequest;

class AbstractControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testAddControllerRequest()
    {
        $originalRequest = new HttpRequest();
        $controller = new AbstractController();
        $controller->setRequest($originalRequest);
        $returnRequest = $controller->getRequest();
        $this->assertEquals($originalRequest, $returnRequest);
    }
}
