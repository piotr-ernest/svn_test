<?php

/**
 * Description of ImageProcessor
 *
 * @author rnest
 */
class ImageProcessorController extends Zend_Controller_Action
{

    protected $articleId;

    public function indexAction()
    {
        $upload = true;
        $errors = array();

        $this->_helper->layout->disableLayout();

        $imgName = $this->_getParam('img-name', null);

        if ($e = $this->_getParam('error')) {
            $this->view->errors = $e;
        }

        if ($m = $this->_getParam('message')) {
            $this->view->message = $m;
        }

        //desc($imgName, 1);

        $config = new CloutWork_Config(null, 'frontend');

        $form = new CloutWork_Admin_Form_ImageProcessor();
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            //desc($_FILES, 1);
            $destination = dirname(APPLICATION_PATH) . '/public/frontend/files/articles/';

            $image_name = $_FILES['image_processor']['name'];
            $image_tmp_name = $_FILES['image_processor']['tmp_name'];
            $image_size = $_FILES['image_processor']['size'];

            if ($image_size > (10 * 1024 * 1024)) {
                $errors[] = 'Obrazek ' . $image_name . ' jest za duży - max. 10MB.';
                $upload = false;
            }

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
                
                if ($result) {
                    $this->view->message = 'Obrazek ' . $image_name . ' został dodany pomyślnie do katalogu.';
                } else {
                    $this->view->message = 'Błąd dodawania obrazków.';
                }
            } else {
                $this->view->errors = $errors;
            }
        } else {
            $imgName = $this->_getParam('img-name', null);
        }

        $list = Core_Tools::listDirectory(dirname(APPLICATION_PATH) . '/public/frontend/files/articles');
        $this->view->list = array_reverse($list);
        $this->view->frontendUrl = $config->getFrontend()->url;
        $this->view->form = $form;
        $this->view->photoName = isset($file) ? basename($file) : $imgName;
    }

    public function saveImageAction()
    {
        $name = $this->_getParam('img-name');

        $count = strlen($name);
        if ($count > 255) {
            $e = 'Nazwa obrazka jest za długa';
            return $this->getHelper('redirector')->gotoRoute(array('error' => $e), 'images');
        }

        $m = 'Obrazek został zapisany.';

        return $this->getHelper('redirector')->gotoRoute(array('message' => $m, 'img-name' => $name), 'images');
    }
    
    protected function processThumbnails($file)
    {
        
        $result = $this->createThumb($file, 150, '/public/frontend/files/thumbs-frontend/');
        $result2 = $this->createThumb($file, 600, '/public/frontend/files/articles/');
        
        if(!$result || !$result2){
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
        $size = getimagesize($file);
        $newWidth = $width;
        $newHeight = ($newWidth * $size[1]) / $size[0];
        $destDir = dirname(APPLICATION_PATH) . $location;
        $source = imagecreatefromjpeg($file);
        $thumb = imagescale($source, $newWidth, $newHeight);
        $result = imagejpeg($thumb, $destDir . basename($file));
        imagedestroy($source);
        return $result;
    }

    protected function handlePng($file, $width, $location)
    {
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
    }

}
