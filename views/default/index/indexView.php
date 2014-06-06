<?php

class indexView extends MVCView
{
    public function __construct($viewPath)
    {
        parent::__construct($viewPath);
    }
    
    public function render($viewName, $viewFile, $item = false)
    {
        $viewPath = ROOT . $this->m_viewPath . DS . $viewName;
        $t = new MVCTemplate($viewPath . DS . 'templates');
        
        $t->addExpression('PAGE_TITLE', 'IndexView');
        $t->addExpression('TEST_TEMPLATE', 'Hello from index!');
        
        echo $t->render($viewFile);
    }
}

?>