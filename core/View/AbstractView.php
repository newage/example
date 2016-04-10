<?php

namespace Example\Core\View;

abstract class AbstractView
{
    /**
     * @var array
     */
    protected $variables;

    /**
     * @var string
     */
    protected $viewPath;

    /**
     * AbstractView constructor.
     * @param array $variables
     */
    public function __construct(array $variables = [])
    {
        $this->setVariables($variables);
    }

    /**
     * Get view's variables
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * Set view's variables
     *
     * @param array $variables
     */
    public function setVariables(array $variables)
    {
        $this->variables = $variables;
    }

    /**
     * Set a one view's variable
     *
     * @param string $name
     * @param mixed  $value
     */
    public function setVariable($name, $value)
    {
        $this->variables[$name] = $value;
    }

    /**
     * @return mixed
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }

    /**
     * @param mixed $viewPath
     */
    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
    }

    abstract public function __toString();
}
