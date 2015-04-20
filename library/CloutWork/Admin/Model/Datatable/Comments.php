<?php

/**
 * Description of Comments
 *
 * @author rnest
 */
class CloutWork_Admin_Model_Datatable_Comments extends CloutWork_Admin_Model_Datatable_Standard
{

    protected $_name = 'comments';
    protected $_primary = 'id';

    public function getDataForDataTable($limit, $page, $adds = null)
    {
        $results = array();
        $adapter = $this->getAdapter();
        
        $count = $adapter->select()
                ->from($this->_name, 'COUNT(id) AS number');
        
        $results['count'] = $adapter->query($count)->fetch();
        
        $sql = $adapter->select()
                ->from($this->_name)
                ->order('id DESC')
                ->limit($limit, ($limit * $page - $limit));
        $results['query'] = $adapter->query($sql)->fetchAll();
        
        return $results;
    }

}
