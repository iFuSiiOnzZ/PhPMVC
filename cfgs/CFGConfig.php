<?php

class CFGConfig
{
    private $m_Controller = NULL;
    private $m_View = NULL;
    
    public function __construct()
    {
        
    }
    
    public function addController(CFGController $ctrl)
    {
        $this->m_Controller = $ctrl;
    }
    
    public function getController()
    {
        return($this->m_Controller);
    }
    
    public function addView(CFGView $view)
    {
        $this->m_View = $view;
    }
    
    public function getView()
    {
        return($this->m_View);
    }
}
?>