<?php

class CFGView
{
    private $m_Path = NULL;
    private $m_Layout = NULL;
    private $m_Extesion = NULL;
    
    public function addExtension($ext)
    {
        $this->m_Extesion = $ext;
    }
    
    public function getExtension()
    {
        return($this->m_Extesion);
    }
    
    public function addPath($path)
    {
        $this->m_Path = $path;
    }
    
    public function getPath()
    {
        return($this->m_Path);
    }
    
    public function addLayout($view)
    {
        $this->m_Layout = $view;
    }
    
    public function getLayout()
    {
        return($this->m_Layout);
    }
}

?>