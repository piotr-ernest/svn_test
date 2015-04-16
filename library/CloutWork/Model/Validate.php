<?php

/**
 * Description of Validate
 *
 * @author rnest
 */
class CloutWork_Model_Validate extends Zend_Db_Table_Abstract
{

    protected $_name = 'customers';
    protected $_primary = 'id';

    public function getCustomerByV($v)
    {
        $adapter = $this->getAdapter();

        $query = $adapter->select()
                ->from($this->_name)
                ->where($adapter->quoteInto('validation = ?', $v))
                ->limit(1);
        return $adapter->query($query)->fetchAll();
    }

    public function setStatus($status, $id)
    {
        $adapter = $this->getAdapter();
        return $adapter->update($this->_name, array('status' => (int) $status), $adapter->quoteInto('id = ?', $id));
    }

    public function getStatusByUsername($username)
    {
        $adapter = $this->getAdapter();

        $query = $adapter->select()
                ->from($this->_name, 'status')
                ->where($adapter->quoteInto('username = ?', $username))
                ->limit(1);
        return $adapter->query($query)->fetch();
    }

    public function setValidateExpired($id)
    {
        $adapter = $this->getAdapter();
        return $adapter->update($this->_name, array('validation' => 'expired'), $adapter->quoteInto('id = ?', $id));
    }

}
