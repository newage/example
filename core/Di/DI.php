<?php

namespace Example\Core\Di;

/**
 * A simple Dependency Injection pattern via a constructor
 * @package Example\Core\Di
 */
class DI
{
    /**
     * @var array
     */
    protected $config;

    /**
     * DI constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->setConfig($config);
    }

    /**
     * Create an object and inject a dependency from config
     *
     * @param string|array $className
     * @return null|string
     */
    public function get($className)
    {
        $return = null;
        if (is_string($className) && class_exists($className)) {
            $options = $this->getClass($className);
            $return = new $className($this->get($options['inject'][0]));
        } else {
            $return = $className;
        }
        return $return;
    }

    /**
     * @param string $className
     * @return bool
     */
    protected function isClass($className)
    {
        return isset($this->config[$className]);
    }

    /**
     * The DI config get.
     * Array/One class config get
     *
     * @param string $className
     * @return mixed
     */
    protected function getClass($className)
    {
        if ($this->isClass($className) === true) {
            return $this->config[$className];
        }
        throw new \RuntimeException('Class did not registered in DI config ' . $className);
    }

    /**
     * The DI config set
     * @param array $config
     */
    protected function setConfig(array $config)
    {
        $this->config = $config;
    }
}
