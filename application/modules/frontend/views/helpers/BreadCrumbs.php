<?php

/**
 * Description of BreadCrumbs
 *
 * @author rnest
 */
class Zend_View_Helper_BreadCrumbs extends Zend_View_Helper_Abstract
{

    protected $ico = '<i class="fa fa-circle-o"></i>';

    public function breadCrumbs($path)
    {

        $config = new CloutWork_Config(null, 'modules/breadcrumbs');
        $paths = $config->getPaths()->index->index;
        $home = $this->linkWrapper($paths);

        if ($path != 'index/index') {
            
            $paths = $config->getPaths();
            $exp = explode('/', $path);
            
            $ctrl = $exp[0];
            $act = $exp[1];
            $appendix = '';
            
            if(isset($exp[2])){
                $appendix = $exp[2];
            }
            
            $data = $paths->$ctrl->$act;
            $array = array();
            $array[] = $home;
            $array[] =  $this->linkWrapper($data);
            $array[] =  $appendix;
            
            return $this->listWrapper($array);
            
        } else {
            return $this->listWrapper(array($paths->name));
        }
    }

    protected function linkWrapper(stdClass $data)
    {
        $name = $data->name;
        $url = $data->url;

        return '<a href="' . $url . '">' . $name . '</a>';
    }
    
    protected function listWrapper($data)
    {
        $start = '<ol class="breadcrumb">';
        $end = '</ol>';
        $list = array();
        while($a = each($data)){
            $list[] = '<li>' . $a['value'] . '</li>';
        }
        
        return $start . implode('', $list) . $end;
        
    }

}
