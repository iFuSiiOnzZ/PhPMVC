<?php

class MVCTemplate
{
    private $m_Path = NULL;
    private $m_ShortExpr = NULL;
    private $m_BlockExpr = NULL;
    private $m_IfElseExpr = NULL;
    
    public function __construct($tPath)
    {
        $this->m_Path = $tPath;
        $this->m_ShortExpr = array();
        $this->m_BlockExpr = array();
        $this->m_IfElseExpr = array();
    }
    
    public function render($tFile)
    {
        if(!is_readable($this->m_Path . DIRECTORY_SEPARATOR . $tFile)) exit($tFile . ' <b>Can\'t be read!</b>');
        $fContent = file_get_contents($this->m_Path . DIRECTORY_SEPARATOR . $tFile);
        
        $fContent = $this->replaceIfElses($fContent);
        $fContent = $this->replacesIncludes($fContent);
        $fContent = $this->replaceExpressions($fContent);
        
        
        return($fContent);
    }
    
    public function addExpression($key, $value)
    {
        $this->m_ShortExpr = array_merge($this->m_ShortExpr, array($key => $value));
    }
    
    public function addBlockExpression($key, $value)
    {
        $this->m_BlockExpr = array_merge($this->m_BlockExpr, array($key => $value));
    }
    
    public function addIfElseExpression($key, $value)
    {
        $this->m_IfElseExpr = array_merge($this->m_IfElseExpr, array($key => $value));
    }
    
    private function replaceIfElses($fContent)
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
    
    private function replaceExpressions($fContent)
    {
        foreach($this->m_ShortExpr as $key => $val)
        {
            $fContent = preg_replace('#{' . $key . '}#', $val, $fContent);
        }
        
        foreach($this->m_BlockExpr as $key => $val) //foreach($val as $k => $v)
        {
            $lContent = '';
            if(preg_match('#<!-- BEGIN ' . $key . ' -->(.*?)<!-- END ' . $key . ' -->#is', $fContent, $toReplace))
            {
               foreach($val as $kV) $lContent .= str_replace(array_map(function($v){return('{' . $v . '}');}, array_keys($kV)), array_values($kV), $toReplace[1]);
               $fContent = preg_replace('#' . $toReplace[0] . '#is', $lContent, $fContent);
            }
        }
        
        return($fContent);  
    }
}

?>