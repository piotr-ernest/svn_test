<?php

class ErrorController extends Zend_Controller_Action
{
   
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        $this->write($errors->exception);
        $this->notify($errors->exception);
        
        $action = 'soft';

        if (APPLICATION_ENV == 'development') {
            $action = 'error';
        }

        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'Niestety, mamy błąd, którego nie przewidzieliśmy ...';
            return $this->render($action);
        }

        switch ($errors->type) {

            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;

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

                $this->view->message = 'Takiej strony to i tutaj nie ma.';
                $this->view->error404 = true;
                $this->render($action);
                break;

            default:

                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;

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
                                
                $this->view->message = 'Wystąpił błąd aplikacji.</br> '
                        . 'Jeśli to jest problem skontaktuj się z '
                        . '<a href="mailto:rnestk@interia.pl?subject=Błąd aplikacji">administracją.</a>';
                $this->render($action);
                break;
        }
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

    private function write(Exception $exc)
    {
        $path = REPORTS_PATH . '/frontend_log.txt';

        $date = date('Y-m-d H:i:s');
        $file = $exc->getFile();
        $line = $exc->getLine();
        $trace = $exc->getTraceAsString();
        $message = $exc->getMessage();

        file_put_contents($path, print_r('===========================================', true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);

        file_put_contents($path, print_r('DATA: ' . $date, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);

        file_put_contents($path, print_r('PLIK: ' . $file, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);

        file_put_contents($path, print_r('LINIA: ' . $line, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);

        file_put_contents($path, print_r('TRACE: ' . $trace, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);

        file_put_contents($path, print_r('TRESC: ' . $message, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);

        file_put_contents($path, print_r('===========================================', true), FILE_APPEND);
    }
    
    protected function notify($e)
    {
        $mail = new CloutWork_Mail('frontend');
        $mail->setLayoutScript('red');
        $mail->setSenderName('Troskliwy Miś');
        $mail->setSubTitle('Błąd aplikacji ' . date('Y-m-d H:i:s', time()));
        $mail->sendMessage('<h2>Wystąpił błąd:</h2></br>' . $e);
        
    }

}
