<?php

/**
 * Description of Comments
 *
 * @author rnest
 */
class CloutWork_Admin_DataTable_Comments
{

    protected $view;
    protected $frontController;
    protected $data;
    protected $limit;
    protected $page;
    protected $params = array();
    protected $additionals = array();

    public function __construct($limit = 10)
    {
        $this->limit = $limit;
        
        $categoryModel = new CloutWork_Admin_Model_ArticlesCategories();
        $categories = $categoryModel->getCategories();
        
        $this->view = Zend_Layout::getMvcInstance()->getView();
        $this->frontController = Zend_Controller_Front::getInstance();
        $this->page = $this->frontController->getRequest()->getParam('page', 1);
        $this->data = $this->getData();
                
        $this->params['data'] = $this->data['query'];
        
        $params = array(
            'limit' => $this->limit,
            'count' => $this->data['count']['count'],
            'partial' => 'app-partials/pagination/articles_datatable.phtml'
            
        );
        
        //$this->params['paginator'] = CloutWork_Admin_Paginator::getPaginator($params);
        
        $this->params['paginator'] = $this->pagination((int) $this->data['count']['count']);
        $this->params['page'] = $this->page;
        $this->params['categories'] = $categories;
        $this->params['name-sort'] = $this->frontController->getRequest()->getParam('name-sort', null);
        $this->params['category-sort'] = $this->frontController->getRequest()->getParam('category-sort', 0);
    }

    protected function getData()
    {
        $this->additionals['name_sort'] = $this->frontController->getRequest()->getParam('name-sort', 0);
        $this->additionals['category_sort'] = $this->frontController->getRequest()->getParam('category-sort', 0);
        
        $model = new CloutWork_Admin_Model_Articles();
        return $model->getDataForDataTable($this->limit, $this->page, $this->additionals);
    }

    protected function pagination($count)
    {
        
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('app-partials/pagination/articles_datatable.phtml');
        $paginator = Zend_Paginator::factory($count);
                
        $paginator->setItemCountPerPage($this->limit);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->page);
        
        return $paginator;
    }

    public function __toString()
    {
        return $this->view->partial('app-partials/datatable/datatable.phtml', null, array('params' => $this->params));
    }

}
