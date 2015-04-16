<?php

/**
 * Description of PanelController
 *
 * @author rnest
 */
class PanelController extends CloutWork_Admin_Controller_Action
{

    public function indexAction()
    {
        
    }

    public function logAction()
    {
        $reportPath = REPORTS_PATH . '/admin_log.txt';
        $this->view->log = file_get_contents($reportPath);
    }
    
    public function clearAction()
    {
        file_put_contents(REPORTS_PATH . '/admin_log.txt', '');
        $this->_helper->redirector('log', 'panel', 'default');
    }
    
    public function logFrontendAction()
    {
        $reportPath = REPORTS_PATH . '/frontend_log.txt';
        $this->view->log = file_get_contents($reportPath);
    }
    
    public function clearFrontendAction()
    {
        file_put_contents(REPORTS_PATH . '/frontend_log.txt', '');
        $this->_helper->redirector('log-frontend', 'panel', 'default');
    }

    public function unauthorizedAction()
    {
        
    }

}
