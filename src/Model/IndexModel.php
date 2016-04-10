<?php

namespace Example\Model;

class IndexModel extends AbstractModel
{
    /**
     * Get list of entry
     *
     * @return array
     */
    public function getList()
    {
        return $this->getStorage()->get();
    }

    /**
     * Get one entry by id
     *
     * @param $id
     * @return array
     */
    public function get($id)
    {
        return $this->getStorage()->getById($id);
    }

    /**
     * Create a one row in storage
     * @param array $data
     * @return int Last insert id
     */
    public function create(array $data)
    {
        return $this->getStorage()->create($data);
    }

    /**
     * Update one entry by id
     *
     * @param int   $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        return $this->getStorage()->update($id, $data);
    }

    /**
     * Delete one entry from storage
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->getStorage()->delete($id);
    }
}
