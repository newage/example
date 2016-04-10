<?php

namespace Example\Test\src\Controller;

use Example\Controller\IndexController;
use Example\Core\Test\AbstractTest;
use Example\Model\IndexModel;
use Example\Storage\CsvFileStorage;

class IndexControllerTest extends AbstractTest
{
    public function testGetModel()
    {
        $method = parent::getMethod(IndexController::class, 'getModel');
        $return = $method->invoke(new IndexController());
        $this->assertTrue($return instanceof IndexModel);
    }

    /**
     * Functional test
     */
    public function testCreate()
    {
        $file = 'tests/data/test.csv';
        unlink($file);
        $storage = new CsvFileStorage();
        $storage->setOptions(['file' => $file]);
        $model = new IndexModel($storage);

        /* @var $controller IndexController|\PHPUnit_Framework_MockObject_MockObject */
        $controller = $this->getMockBuilder(IndexController::class)
            ->setMethods(['getModel'])
            ->getMock();
        $controller->method('getModel')
            ->will($this->returnValue($model));

        $forCreate = ['Lisa', '998885511', 'Unknown str.'];
        $view = $controller->create($forCreate);
        $variables = $view->getVariables();

        $view = $controller->get($variables['lastInsertId']);
        $result = $view->__toString();
        $this->assertEquals(json_encode($forCreate), $result);
    }

    /**
     * Functional test
     * @depends testCreate
     */
    public function testUpdate()
    {
        $storage = new CsvFileStorage();
        $storage->setOptions(['file' => 'tests/data/test.csv']);
        $model = new IndexModel($storage);

        /* @var $controller IndexController|\PHPUnit_Framework_MockObject_MockObject */
        $controller = $this->getMockBuilder(IndexController::class)
            ->setMethods(['getModel'])
            ->getMock();
        $controller->method('getModel')
            ->will($this->returnValue($model));

        $forUpdate = ['Michal', '00000000', 'Kirova str.'];
        $view = $controller->update(1, $forUpdate);
        $result = $view->__toString();
        $this->assertEquals('{"result":true}', $result);

        $view = $controller->get(1);
        $result = $view->__toString();
        $this->assertEquals(json_encode($forUpdate), $result);
    }

    /**
     * Functional test
     * @depends testUpdate
     */
    public function testGetList()
    {
        $jsonString = '[["Michal","00000000","Kirova str."]]';

        $storage = new CsvFileStorage();
        $storage->setOptions(['file' => 'tests/data/test.csv']);
        $model = new IndexModel($storage);

        /* @var $controller IndexController|\PHPUnit_Framework_MockObject_MockObject */
        $controller = $this->getMockBuilder(IndexController::class)
            ->setMethods(['getModel'])
            ->getMock();
        $controller->method('getModel')
            ->will($this->returnValue($model));

        $view = $controller->getList();
        $result = $view->__toString();
        $this->assertEquals($jsonString, $result);
    }

    public function getProvider()
    {
        return [
            ['["Michal","00000000","Kirova str."]', 1]
        ];
    }

    /**
     * Functional test
     * @dataProvider getProvider
     * @depends testGetList
     */
    public function testGet($jsonString, $id)
    {
        $storage = new CsvFileStorage();
        $storage->setOptions(['file' => 'tests/data/test.csv']);
        $model = new IndexModel($storage);

        /* @var $controller IndexController|\PHPUnit_Framework_MockObject_MockObject */
        $controller = $this->getMockBuilder(IndexController::class)
            ->setMethods(['getModel'])
            ->getMock();
        $controller->method('getModel')
            ->will($this->returnValue($model));

        $view = $controller->get($id);
        $result = $view->__toString();
        $this->assertEquals($jsonString, $result);
    }

    /**
     * @depends testGet
     */
    public function testDelete()
    {
        $storage = new CsvFileStorage();
        $storage->setOptions(['file' => 'tests/data/test.csv']);
        $model = new IndexModel($storage);

        /* @var $controller IndexController|\PHPUnit_Framework_MockObject_MockObject */
        $controller = $this->getMockBuilder(IndexController::class)
            ->setMethods(['getModel'])
            ->getMock();
        $controller->method('getModel')
            ->will($this->returnValue($model));

        $view = $controller->delete(1);
        $result = $view->__toString();
        $this->assertEquals('{"result":true}', $result);

        $view = $controller->getList();
        $result = $view->__toString();
        $this->assertEquals('[]', $result);
    }
}
