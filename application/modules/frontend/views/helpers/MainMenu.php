<?php



/**
 * Description of MainMenu
 *
 * @author rnest
 */
class Zend_View_Helper_MainMenu extends Zend_View_Helper_Abstract
{
    public function mainMenu()
    {
        $sg = false;
        $model = new CloutWork_Model_ArticlesCategories();
        $categories = $model->getCategories();
        
        $ctrl = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        $action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('category-id');
        
        if($ctrl == 'index'){
            if($action == 'index'){
                $sg = true;
            }
            
        }
        
        return $this->view->partial('app-partials/mainMenu.phtml', null, 
                array(
                    'categories' => $categories, 
                    'sg' => $sg, 
                    'id' => $id
                ));
    }
}
