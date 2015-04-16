<?php

/**
 * Description of CategoriesController
 *
 * @author rnest
 */
class CategoriesController extends CloutWork_Admin_Controller_Action
{

    public function indexAction()
    {
        $datatable = new CloutWork_Admin_DataTable_ArticlesCategories();
        $categories = new CloutWork_Admin_Model_ArticlesCategories();
        $this->view->categories = $categories->getCategories();
        $this->view->datatable = $datatable;
    }

    public function addAction()
    {
        $this->forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');

        $categoriesModel = new CloutWork_Admin_Model_ArticlesCategories();
        $form = new CloutWork_Admin_Form_ArticlesCategories();

        if ($id) {
            
            $category = $categoriesModel->getCategoryNameById($id);
            $form = new CloutWork_Admin_Form_ArticlesCategories();
            $form->setDefaults($category);
        } else {
            $this->view->form = $form;
        }

        if ($this->getRequest()->isPost()) {

            $params = $this->getRequest()->getParams();

            $id = isset($params['id']) ? $params['id'] : null;

            if ($form->isValid($params)) {

                if (!$id) {
                    $result = $categoriesModel->insertData($this->processData($params));
                } else {
                    $result = $categoriesModel->updateData($this->processData($params), $id);
                    if ($result) {
                        $this->info('Kategoria została zmodyfikowana.');
                        $this->_helper->redirector('index', 'categories', 'default');
                    } else {
                        $this->info('Błąd. Artykuł nie został zmodyfikowany.');
                        $this->_helper->redirector('index', 'categories', 'default');
                    }
                }

                if ($result) {
                    $this->info('Kategoria została dodana.');
                    $this->_helper->redirector('index', 'categories', 'default');
                } else {
                    $this->info('Błąd. Kategoria nie została dodana.');
                    $this->_helper->redirector('index', 'categories', 'default');
                }
            } else {
                $this->view->errors = $form->getMessages();
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {

        $id = $this->getRequest()->getParam('id');
        $toDelete = array($id);

        if ($this->getRequest()->isPost()) {
            $params = $this->getRequest()->getParams();
            $toDelete = $params['toDelete'];
        }

        if (empty($toDelete)) {
            $this->info('Wybierz kategorię.');
            $this->_helper->redirector('index', 'categories', 'default');
        }

        $model = new CloutWork_Admin_Model_ArticlesCategories();
        $result = $model->deleteData($toDelete);

        if ($result > 1) {
            $this->info('Kategorie zostały usuniete.');
            $this->_helper->redirector('index', 'categories', 'default');
        } else if ($result == 1) {
            $this->info('Kategoria została usunięta.');
            $this->_helper->redirector('index', 'categories', 'default');
        } else {
            $this->info('Błąd. kategoria nie została usunięta.');
            $this->_helper->redirector('index', 'categories', 'default');
        }
    }

    protected function processData(Array $params)
    {
        $data = array();
        
        $data['name'] = $params['name'];
        $data['status'] = $params['status'];
        $data['date_created'] = time();
        
        return $data;
    }

}
