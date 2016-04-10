<?php

namespace Example\Storage;

class AbstractStorage
{
    /**
     * @var array
     */
    protected $options;

    public function __construct(array $options)
    {
        $this->setOptions($options);
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set options
     *
     * @param mixed $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Get one option from options array
     *
     * @param string $name
     * @return mixed|null
     */
    public function getOption($name)
    {
        if (!isset($this->options[$name])) {
            throw new \RuntimeException('Option do not setup: ' . $name);
        }
        return $this->options[$name];
    }
}
