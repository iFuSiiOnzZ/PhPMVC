<?php

abstract class MVCView
{
    protected $m_viewPath = NULL;
    
    public function __construct($viewPath)
    {
        $this->m_viewPath = $viewPath; 
    }
    
    abstract public function render($viewName, $viewFile, $item = false);
}

?>