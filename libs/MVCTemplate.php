<?php

class MVCTemplate
{
    private $m_Path = NULL;
    private $m_ShortExpr = NULL;
    private $m_IfElseExpr = NULL;
    
    public function __construct($tPath)
    {
        $this->m_Path = $tPath;
        $this->m_ShortExpr = array();
        $this->m_IfElseExpr = array();
    }
    
    public function render($tFile)
    {
        if(!is_readable($this->m_Path . DIRECTORY_SEPARATOR . $tFile)) exit($tFile . ' <b>Can\'t be read!</b>');
        $fContent = file_get_contents($this->m_Path . DIRECTORY_SEPARATOR . $tFile);
        
        $fContent = $this->replaceIfElse($fContent);
        $fContent = $this->replacesIncludes($fContent);
        $fContent = $this->replaceExpression($fContent);
        
        
        return($fContent);
    }
    
    public function addExpression($key, $value)
    {
        $this->m_ShortExpr = array_merge($this->m_ShortExpr, array($key => $value));
    }
    
    public function addIfElseExpression($key, $value)
    {
        $this->m_IfElseExpr = array_merge($this->m_IfElseExpr, array($key => $value));
    }
    
    private function replaceIfElse($fContent)
    {
        while(preg_match('#<!-- IF (.*?) -->(.*?)<!-- ENDIF -->#is', $fContent, $toReplace))
        {
            if(preg_match('#(.*?) (.*?) ([0-9]+)#is', $toReplace[1], $ifElse))
            {
                $ifElse[1] = str_replace($ifElse[1], $this->m_IfElseExpr[$ifElse[1]], $ifElse[1]);
                $evalString = 'return ' . $ifElse[1]. $ifElse[2] . $ifElse[3]. ';';
            }
            else
            {
                $toReplace[1] = str_replace($toReplace[1], $this->m_IfElseExpr[$toReplace[1]], $toReplace[1]);
                $evalString = 'return ' . $toReplace[1]. ';';
            }
            
            $isElse = preg_match('#(.*)<!-- ELSE -->(.*)#is', $toReplace[2], $ifElse);
            
            if(eval($evalString)) $fContent = preg_replace('#' . $toReplace[0] . '#', ($isElse)? $ifElse[1] : $toReplace[2], $fContent);
            else $fContent = preg_replace('#' . $toReplace[0] . '#', ($isElse)? $ifElse[2] : '', $fContent);
        }

        return($fContent);
    }
    
    private function replacesIncludes($fContent)
    {
        while(preg_match('#<!-- INCLUDE (.*?) -->#is', $fContent, $toReplace))
        {
            $includeFile = $this->m_Path . DIRECTORY_SEPARATOR . $toReplace[1];
            if(!is_readable($includeFile)) exit($includeFile . ' <b>Can\'t be read!</b>');
            $fContent = preg_replace('#' . $toReplace[0] . '#', file_get_contents($includeFile), $fContent);
        }
        
        return($fContent);
    }
    
    private function replaceExpression($fContent)
    {
        foreach($this->m_ShortExpr as $key => $val)
        {
            $fContent = preg_replace('#{' . $key . '}#', $val, $fContent);
        }
        
        return($fContent);  
    }
}

?>