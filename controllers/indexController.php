<?php

class indexController extends MVCController
{
    public function __construct(MVCView $view)
    {
        parent::__construct($view);
    }
    
    public function index()
    {
        $this->m_viewController->render('index', 'index.htm');
    }
    
    public function help()
    {
        $this->m_viewController->render('index', 'index.htm');
    }
}

?>