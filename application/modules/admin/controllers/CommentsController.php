<?php

/**
 * Description of CommentsController
 *
 * @author rnest
 */
class CommentsController extends CloutWork_Admin_Controller_Action
{

    public function indexAction()
    {
        $partials = array(
            'partial' => 'app-partials/datatable/comments.phtml',
            'pagination' => 'app-partials/pagination/comments_datatable.phtml'
        );
        
        $datatable = new CloutWork_Admin_DataTable_Standard(new CloutWork_Admin_Model_Datatable_Comments(), $partials);

        $this->view->datatable = $datatable;
    }

    public function sortAction()
    {
        $params = $this->getRequest()->getParams();
        
        return $this->getHelper('redirector')
                        ->gotoRoute(array(
                            'page' => $params['page'],
                            'author' => $params['author'],
                            'title' => $params['title'],
                            'date' => $params['date']
                                ), 'comments');
    }

}
