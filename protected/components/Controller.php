<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    private $_pageTitle;
    public $layout = 'column1';
    public $menu = array();
    public $breadcrumbs = array();
    public $pageKeywords = "WE Blog Yii php 编程, php, yii, web";
    public $pageDescription = "WE Blog ,技术博客,记录使用Yii的技术点. PHP,mysql,javascript,css,jquery,ajax,jsonp,redis";

    public function getPageTitle() {
        if ($this->_pageTitle !== null)
            return $this->_pageTitle;
        else {
            return $this->_pageTitle = ' - ' . Yii::app()->name;
        }
    }

    public function setPageTitle($value) {
        $this->_pageTitle = $value;
    }
    
    public function afterRender($view, &$output) {
        parent::afterRender($view, $output);
        $output = str_replace('http://liuxos.duapp.com/attached/image', 'http://bcs.duapp.com/liuxos/attached/image', $output);
        $output = str_replace('http://www.liuxos.com/attached/image', 'http://bcs.duapp.com/liuxos/attached/image', $output);
        return true;
    }

    public function render($view,$data=null,$return=false)
    {
        if($this->beforeRender($view))
        {
            $output=$this->renderPartial($view,$data,true);
            if(($layoutFile=$this->getLayoutFile($this->layout))!==false)
                $output=$this->renderFile($layoutFile,array('content'=>$output),true);

            $this->afterRender($view,$output);

            $output=$this->processOutput($output);

            if(isset($_GET['callback'])){
                $a = json_encode(array('output'=>$output));
                echo $_GET['callback'].'('.$a.');';
            }else{
                if($return)
                    return $output;
                else
                    echo $output;
            }
        }
    } 


}