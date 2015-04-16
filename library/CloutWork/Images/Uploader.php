<?php

/**
 * Description of Uploader
 *
 * @author rnest
 */
class CloutWork_Images_Uploader
{

    protected static $instance = false;
    protected static $sizeLimit = null;
    protected static $controller = false;
    protected static $action = false;
    protected static $dir = false;
    protected static $view = false;
    protected static $allowedExt = false;

    public static function getInstance(Array $opts)
    {
        if (!self::$instance) {
            self::$instance = new CloutWork_Images_Uploader($opts);
        }
        return self::$instance;
    }

    private function __construct(Array $opts)
    {
        extract($opts);
        
        self::$allowedExt = $exts;
        
        CloutWork_Images_Uploader::setSizeLimit($sizeLimit);
        CloutWork_Images_Uploader::createFormActionUrl($controller, $action);
        CloutWork_Images_Uploader::setTargetDirectory($dir);
        CloutWork_Images_Uploader::setView($view);
        CloutWork_Images_Uploader::start($request, $view);

        $view->fileUploadForm = CloutWork_Images_Uploader::generateUploadForm();
    }

    public function __clone()
    {
        throw new Exception("Obiekt klasy Classes_Images_Uploader nie będzie klonowany.");
    }

    public static function createFormActionUrl($controller = 'index', $action = 'index')
    {
        self::$controller = $controller;
        self::$action = $action;
    }

    public static function getSizeLimit()
    {
        return $this->sizeLimit;
    }

    public static function setSizeLimit($limit = 1000000)
    {
        self::$sizeLimit = $limit;
    }

    public static function setTargetDirectory($dir)
    {
        self::$dir = $dir;
    }

    public static function setView($view)
    {
        self::$view = $view;
    }

    public static function generateUploadForm()
    {
        $options = array(
            'sizeLimit' => self::$sizeLimit, 
            'controller' => self::$controller,
            'action' => self::$action,
        );

        $view = Zend_Layout::getMvcInstance()->getView();
        return $view->uploader($options);
    }

    public static function start($request)
    {
        if ($request->isPost()) {

            try {

                self::uploadImage();
            } catch (Exception $ex) {
                $error = $ex->getMessage();
                $echo = "<script>alert('$error')</script>";
                self::$view->alert = $echo;
            }
        }
    }

    protected static function uploadImage()
    {

        if (empty($_FILES['file']['tmp_name']) || !isset($_FILES['file']['tmp_name'])) {
            throw new Zend_Exception("Wybierz plik do uploadu.");
        }

        if (filesize($_FILES['file']['tmp_name']) > self::$sizeLimit) {
            throw new Zend_Exception("Rozmiar pliku jest zbyt duży.");
        }

        $uploadFile = self::$dir;
        $newname = $_POST['newname'];

        if (null == $newname || '' == $newname) {
            throw new Zend_Exception("Wpisz nazwę dla nowego pliku.");
        }

        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        
        if(count(self::$allowedExt)< 1){
            throw new Zend_Exception("Uzupełnij dopuszczalne typy plików w tablicy options.");
        }
        
        if (!in_array($ext, self::$allowedExt)) {
            throw new Zend_Exception("Nie można importować plików .$ext.");
        }

        if (!file_exists($uploadFile)) {
            throw new Zend_Exception("Folder $uploadFile nie został odnaleziony.");
        }

        $newFileName = $uploadFile . '/' . $newname . '.' . $ext;

        if (file_exists($newFileName)) {
            throw new Zend_Exception("Plik o takiej nazwie juz istnieje!.");
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $newFileName)) {
            self::$view->ok = '<script>alert("Transfer udany.");</script>';
        } else {
            throw new Zend_Exception("Błedy w czasie transferu pliku.");
        }
    }

}
