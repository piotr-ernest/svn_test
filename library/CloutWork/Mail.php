<?php

/**
 * Description of Mail
 *
 * @author rnest
 */
class CloutWork_Mail
{

    protected $sender;
    protected $recipient;
    protected $smtp;
    protected $config;
    protected $mailTransport;
    protected $subTitle = 'Wiadomość z aplikacji.';
    protected $senderName;
    protected $layoutScript = 'mail.phtml';
    protected $service;

    public function __construct($service = 'frontend')
    {
        $this->service = $service;
        
        try {

            $config = new CloutWork_Config(APPLICATION_PATH . '/configs/modules', 'mail');
            $method = 'getMail';
            $mailConfig = $config->$method();

            $this->smtp = $mailConfig->smtp;
            $this->config = $mailConfig->config;
            $this->recipient = $mailConfig->recipient;
            $this->sender = $mailConfig->config->username;
            $this->senderName = $mailConfig->senderName;

            $this->mailTransport = new Zend_Mail_Transport_Smtp($this->smtp, (array) $this->config);
            Zend_Mail::setDefaultTransport($this->mailTransport);
        } catch (Zend_Exception $e) {
           
            CloutWork_Log::saveError($e, $this->service);
            
        }
    }

    public function setSubTitle($text = 'Wiadomość z aplikacji.')
    {
        $this->subTitle = $text;
    }

    public function getSubtitle()
    {
        return $this->subTitle;
    }

    public function setLayoutScript($name)
    {
        $this->layoutScript = str_replace('.phtml', '', $name) . '.phtml';
    }

    public function getLayoutScript()
    {
        return $this->layoutScript;
    }
    
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }
    
    public function getRecipient()
    {
        return $this->recipient;
    }
    
    public function setSender($sender)
    {
        //$this->sender = $sender;
        return;
    }
    
    public function getSender()
    {
        return $this->sender;
    }
    
    public function setSenderName($name)
    {
        $this->senderName = $name;
    }
    
    public function getSenderName()
    {
        return $this->senderName;
    }

    protected function createContent($content = '')
    {
        $view = new Zend_View();
        $view->setScriptPath(APPLICATION_PATH . '/layouts/scripts/mail/');
        $view->assign('content', $content);
        return $view->render($this->getLayoutScript());
    }

    public function sendMessage($message = '')
    {
        $mail = new Zend_Mail("UTF-8");
        $mail->addTo($this->getRecipient());
        $mail->setSubject($this->getSubtitle());
        $mail->setBodyHtml($this->createContent($message));
        $mail->setFrom($this->getSender(), $this->getSenderName());

        try {
            $mail->send();
        } catch (Exception $e) {
            CloutWork_Log::saveError($e, $this->service);
        }
    }

}
