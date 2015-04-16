<?php


/**
 * Description of Customers
 *
 * @author rnest
 */
class CloutWork_Model_Customers extends Zend_Db_Table_Abstract
{
    protected $_name = 'customers';
    protected $_primary = 'id';
    
    public function getRoleByUserName($username)
    {
        $sql = $this->select()
                ->from($this->_name, array('role'))
                ->where('username = ?', $username)
                ->limit(1);
        return $this->getAdapter()->query($sql)->fetch();
    }
    
}
