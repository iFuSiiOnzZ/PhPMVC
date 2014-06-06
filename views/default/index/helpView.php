<?php

class helpView extends MVCView
{
    public function __construct($viewPath)
    {
        parent::__construct($viewPath);
    }
    
    public function render($viewName, $viewFile, $item = false)
    {
        $viewPath = ROOT . $this->m_viewPath . DS . $viewName;
        $t = new MVCTemplate($viewPath . DS . 'templates');
        
        $t->addExpression('PAGE_TITLE', 'HelpView');
        $t->addExpression('TEST_TEMPLATE', 'Hello form help!');
        
        echo $t->render($viewFile);
    }
}

?>