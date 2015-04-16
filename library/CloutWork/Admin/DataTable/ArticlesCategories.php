<?php

/**
 * Description of ArticlesCategories
 *
 * @author rnest
 */
class CloutWork_Admin_DataTable_ArticlesCategories
{

    protected $view;
    protected $frontController;
    protected $data;
    protected $limit;
    protected $page;
    protected $params = array();

    public function __construct()
    {
        $this->limit = 5;
        
        $this->view = Zend_Layout::getMvcInstance()->getView();
        $this->frontController = Zend_Controller_Front::getInstance();
        $this->page = $this->frontController->getRequest()->getParam('page', 1);
        $this->data = $this->getData();
        
        $this->params['data'] = $this->data['query'];
        
        $params = array(
            'limit' => $this->limit,
            'count' => $this->data['count']['count'],
            'partial' => 'app-partials/pagination/categories_datatable.phtml',
            'page' => Zend_View_Helper_PaginationControl::setDefaultViewPartial('page', 1)
        );
        
        //$this->params['paginator'] = CloutWork_Admin_Paginator::getPaginator($params);
        
        $this->params['paginator'] = $this->pagination((int) $this->data['count']['count']);
    }

    protected function getData()
    {
        $model = new CloutWork_Admin_Model_ArticlesCategories();
        return $model->getDataForDataTable($this->limit, $this->page);
    }

    protected function pagination($count)
    {
        
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('app-partials/pagination/categories_datatable.phtml');
        $paginator = Zend_Paginator::factory($count);
                
        $paginator->setItemCountPerPage($this->limit);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->page);
        
        return $paginator;
    }

    public function __toString()
    {
        return $this->view->partial('app-partials/datatable/categories_datatable.phtml', null, array('params' => $this->params));
    }

}
