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
        $storage = new CsvFileStorage(['file' => '']);
        $model = new IndexModel($storage);
        $method = parent::getMethod(IndexController::class, 'getModel');
        $return = $method->invoke(new IndexController($model));
        $this->assertTrue($return instanceof IndexModel);
    }

    /**
     * Functional test
     */
    public function testCreate()
    {
        $file = 'tests/data/test.csv';
        @unlink($file);
        $storage = new CsvFileStorage(['file' => $file]);
        $model = new IndexModel($storage);
        $controller = new IndexController($model);

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
        $storage = new CsvFileStorage(['file' => 'tests/data/test.csv']);
        $model = new IndexModel($storage);
        $controller = new IndexController($model);

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

        $storage = new CsvFileStorage(['file' => 'tests/data/test.csv']);
        $model = new IndexModel($storage);
        $controller = new IndexController($model);

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
        $storage = new CsvFileStorage(['file' => 'tests/data/test.csv']);
        $model = new IndexModel($storage);
        $controller = new IndexController($model);

        $view = $controller->get($id);
        $result = $view->__toString();
        $this->assertEquals($jsonString, $result);
    }

    /**
     * @depends testGet
     */
    public function testDelete()
    {
        $storage = new CsvFileStorage(['file' => 'tests/data/test.csv']);
        $model = new IndexModel($storage);
        $controller = new IndexController($model);

        $view = $controller->delete(1);
        $result = $view->__toString();
        $this->assertEquals('{"result":true}', $result);

        $view = $controller->getList();
        $result = $view->__toString();
        $this->assertEquals('[]', $result);
    }
}
