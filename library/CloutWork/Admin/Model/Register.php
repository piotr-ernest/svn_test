<?php


/**
 * Description of Register
 *
 * @author rnest
 */
class CloutWork_Admin_Model_Register extends Zend_Db_Table_Abstract
{
    
    protected $_name = 'administration';
    protected $_primary = 'id';


    public function save($input)
    {
        if(!$input || !is_array($input)){
            return false;
        }
        
        $salt = CloutWork_Password_Salt::createSalt();
        $data = array(
            'saltz' => $salt,
            'username' => $input['username'],
            'password' => md5($input['password'] . $salt),
            'email' => $input['email'],
            'role' => $input['role'],
        );
        
        return $this->insert($data);
    }
}
