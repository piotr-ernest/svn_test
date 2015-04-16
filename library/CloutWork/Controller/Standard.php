<?php

/**
 * Description of Standard
 *
 * @author rnest
 */
class CloutWork_Controller_Standard extends Zend_Controller_Action
{

    protected $title = 'CloutWork';
    protected $bc = 'index/index';
    protected $identity;

    public function init()
    {
        
        CloutWork_Cookie::setCountingCookie();
        
        if(Zend_Auth::getInstance()->hasIdentity()){
            $this->identity = $this->view->identity = Zend_Auth::getInstance()->getIdentity();
        }
        $this->view->headTitle($this->title);
        $this->view->bc = $this->bc;
        $this->view->messages = $this->getInfo();
        parent::init();
    }

    public function notFound()
    {
        throw new Zend_Controller_Dispatcher_Exception('Nie znaleziono tej strony...'); 
        return;
    }
    
    protected function info($message = '')
    {
        $fm = $this->_helper->getHelper('FlashMessenger');
        $fm->addMessage($message);
    }

    protected function getInfo()
    {
        $fm = $this->_helper->getHelper('FlashMessenger');
        return $fm->getMessages();
    }
    
    protected function redirectTo($params, $e = false, $m = false, $module = 'default')
    {
        $p = array();
        $p['id'] = $params['id'];
        $p['category-id'] = $params['category-id'];
        $p['page'] = $params['page'];
        $p['e'] = '';
        $p['m'] = '';
        
        if($e){
            
            if(is_array($e)){
                foreach($e as $k => $v){
                    foreach($v as $key => $val){
                        $p['e'] .= $val;
                    }
                }
            } else {
                $p['e'] = $e;
            }
        }
        
        if($m){
            
            if(is_array($m)){
                foreach($m as $k => $v){
                    foreach($v as $key => $val){
                        $p['m'] .= $val;
                    }
                }
            } else {
                $p['m'] = $m;
            }
        }
        
        return $this->_helper->redirector($params['a'], $params['c'], $module, $p);
    }

}
