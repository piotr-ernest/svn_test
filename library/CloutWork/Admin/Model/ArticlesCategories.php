<?php

/**
 * Description of Categories
 *
 * @author rnest
 */
class CloutWork_Admin_Model_ArticlesCategories extends Zend_Db_Table_Abstract
{

    protected $_name = 'articles_categories';
    protected $_primary = 'id';

    public function getCategories()
    {
        $sql = $this->select()
                ->from($this->_name)
                ->order('id DESC');
        return $this->getAdapter()->query($sql)->fetchAll();
    }
    
    public function getCategoriesForForm()
    {
        $categories = $this->getCategories();
        
        $wrapper = array();
        
        while($res = each($categories)){
            $wrapper[$res['value']['id']] = $res['value']['name'];
        }
        return array('-- Wybierz kategorię --') + $wrapper;
    }
    

    public function getCategoryNameById($id)
    {
        $sql = $this->select()
                ->from($this->_name, array('name', 'status'))
                ->where($this->getAdapter()->quoteInto('id = ?', $id))
                ->order('id DESC');
        return $this->getAdapter()->query($sql)->fetch();
    }

    public function getDataForDataTable($limit, $page)
    {
        $sql = $this->select()
                ->from($this->_name, array('id', 'name', 'date_created', 'status'))
                ->order('id DESC')
                ->limit($limit, ($page * $limit - $limit));

        $res['query'] = $this->getAdapter()->query($sql)->fetchAll();

        $sql = $this->select()->from($this->_name, array('COUNT(*) AS count'));
        $res['count'] = $this->getAdapter()->query($sql)->fetch();

        return $res;
    }

    public function insertData(Array $data)
    {
        return $this->insert($data);
    }

    public function updateData(Array $data, $id)
    {
        return $this->update($data, $this->getAdapter()->quoteInto('id = ?', $id));
    }

    public function deleteData(Array $data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $result = $this->delete($this->getAdapter()->quoteInto('id = ?', $data[$i]));
            if (!$result) {
                return false;
            }
        }
        return count($data);
    }

}
