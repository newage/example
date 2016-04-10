<?php

namespace Example\Test\src\Model;

use Example\Model\IndexModel;
use Example\Storage\CsvFileStorage;

class IndexModelTest extends \PHPUnit_Framework_TestCase
{
    public function testSetStorage()
    {
        $storage = new CsvFileStorage();
        $model = new IndexModel($storage);
        $model->setStorage($storage);
        $return = $model->getStorage();
        $this->assertEquals($storage, $return);
    }
}
