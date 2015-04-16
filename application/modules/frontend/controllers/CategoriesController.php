<?php


/**
 * Description of CategoriesController
 *
 * @author rnest
 */
class CategoriesController extends CloutWork_Controller_Standard
{

    protected $title = 'Kategoria:';
    protected $category;
    protected $categories;
    protected $categoryName;
    protected $limit = 5;
    protected $page;

    public function init()
    {
        parent::init();

        $categoryid = $this->category = $this->_getParam('category-id', 0);
        $this->page = $this->_getParam('page', 1);

        if (!$categoryid) {
            $this->notFound();
        }

        $categoriesModel = new CloutWork_Model_ArticlesCategories();
        $this->categories = $categoriesModel->getCategories();

        $categoriesIds = $categoriesModel->getCategoriesIds();
        $this->categoryName = $categoriesIds[$categoryid];

        if (!array_key_exists($categoryid, $categoriesIds)) {
            $this->notFound();
        }

        $this->view->category = $categoryid;
        $this->view->headTitle($this->categoryName);
        $this->view->categoryName = $this->categoryName;
    }

    public function indexAction()
    {
        $this->view->bc = 'categories/index/' . $this->categoryName;
        $model = new CloutWork_Model_Articles();
        
        $results = $model->getArticlesByCategory($this->category, $this->limit, $this->page);
        $this->view->articles = $results['query'];
        $this->view->pagination = $this->pagination((int) $results['total']['count']);
    }

    public function showAction()
    {
        $this->view->bc = 'categories/show/category-id/' . $this->_getParam('category-id');
    }

    protected function pagination($count)
    {

        Zend_View_Helper_PaginationControl::setDefaultViewPartial('app-partials/pagination/categories.phtml');
        $paginator = Zend_Paginator::factory($count);

        $paginator->setItemCountPerPage($this->limit);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->page);

        return $paginator;
    }

}
