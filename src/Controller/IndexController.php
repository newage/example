<?php

namespace Example\Controller;

use Example\Core\Controller\AbstractRestController;
use Example\Core\View\JsonView;
use Example\Model\AbstractModel;
use Example\Model\IndexModel;

class IndexController extends AbstractRestController
{
    /**
     * @var IndexModel
     */
    protected $model;

    public function __construct(AbstractModel $model)
    {
        $this->model = $model;
    }

    /**
     * Get list of entry
     *
     * @return JsonView
     */
    public function getList()
    {
        $variables = $this->getModel()->getList();
        return new JsonView($variables);
    }

    /**
     * Get one entry
     *
     * @param int $id
     * @return JsonView
     */
    public function get($id)
    {
        $variables = $this->getModel()->get((int)$id);
        return new JsonView($variables);
    }

    /**
     * Create entry
     *
     * @param array $data
     * @return JsonView
     */
    public function create(array $data)
    {
        $lastInsertId = $this->getModel()->create($data);
        return new JsonView(['lastInsertId' => $lastInsertId]);
    }

    /**
     * Update entry
     *
     * @param int   $id
     * @param array $data
     * @return JsonView
     */
    public function update($id, array $data)
    {
        $result = $this->getModel()->update((int)$id, $data);
        return new JsonView(['result' => $result]);
    }

    /**
     * Delete entry
     *
     * @param int $id
     * @return JsonView
     */
    public function delete($id)
    {
        $result = $this->getModel()->delete((int)$id);
        return new JsonView(['result' => $result]);
    }

    /**
     * Get model for this controller
     * @return IndexModel
     */
    protected function getModel()
    {
        return $this->model;
    }
}
