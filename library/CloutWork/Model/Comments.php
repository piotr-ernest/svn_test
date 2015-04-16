<?php

/**
 * Description of Comments
 *
 * @author rnest
 */
class CloutWork_Model_Comments extends Zend_Db_Table_Abstract
{
    protected $_name = 'comments';
    protected $_primary = 'id';
    
    public function getCommentsById($id, $limit, $page = 1)
    {
        $res = array();
        $adapter = $this->getAdapter();
        
        $total = $adapter->select()
                ->from($this->_name, 'COUNT(ID) AS count')
                ->where($adapter->quoteInto('article_id = ?', $id))
                ->where($adapter->quoteInto('status = ?', 1));
        $res['total'] = $adapter->query($total)->fetch();
        
        $sql = $adapter->select()
                ->from($this->_name)
                ->where($adapter->quoteInto('article_id = ?', $id))
                ->where($adapter->quoteInto('status = ?', 1))
                ->order('id DESC')
                ->limit($limit, ($limit * $page - $limit));
        
        $res['query'] = $adapter->query($sql)->fetchAll();
        
        return $res;
        
    }
    
    public function insertComment(Array $data)
    {
        return $this->insert($data);
    }
    
}
