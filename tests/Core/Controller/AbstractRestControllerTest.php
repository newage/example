<?php

namespace Example\Test\Core\Controller;

use Example\Core\Controller\AbstractRestController;

class AbstractRestControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractRestController
     */
    protected $controller;

    public function setUp()
    {
        $this->controller = new AbstractRestController();
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testCreate()
    {
        $this->controller->create(array());
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testGet()
    {
        $this->controller->get(0);
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testGetList()
    {
        $this->controller->getList();
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testUpdate()
    {
        $this->controller->update(array(), 0);
    }

    /**
     * @expectedException \Example\Core\Exception\ControllerException
     */
    public function testDelete()
    {
        $this->controller->delete(0);
    }
}
