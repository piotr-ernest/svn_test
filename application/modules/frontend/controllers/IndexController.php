<?php

/**
 * Description of IndexController
 *
 * @author rnest
 */
class IndexController extends CloutWork_Controller_Standard
{

    protected $title = 'Strona Główna';
    protected $limit = 10;
    protected $page;

    public function indexAction()
    {
        $this->page = $this->_getParam('page', 1);
        $model = new CloutWork_Model_Articles();
        $results = $model->getArticlesForMainSite($this->limit, $this->page);
        $this->view->articles = $results['query'];

        $this->view->pagination = $this->pagination((int) $results['total']['count'], $this->limit, $this->page);

        //$this->view->bc .= '/index';
    }

    public function showAction()
    {
        $commentsLimit = 3;
        $this->view->scroll = false;
        
        $articleId = $this->_getParam('id');
        $cPage = (int) $this->_getParam('cpage', 1);
        $scroll = (int) $this->_getParam('scroll', 0);
        
        if($scroll){
            $this->view->scroll = true;
        }
        
        $params = $this->getRequest()->getParams();

        if (!$articleId) {
            $this->notFound();
        }

        $modelArticle = new CloutWork_Model_Articles();
        $modelComments = new CloutWork_Model_Comments();
        $form = new CloutWork_Form_Comments_Input();
        
        $commentsResults = $modelComments->getCommentsById($articleId, $commentsLimit, $cPage);
        $paginationCount = $commentsResults['total']['count'];
        
        //$this->view->comments = $commentsResults['query'];
        $this->view->article = $modelArticle->getArticleById($articleId);
        $this->view->form = $form;
        
        if(!empty($params['e'])){
            $this->view->form_errors = $params['e'];
            $this->view->scroll = true;
        }
        
        if(!empty($params['m'])){
            $this->view->form_messages = $params['m'];
            $this->view->scroll = true;
        }
        
        //$this->view->pagination = $this->pagination((int) $paginationCount, $commentsLimit, $cPage, 'app-partials/pagination/commentsIndex.phtml');
        
    }

    public function unauthorizedAction()
    {
        
    }

    protected function pagination($count, $limit, $page, $partial = 'app-partials/pagination/index.phtml')
    {

        Zend_View_Helper_PaginationControl::setDefaultViewPartial($partial);
        $paginator = Zend_Paginator::factory($count);

        $paginator->setItemCountPerPage($limit);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($page);

        return $paginator;
    }

}
