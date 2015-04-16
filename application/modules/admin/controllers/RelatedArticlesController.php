<?php

/**
 * Description of RelatedArticlesController
 *
 * @author rnest
 */
class RelatedArticlesController extends CloutWork_Admin_Controller_Action
{

    protected $articleId = null;

    public function indexAction()
    {
        $datatable = new CloutWork_Admin_DataTable_ArticlesRelated();
        $this->view->datatable = $datatable;
    }

    public function addAction()
    {
        $this->forward('edit');
    }
    
    public function sortAction()
    {
        $params = $this->getRequest()->getParams();
        
        return $this->getHelper('redirector')
                        ->gotoRoute(array(
                            'page' => $params['page'],
                            'category-sort' => $params['category-sort'],
                            'name-sort' => $params['name-sort'],
                                ), 'related');
    }

    public function editAction()
    {

        $form = new CloutWork_Admin_Form_ArticlesRelated();
        $model = new CloutWork_Admin_Model_ArticlesRelated();

        $params = $this->getRequest()->getParams();
        $page = $this->_getParam('page', 1);
        $category = $this->_getParam('category-sort', 0);
        $name = $this->_getParam('name-sort', '');

        $form->getElement('id')->setValue($params['id']);

        $this->view->related = $model->getRelatedByArticleId((int) $this->_getParam('id'));
        $this->view->page = $page;
        $this->view->category = $category;
        $this->view->name = $name;

        if ($this->getRequest()->isPost()) {

            $post = $this->getRequest()->getPost();

            $id = (int) $this->_getParam('id');

            if ($form->isValid($post)) {

                $articleId = $id;
                $relatedId = (int) $post['articles'];

                $data = array(
                    'articles' => $articleId,
                    'related' => $relatedId
                );

                $res = $model->insertData($data);

                if ($res) {
                    $this->info('Wpis dodany.');
                    return $this->getHelper('redirector')->gotoRoute(array('page' => $page, 'category-sort' => $category, 'name-sort' => $name), 'related-edit');
                } else {
                    $this->info('Błąd. Wpis nie został dodany.');
                    return $this->getHelper('redirector')->gotoRoute(array('page' => $page, 'category-sort' => $category, 'name-sort' => $name), 'related-edit');
                }
            }
        }


        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $model = new CloutWork_Admin_Model_ArticlesRelated();
        $params = $this->getRequest()->getParams();
        $page = $this->_getParam('page', 1);
        $category = $this->_getParam('category-sort', 0);
        $name = $this->_getParam('name-sort', '');
        
        $this->view->page = $page;
        $this->view->category = $category;
        $this->view->name = $name;

        $res = $model->deleteData($params['id'], $params['rel']);

        if ($res) {
            $this->info('Wpis został usuniety.');
            //return $this->getHelper('redirector')->gotoRoute(array('id' => $params['id']), 'related-edit');
        } else {
            $this->info('Błąd. Wpis nie został usunięty.');
            //return $this->getHelper('redirector')->gotoRoute(array('id' => $params['id']), 'related-edit');
        }
        return $this->getHelper('redirector')->gotoRoute(array('id' => $params['id'], 'page' => $page, 'category-sort' => $category, 'name-sort' => $name), 'related-edit');
    }

    public function getRelatedAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $value = file_get_contents('php://input');

        $model = new CloutWork_Admin_Model_ArticlesRelated();

        $res = $model->getByFrase($value);

        echo json_encode($res);

        exit;
    }

}
