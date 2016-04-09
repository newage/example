<?php

namespace Example\Core\Controller;

use Example\Core\Exception;

/**
 * Class implements REST actions
 */
class AbstractRestController extends AbstractController
{
    /**
     * For http method POST
     *
     * @param array $data
     * @throws Exception\ControllerException
     */
    public function create($data)
    {
        throw new Exception\ControllerException('Method `create` do not implements');
    }

    /**
     * Get one record for method GET
     *
     * @param int $id
     * @throws Exception\ControllerException
     */
    public function get($id)
    {
        throw new Exception\ControllerException('Method `get` do not implements');
    }

    /**
     * Get records for method GET
     *
     * @throws Exception\ControllerException
     */
    public function getList()
    {
        throw new Exception\ControllerException('Method `getList` do not implements');
    }

    /**
     * Update one record for method PUT
     *
     * @param array $data
     * @param int $id
     * @throws Exception\ControllerException
     */
    public function update($data, $id)
    {
        throw new Exception\ControllerException('Method `update` do not implements');
    }

    /**
     * Delete one record
     *
     * @param int $id
     * @throws Exception\ControllerException
     */
    public function delete($id)
    {
        throw new Exception\ControllerException('Method `delete` do not implements');
    }
}
