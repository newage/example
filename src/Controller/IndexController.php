<?php

namespace Example\Controller;

use Example\Core\Controller\AbstractRestController;
use Example\Core\View\JsonView;

class IndexController extends AbstractRestController
{

    public function getList()
    {
        return new JsonView(['variable' => 'ok']);
    }

    public function get()
    {
        return new JsonView(['variable' => 'test']);
    }
}
