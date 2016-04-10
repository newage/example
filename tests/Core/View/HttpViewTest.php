<?php

namespace Example\Test\Core\View;

use Example\Core\View\HttpView;

class HttpViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testRenderException()
    {
        $view = new HttpView();
        $view->__toString();
    }

    public function testRenderView()
    {
        $view = new HttpView(['testVariable' => 5]);
        $view->setViewPath('tests/data/test_view.php');
        ob_start();
        $view->__toString();
        $result = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(5, $result);
    }
}
