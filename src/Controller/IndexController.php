<?php

namespace Example\Controller;

use Example\Core\Controller\AbstractRestController;

class IndexController extends AbstractRestController
{

    public function getList()
    {
        return ['ok'];
    }

    public function get()
    {
        return ['variable' => 'test'];
    }
}
