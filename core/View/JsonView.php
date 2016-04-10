<?php

namespace Example\Core\View;

class JsonView extends AbstractView
{
    /**
     * Get JSON string
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->getVariables());
    }
}
