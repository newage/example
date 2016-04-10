<?php

namespace Example\Model;

use Example\Storage\StorageInterface;

abstract class AbstractModel
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->setStorage($storage);
    }

    /**
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @param StorageInterface $storage
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
    }
}
