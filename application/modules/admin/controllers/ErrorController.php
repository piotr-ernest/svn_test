<?php

class ErrorController extends Zend_Controller_Action
{
    
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->view->message = 'Application error';
                break;
        }

        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($this->view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }

        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }

        $this->view->request = $errors->request;
        
        $this->write($errors->exception);
        
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }

    public function notAllowedAction()
    {
        
    }

    private function write(Exception $exc)
    {
        $path = REPORTS_PATH . '/admin_log.txt';
        
        $date = date('Y-m-d H:i:s');
        $file = $exc->getFile();
        $line = $exc->getLine();
        $trace = $exc->getTraceAsString();
        $message = $exc->getMessage();

        file_put_contents($path, print_r('===========================================', true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);
        
        file_put_contents($path, print_r('DATA: '.$date, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);
        
        file_put_contents($path, print_r('PLIK: '.$file, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);
        
        file_put_contents($path, print_r('LINIA: '.$line, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);
        
        file_put_contents($path, print_r('TRACE: '.$trace, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);
        
        file_put_contents($path, print_r('TRESC: '.$message, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);
        
        file_put_contents($path, print_r('===========================================', true), FILE_APPEND);
        
        
    }

}
