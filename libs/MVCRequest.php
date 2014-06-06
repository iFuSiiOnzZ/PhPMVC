<?php

class MVCRequest
{
    private $m_AppController = NULL;
    private $m_AppMethod = NULL;
    private $m_AppArgs = NULL;
    
    public function __construct($httpURI = NULL, CFGConfig $cfg)
    {
        if($httpURI == NULL)
        {
            $this->defaultConstructor($cfg);
            return;
        }
        
        $uriInfo = array_filter(explode('/', filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL)));
        
        $this->m_AppController = array_shift($uriInfo);
        $this->m_AppMethod = array_shift($uriInfo);
        $this->m_AppArgs = $uriInfo;
        
        $this->m_AppController = ($this->m_AppController != NULL)? strtolower($this->m_AppController) : $cfg->getController()->getController();
        $this->m_AppMethod = ($this->m_AppMethod != NULL)? strtolower($this->m_AppMethod) : $cfg->getController()->getMethod();
        $this->m_AppArgs = ($this->m_AppArgs != NULL)? $this->m_AppArgs : array();
    }
    
    private function defaultConstructor(CFGConfig $cfg)
    {
        $this->m_AppController = $cfg->getController()->getController();
        $this->m_AppMethod = $cfg->getController()->getMethod();
        $this->m_AppArgs = array();
    }
    
    public function getController()
    {
        return($this->m_AppController);
    }
    
    public function getMethod()
    {
        return($this->m_AppMethod);
    }
    
    public function getArgs()
    {
        return($this->m_AppArgs);
    }
}

?>