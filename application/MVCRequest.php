<?php

class MVCRequest
{
    private $m_AppController = NULL;
    private $m_AppMethod = NULL;
    private $m_AppArgs = NULL;
    
    public function __construct($httpURI = NULL, $defaultController, $defaultMethod)
    {
        if($httpURI == NULL)
        {
            $this->defaultConstructor($defaultController, $defaultMethod);
            return;
        }
        
        $uriInfo = array_filter(explode('/', filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL)));
        
        $this->m_AppController = array_shift($uriInfo);
        $this->m_AppMethod = array_shift($uriInfo);
        $this->m_AppArgs = $uriInfo;
        
        $this->m_AppController = ($this->m_AppController != NULL)? strtolower($this->m_AppController) : $defaultController ;
        $this->m_AppMethod = ($this->m_AppMethod != NULL)? strtolower($this->m_AppMethod) : $defaultMethod;
        $this->m_AppArgs = ($this->m_AppArgs != NULL)? array_map('strtolower', $this->m_AppArgs) : array();
    }
    
    private function defaultConstructor($defaultController, $defaultMethod)
    {
        $this->m_AppController = $defaultController;
        $this->m_AppMethod = $defaultMethod;
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