<?php

/**
 * Description of ArticleController
 *
 * @author rnest
 */
class ArticlesController extends CloutWork_Admin_Controller_Action
{

    protected $id;

    public function indexAction()
    {
        $datatable = new CloutWork_Admin_DataTable_Articles();
        $this->view->datatable = $datatable;
    }

    public function sortAction()
    {
        $params = $this->getRequest()->getParams();
        return $this->getHelper('redirector')
                        ->gotoRoute(array(
                            'page' => $params['page'],
                            'category-sort' => $params['category-sort'],
                            'name-sort' => $params['name-sort'],
                                ), 'articles');
    }

    public function addAction()
    {
        $this->forward('edit');
    }

    public function editAction()
    {

        $id = $this->getRequest()->getParam('id');
        $page = $this->_getParam('page', 1);

        $articlesModel = new CloutWork_Admin_Model_Articles();
        $form = new CloutWork_Admin_Form_Articles();

        if ($id) {
            $article = $articlesModel->getDataById($id);
            $form = new CloutWork_Admin_Form_Articles();
            $form->setDefaults($article);
        }

        if ($this->getRequest()->isPost()) {

            $params = $this->getRequest()->getParams();
            //desc($params, 1);
            $page = $this->_getParam('page', 1);
            $category = $this->_getParam('category-sort', 0);
            $name = $this->_getParam('name-sort', '');

            $id = isset($params['id']) ? $params['id'] : null;

            if ($form->isValid($params)) {

                try {
                    $process = $this->processThumbnails($params['image-input']);
                } catch (Exception $ex) {
                    
                }

                if (!$process) {
                    $this->info('Błąd tworzenia miniatur.');
                    return $this->getHelper('redirector')->gotoRoute(array('page' => $page, 'category-sort' => $category, 'name-sort' => $name), 'articles');
                }

                if (!$id) {
                    $result = $articlesModel->insertData($this->processData($params));
                } else {
                    $result = $articlesModel->updateData($this->processData($params), $id);
                    if ($result) {
                        $this->info('Artykuł został zmodyfikowany.');
                        return $this->getHelper('redirector')->gotoRoute(array('page' => $page, 'category-sort' => $category, 'name-sort' => $name), 'articles');
                    } else {
                        $this->info('Błąd. Artykuł nie został zmodyfikowany.');
                        return $this->getHelper('redirector')->gotoRoute(array('page' => $page, 'category-sort' => $category, 'name-sort' => $name), 'articles');
                    }
                }

                if ($result) {
                    $this->info('Artykuł został dodany.');
                    return $this->getHelper('redirector')->gotoRoute(array('page' => $page, 'category-sort' => $category, 'name-sort' => $name), 'articles');
                } else {
                    $this->info('Błąd. Artykuł nie został dodany.');
                    return $this->getHelper('redirector')->gotoRoute(array('page' => $page, 'category-sort' => $category, 'name-sort' => $name), 'articles');
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

        $page = $this->_getParam('page', 1);
        $category = $this->_getParam('category-sort', 0);
        $name = $this->_getParam('name-sort', '');

        if ($this->getRequest()->isPost()) {
            $params = $this->getRequest()->getParams();
            $toDelete = $params['toDelete'];
        }

        if (empty($toDelete)) {
            $this->info('Wybierz artykuł.');
            return $this->getHelper('redirector')->gotoRoute(array('page' => $page, 'category-sort' => $category, 'name-sort' => $name), 'articles');
        }

        $model = new CloutWork_Admin_Model_Articles();
        $result = $model->deleteData($toDelete);

        if ($result > 1) {
            $this->info('Artykuły zostały usuniete.');
            return $this->getHelper('redirector')->gotoRoute(array('page' => $page, 'category-sort' => $category, 'name-sort' => $name), 'articles');
        } else if ($result == 1) {
            $this->info('Artykuł został usunięty.');
            return $this->getHelper('redirector')->gotoRoute(array('page' => $page, 'category-sort' => $category, 'name-sort' => $name), 'articles');
        } else if (!$result) {
            $this->info('Błąd. Artykuł nie został usunięty.');
            return $this->getHelper('redirector')->gotoRoute(array('page' => $page, 'category-sort' => $category, 'name-sort' => $name), 'articles');
        }
    }

    protected function processData(Array $params)
    {
        $data = array();

        $data['title'] = $params['title'];
        $data['subtitle'] = $params['subtitle'];
        $data['content'] = $params['content'];
        $data['category'] = $params['category'];
        $data['status'] = $params['status'];
        $data['label'] = $params['label'];

        if (null === $this->id) {
            $data['date_created'] = time();
        } else {
            $data['date_modified'] = time();
        }

        $data['date_published'] = ($data['status'] > 0) ? time() : null;
        $data['author'] = Zend_Auth::getInstance()->getIdentity();

        $data['photo'] = (null == $params['image-input']) ? null : basename($params['image-input']);

        return $data;
    }

    protected function processThumbnails($file)
    {
        $result = $this->createThumb($file, 150, '/public/frontend/files/thumbs-frontend/');
        $result2 = $this->createThumb($file, 800, '/public/frontend/files/articles/');

        if (!$result || !$result2) {
            return false;
        }

        return true;
    }

    protected function createThumb($file, $width, $location)
    {
        $result = true;
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        if ($ext == 'jpg') {
            $result = $this->handleJpg($file, $width, $location);
        }

        if ($ext == 'png') {
            $result = $this->handlePng($file, $width, $location);
        }

        return $result;
    }

    protected function handleJpg($file, $width, $location)
    {
        try {

            $size = getimagesize($file);
            $newWidth = $width;
            $newHeight = ($newWidth * $size[1]) / $size[0];
            $destDir = dirname(APPLICATION_PATH) . $location;
            $source = imagecreatefromjpeg($file);
            $thumb = imagescale($source, $newWidth, $newHeight);
            $result = imagejpeg($thumb, $destDir . basename($file));
            imagedestroy($source);
            return $result;
        } catch (Exception $ex) {
            
        }
    }

    protected function handlePng($file, $width, $location)
    {
        try {

            $size = getimagesize($file);
            $newWidth = $width;
            $newHeight = ($newWidth * $size[1]) / $size[0];
            $destDir = dirname(APPLICATION_PATH) . $location;
            $source = imagecreatefrompng($file);
            $thumb = imagescale($source, $newWidth, $newHeight);
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            $result = imagepng($thumb, $destDir . basename($file));
            imagedestroy($source);
            return $result;
        } catch (Exception $ex) {
            
        }
    }

}
