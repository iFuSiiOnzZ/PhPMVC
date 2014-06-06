<?php

class MVCBootstrap
{
    private $req = NULL;
    private $cfg = NULL;

    public function __construct(MVCRequest $req, CFGConfig $cfg)
    {
        $this->cfg = $cfg;
        $this->req = $req;
    }
    
    public function run()
    {
        $ctrlName = $this->req->getController() . $this->cfg->getController()->getExtension();
        $viewName = $this->req->getMethod() . $this->cfg->getView()->getExtension();
        
        $ctrlPath = ROOT . $this->cfg->getController()->getPath() . DS . $ctrlName . PHPEX;
        $viewPath = ROOT . $this->cfg->getView()->getPath() . DS. $this->cfg->getView()->getLayout(). DS . $this->req->getController() . DS . $viewName . PHPEX;
        
        if(!is_readable($ctrlPath)) exit($ctrlPath . ' <b>Not readable!</b>');
        if(!is_readable($viewPath)) exit($viewPath . ' <b>Not readable!</b>');
        
        include $ctrlPath; include $viewPath;
        $ctrl = new $ctrlName(new $viewName($this->cfg->getView()->getPath() . DS . $this->cfg->getView()->getLayout()));
        
        if(!is_callable(array($ctrl, $this->req->getMethod()))) exit($this->req->getMethod() . ' <b>Can\'t be called!</b>');
        if(sizeof($this->req->getMethod()) > 0) call_user_func_array(array($ctrl, $this->req->getMethod()), $this->req->getArgs());
        else call_user_func(array($ctrl, $this->req->getMethod()));
        
    }
}

?>