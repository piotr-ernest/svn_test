<?php

/**
 * Description of Standard
 *
 * @author rnest
 */
class CloutWork_Admin_DataTable_Standard
{

    protected $view;
    protected $frontController;
    protected $data;
    protected $limit;
    protected $page;
    protected $params = array();
    protected $model = null;
    protected $partial = null;
    protected $partialPagination = null;
    protected $pageRange = null;
    protected $adds = array();
    protected $date = null;
    protected $title = null;
    protected $author = null;

    public function __construct(CloutWork_Admin_Model_Datatable_Standard $model, 
            Array $partials, $adds = null, $limit = 10, $pageRange = 10)
    {
        $this->limit = $limit;
        $this->model = $model;
        $this->partial = $partials['partial'];
        $this->partialPagination = $partials['pagination'];
        $this->pageRange = $pageRange;
        $this->adds = $adds;
        
        $this->view = Zend_Layout::getMvcInstance()->getView();
        $this->frontController = Zend_Controller_Front::getInstance();
        
        $this->page = $this->frontController->getRequest()->getParam('page', 1);
        
        $this->data = $this->getData();
                
        $this->params['data'] = $this->data['query'];    
        $this->params['paginator'] = $this->pagination((int) $this->data['count']['number']);
        $this->params['page'] = $this->page;
        $this->params['author'] = $this->frontController->getRequest()->getParam('author', null);
        $this->params['title'] = $this->frontController->getRequest()->getParam('title', null);
        $this->params['date'] = $this->frontController->getRequest()->getParam('date', null);
        
    }

    protected function getData()
    {
        return $this->model->getDataForDataTable($this->limit, $this->page, $this->adds);
    }

    protected function pagination($count)
    {
        
        Zend_View_Helper_PaginationControl::setDefaultViewPartial($this->partialPagination);
        $paginator = Zend_Paginator::factory((int) $count);
                
        $paginator->setItemCountPerPage((int) $this->limit);
        $paginator->setPageRange((int) $this->pageRange);
        $paginator->setCurrentPageNumber((int) $this->page);
        
        return $paginator;
    }

    public function __toString()
    {
        return $this->view->partial($this->partial, null, array('params' => $this->params));
    }

}
