<?php

abstract class MVCController
{
    protected $m_viewController = NULL;
    
    public function __construct(MVCView $view)
    {
        $this->m_viewController = $view;
    }
    
    abstract public function index();
}

?>