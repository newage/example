<?php

namespace Example\Core\View;

class HttpView extends AbstractView
{

    /**
     * Example
     * @return string
     */
    public function __toString()
    {
        if (!file_exists($this->getViewPath())) {
            throw new \RuntimeException('A view file not exists. Please create a file: '.$this->getViewPath());
        }

        extract($this->getVariables());
        require $this->getViewPath();
    }
}
