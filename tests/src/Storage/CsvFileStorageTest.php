<?php

namespace Example\Test\src\Storage;

use Example\Core\Test\AbstractTest;
use Example\Storage\CsvFileStorage;

class CsvFileStorageTest extends AbstractTest
{
    public function testGetOptions()
    {
        $options = ['file' => 'file'];
        $storage = new CsvFileStorage();
        $storage->setOptions($options);
        $return = $storage->getOptions();
        $this->assertEquals($options, $return);
    }

    public function testGetOption()
    {
        $options = ['file' => 'file'];
        $storage = new CsvFileStorage();
        $storage->setOptions($options);
        $return = $storage->getOption('file');
        $this->assertEquals($options['file'], $return);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetOptionException()
    {
        $storage = new CsvFileStorage();
        $storage->getOption('file');
    }

    public function testGetByIdEmpty()
    {
        $storage = new CsvFileStorage();
        $storage->setOptions(['file' => 'tests/data/test.csv']);
        $result = $storage->getById(100);
        $this->assertEquals([], $result);
    }

    public function testReadFile()
    {
        $originalRows = [
            ['Michal', '055555', 'Michalowskogo str.'],
            ['Piotr', '066666', 'Petrovskogo str.']
        ];
        $options = ['file' => 'tests/data/example.csv'];
        $storage = new CsvFileStorage();
        $storage->setOptions($options);
        $returnRows = $this->readFile($storage);
        $this->assertEquals($originalRows, $returnRows);
    }

    protected function readFile($storage)
    {
        $method = parent::getMethod(CsvFileStorage::class, 'readRows');
        $returnRows = $method->invoke($storage);
        return $returnRows;
    }

    public function testWriteFile()
    {
        $originalRows = [
            ['Michal', '055555', 'Michalowskogo str.'],
            ['Test', '066666', 'Petrovskogo str.']
        ];
        $options = ['file' => 'tests/data/test.csv'];
        $storage = new CsvFileStorage();
        $storage->setOptions($options);
        $method = parent::getMethod(CsvFileStorage::class, 'writeRows');
        $return = $method->invoke($storage, $originalRows);
        $this->assertTrue($return);

        $returnRows = $this->readFile($storage);
        $this->assertEquals($originalRows, $returnRows);
    }
}
