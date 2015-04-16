<?php

/**
 * Description of UploaderController
 *
 * @author rnest
 */
class UploaderController extends CloutWork_Admin_Controller_Action
{

    public function indexAction()
    {

        $upload = true;
        $errors = array();

        $this->_helper->layout->disableLayout();
        
        $config = new CloutWork_Config(null, 'frontend');
        $form = new CloutWork_Admin_Form_Uploader();

        if ($this->getRequest()->isPost()) {

            //$params = $this->getRequest()->getParams();

            $destination = dirname(APPLICATION_PATH) . '/public/frontend/files/images/';
            //$image = $_FILES;
            $image_name = $_FILES['uploader']['name'];
            $image_tmp_name = $_FILES['uploader']['tmp_name'];
            //$image_type = $_FILES['uploader']['type'];
            $image_size = $_FILES['uploader']['size'];

            if ($image_size > (10 * 1024 * 1024)) {
                $errors[] = 'Obrazek ' . $image_name . ' jest za duży - max. 10MB.';
                $upload = false;
            }
            
            //$allowed = array('jpg', 'png');
            $configAdmin = new CloutWork_Config(null, 'admin');
            $allowed = $configAdmin->getAdmin()->allowed;
            
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);

            if (!in_array($ext, $allowed)) {
                $errors[] = 'Plik ' . $image_name . ' musi być w formacie ' . implode(', ', $allowed) . '.';
                $upload = false;
            }

            $file = $destination . time() . $image_name;

            if (file_exists($file)) {
                $errors[] = 'Obrazek ' . $image_name . ' już jest w katalogu.';
                $upload = false;
            }


            if ($upload) {
                $result = move_uploaded_file($image_tmp_name, $file);
                $this->createThumb($file);
            } else {
                
                $url = $config->getFrontend()->url;
                $this->view->errors = $errors;
                $this->view->list = Core_Tools::listDirectory(dirname(APPLICATION_PATH) . '/public/frontend/files/images');
                $this->view->url = $url;
                $this->view->form = $form;
                return;
            }

            if ($result) {
                $this->view->message = 'Obrazek ' . $image_name . ' został dodany pomyślnie do katalogu.';
            } else {
                $this->view->message = 'Błąd dodawania obrazków.';
            }
        }

        //$config = new CloutWork_Config(null, 'frontend');
        $url = $config->getFrontend()->url;

        $this->view->list = Core_Tools::listDirectory(dirname(APPLICATION_PATH) . '/public/frontend/files/images');
        $this->view->url = $url;
        $this->view->form = $form;
    }
    
    public function deleteAction()
    {
        $success = array();
        $params = $this->getRequest()->getParams();
        if($fileName = $params['delete']){
            $success[] = (int) @unlink(dirname(APPLICATION_PATH) . '/public/frontend/files/images/' . $fileName);
            $success[] = (int) @unlink(dirname(APPLICATION_PATH) . '/public/frontend/files/thumbs/' . $fileName);
        }
        
        if(in_array(0, $success)){
            $this->info('Wystąpił błąd usunięcia pliku ' . $fileName . '.');
            return $this->_helper->redirector('index', 'uploader', 'default');
        } else {
            $this->info('Plik ' . $fileName . ' został usunięty.');
            return $this->_helper->redirector('index', 'uploader', 'default');
        }
        
    }

    protected function modifyFileName($filename)
    {
        return $filename;
    }

    protected function createThumb($file)
    {
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        if ($ext == 'jpg') {
            $this->handleJpg($file);
        }

        if ($ext == 'png') {
            $this->handlePng($file);
        }
    }

    protected function handleJpg($file)
    {
        $size = getimagesize($file);
        $newWidth = 100;
        $newHeight = (100 * $size[1]) / $size[0];
        $destDir = dirname(APPLICATION_PATH) . '/public/frontend/files/thumbs/';
        $source = imagecreatefromjpeg($file);
        $thumb = imagescale($source, $newWidth, $newHeight);
        imagejpeg($thumb, $destDir . basename($file));
        imagedestroy($source);
    }

    protected function handlePng($file)
    {
        $size = getimagesize($file);
        $newWidth = 100;
        $newHeight = (100 * $size[1]) / $size[0];
        $destDir = dirname(APPLICATION_PATH) . '/public/frontend/files/thumbs/';
        $source = imagecreatefrompng($file);
        $thumb = imagescale($source, $newWidth, $newHeight);
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
        imagepng($thumb, $destDir . basename($file));
        imagedestroy($source);
    }

}
