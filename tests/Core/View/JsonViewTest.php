<?php

namespace Example\Test\Core\View;

use Example\Core\View\JsonView;

class JsonViewTest extends \PHPUnit_Framework_TestCase
{
    public function testSetVariables()
    {
        $variables = ['name' => 'value'];
        $view = new JsonView();
        $view->setVariables($variables);
        $return = $view->getVariables();
        $this->assertEquals($variables, $return);
    }

    public function testSetVariable()
    {
        $view = new JsonView();
        $view->setVariable('name', 'value');
        $return = $view->getVariables();
        $this->assertEquals(['name' => 'value'], $return);
    }

    public function testToString()
    {
        $variables = ['name' => 'value'];
        $view = new JsonView();
        $view->setVariables($variables);
        $return = $view->__toString();
        $this->assertEquals('{"name":"value"}', $return);
    }

    public function testSetViewPath()
    {
        $viewPath = 'view/text.php';
        $view = new JsonView();
        $view->setViewPath($viewPath);
        $result = $view->getViewPath();
        $this->assertEquals($viewPath, $result);
    }
}
