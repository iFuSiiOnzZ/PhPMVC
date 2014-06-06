<?php

class CFGController
{
    private $m_Path= NULL;
    private $m_Method = NULL;
    private $m_Extension = NULL;
    private $m_Controller = NULL;
    
    public function addController($ctrl)
    {
        $this->m_Controller = $ctrl;
    }
    
    public function getController()
    {
        return($this->m_Controller);
    }
    
    public function addMethod($method)
    {
        $this->m_Method = $method;
    }
    
    public function getMethod()
    {
        return($this->m_Method);
    }
    
    public function addExtension($ext)
    {
        $this->m_Extension = $ext;
    }
    
    public function getExtension()
    {
        return($this->m_Extension);
    }
    
    public function addPath($path)
    {
        $this->m_Path = $path;
    }
    
    public function getPath()
    {
        return($this->m_Path);
    }
}
?>