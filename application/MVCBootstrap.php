<?php

class MVCBootstrap
{
    private $m_AppController = NULL;
    private $m_AppMethod = NULL;
    private $m_AppArgs = NULL;
    
    private $m_ctrlPath = NULL;
    private $m_ctrlName = NULL;

    public function __construct(MVCRequest $req, $ctrlPath, $ctrlName)
    {
        $this->m_AppController = $req->getController();
        $this->m_AppMethod = $req->getMethod();
        $this->m_AppArgs = $req->getArgs();
        
        $this->m_ctrlPath = $ctrlPath;
        $this->m_ctrlName = $ctrlName;
    }
    
    public function run()
    {
        $ctrlName = $this->m_AppController . $this->m_ctrlName;
        $ctrlPath = ROOT . $this->m_ctrlPath . DS . $ctrlName . PHPEX;
        
        if(!is_readable($ctrlPath)) exit($ctrlPath . ' <b>Not readable!</b>');
        include $ctrlPath; $ctrl = new $ctrlName;
        
        if(!is_callable(array($ctrl, $this->m_AppMethod))) exit($this->m_AppMethod . ' <b>Can\'t be called!</b>');
        if(sizeof($this->m_AppMethod) > 0) call_user_func_array(array($ctrl, $this->m_AppMethod), $this->m_AppArgs);
        else call_user_func(array($ctrl, $this->m_AppMethod));
        
    }
}

?>