<?php

/**
 * Description of Articles
 *
 * @author rnest
 */
class CloutWork_Model_Articles extends Zend_Db_Table_Abstract
{

    protected $_name = 'articles';
    protected $_primary = 'id';

    public function getArticles()
    {
        $sql = $this->select()
                ->from($this->_name)
                ->order('id DESC');
        $adapter = $this->getAdapter();
        return $adapter->query($sql)->fetchAll();
    }

    public function getArticlesForMainSite($limit, $page)
    {
        $res = array();
        $adapter = $this->getAdapter();
        
        $total = $adapter->select()->from($this->_name, 'COUNT(id) AS count');
        $res['total'] = $adapter->query($total)->fetch();
        
        $sql = $this->select()
                ->from($this->_name, array('id', 'category', 'title', 'label', 'subtitle', 'photo'))
                ->where('status = 1')
                ->order('id DESC')
                ->limit($limit, ($page * $limit - $limit));
        
        $result = $adapter->query($sql)->fetchAll();
        $res['query'] = $result;
        $res['count'] = count($result);
        
        return $res;
    }
    
    public function getArticleById($id)
    {
        if(null == $id){
            throw new Exception('Id artykułu nie może być null.');
        }
        
        $adapter = $this->getAdapter();
        $sql = $this->select()
                ->from($this->_name)
                ->where($adapter->quoteInto('id = ?', $id))
                ->limit(1);
        
        return $adapter->query($sql)->fetchAll();
        
    }
    
    public function getArticlesByCategory($categoryId, $limit, $page)
    {
        $adapter = $this->getAdapter();
        $res = array();
        
        $total = $adapter->select()->from($this->_name, 'COUNT(id) AS count')
                ->where($adapter->quoteInto('category = ?', $categoryId))
                ->where($adapter->quoteInto('status = ?', 1));
        $res['total'] = $adapter->query($total)->fetch();
        
        $sql = $this->select()
                ->from($this->_name, array('id', 'category', 'title', 'subtitle', 'label', 'photo'))
                ->where($adapter->quoteInto('category = ?', $categoryId))
                ->where($adapter->quoteInto('status = ?', 1))
                ->order('id DESC')
                ->limit($limit, ($limit * $page - $limit));
        $res['query'] = $adapter->query($sql)->fetchAll();
        
        return $res;
    }
    
    public function getArticlesForSlider($count = 3)
    {
        $adapter = $this->getAdapter();
        $sql = $this->select()
                ->from($this->_name, array('id', 'category', 'title', 'subtitle', 'photo'))
                ->order('id DESC')
                ->limit($count);
        
        return $adapter->query($sql)->fetchAll();
    }

}
