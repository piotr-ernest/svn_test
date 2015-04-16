<?php

class RssController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $feed = Zend_Feed::import('http://interia.pl.feedsportal.com/c/34004/f/625097/index.rss');
        
        $feedArray = Zend_Feed::findFeeds('http://interia.pl.feedsportal.com/c/34004/f/625097/index.rss');
        
        $channel = new Zend_Feed_Rss('http://interia.pl.feedsportal.com/c/34004/f/625097/index.rss');
        
        $this->view->feed = $feed;
        $this->view->feedArray = $feedArray;
        $this->view->channel = $channel;
    }


}

