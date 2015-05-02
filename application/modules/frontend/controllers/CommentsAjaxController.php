<?php

/**
 * Description of CommentsAjaxController
 *
 * @author rnest
 */
class CommentsAjaxController extends CloutWork_Controller_Standard
{
    public function init()
    {
        
        parent::init();
    }
    public function indexAction()
    {
        $articleId = $this->getParam('id', null);
        
        if(null === $articleId){
            throw new Exception('Id cannot be null.');
        }
        $this->_helper->layout()->disableLayout();
        $this->view->articleId = $articleId;
    }
    
    public function getCommentsAction()
    {
        $commentsPerPage = 3;
        $this->_helper->layout()->disableLayout();
        $model = new CloutWork_Admin_Model_Comments();
        
        $rowid = file_get_contents('php://input');
        $rowid = json_decode($rowid);
        //file_put_contents('text.txt', $rowid, FILE_APPEND);
        
        $id = null;
        $page = null;
        $comments = null;
        
        if(is_array($rowid)){
            $id = (int) $rowid[0];
            $page = (int) $rowid[1];
            //file_put_contents('text.txt',desc($rowid, 0, 'ajaxRowid', true), FILE_APPEND);
            $comments = $model->getCommentsById($id, $commentsPerPage, $page);
        } else {
            $id = (int) $rowid;
            $comments = $model->getCommentsById($id, $commentsPerPage);
        }
        
        //file_put_contents('text.txt',desc($id, 0, 'ajax', true), FILE_APPEND);
        
        echo json_encode($comments + array('commentsPerPage' => $commentsPerPage, 'page' => ($page === null) ? 1 : $page));
        exit;
    }
}
