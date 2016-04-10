<?php

namespace Example\Storage;

interface StorageInterface
{
    /**
     * Get an list of entry from storage
     *
     * @return array
     */
    public function get();

    /**
     * Get an one entry from storage
     *
     * @param int $id
     * @return array
     */
    public function getById($id);

    /**
     * Create an one entry into storage
     *
     * @param array $data
     * @return int Last insert id
     */
    public function create(array $data);

    /**
     * Update an one entry into storage
     *
     * @param int  $id
     * @param array $data
     * @return bool Success/Fail
     */
    public function update($id, array $data);

    /**
     * Delete on one entry into storage
     *
     * @param int $id
     * @return bool Success/Fail
     */
    public function delete($id);
}
