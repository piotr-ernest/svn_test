<?php

/**
 * Description of Articles
 *
 * @author rnest
 */
class CloutWork_Admin_Model_Articles extends Zend_Db_Table_Abstract
{

    protected $_name = 'articles';
    protected $_primary = 'id';

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
        //desc($data, 1);
        for ($i = 0; $i < count($data); $i++) {
            $result = $this->delete($this->getAdapter()->quoteInto('id = ?', $data[$i]));
            $this->deleteRelated($data[$i]);
            
            if (!$result) {
                return false;
            }
        }
        return count($data);
    }
    
    protected function deleteRelated($articleId)
    {
        $relMod = new CloutWork_Admin_Model_ArticlesRelated();
        return $relMod->deleteDataById($articleId);
    }

    public function getDataForDataTable($limit, $page, $adds = null)
    {
        $res = array();

        if (!empty($adds['name_sort']) && $adds['category_sort'] == 0) {

            $sql = $this->select()
                    ->from('articles', array('id', 'title', 'date_published', 'status', 'subtitle'))
                    ->where('title LIKE ?', '%' . $adds['name_sort'] . '%')
                    ->orWhere('subtitle LIKE ?', '%' . $adds['name_sort'] . '%')
                    ->order('id DESC')
                    ->limit($limit, ($page * $limit - $limit));
            
            $sql2 = $this->select()->from('articles', array('COUNT(*) AS count'))
                    ->where('title LIKE ?', '%' . $adds['name_sort'] . '%')
                    ->orWhere('subtitle LIKE ?', '%' . $adds['name_sort'] . '%');
            
            $res['query'] = $this->getAdapter()->query($sql)->fetchAll();
            $res['count'] = $this->getAdapter()->query($sql2)->fetch();
            
            return $res;
            
        } else if ($adds['category_sort'] > 0 && empty($adds['name_sort'])) {

            $sql = $this->getAdapter()->select()
                    ->from(array('a' => 'articles'), array('a.id', 'a.title', 'a.date_published', 'a.status', 'a.category'))
                    ->join(array('ac' => 'articles_categories'), 'ac.id = a.category', array('ac.name'))
                    ->where('ac.id = ?', $adds['category_sort'])
                    ->order('a.id DESC')
                    ->limit($limit, ($page * $limit - $limit));
            
            $sql2 = $this->select()->from('articles', array('COUNT(*) AS count'))
                    ->where('category = ?', $adds['category_sort']);
            
            $res['query'] = $this->getAdapter()->query($sql)->fetchAll();
            $res['count'] = $this->getAdapter()->query($sql2)->fetch();
            
            return $res;
            
        } else if ($adds['category_sort'] > 0 && !empty($adds['name_sort'])) {

            $sql = $this->getAdapter()->select()
                    ->from(array('a' => 'articles'), array('a.id', 'a.title', 'a.date_published', 'a.status', 'a.category'))
                    ->join(array('ac' => 'articles_categories'), 'ac.id = a.category', array('ac.name'))
                    ->where('ac.id = ?', $adds['category_sort'])
                    ->where('a.title LIKE ?', '%' . $adds['name_sort'] . '%')
                    ->orWhere('a.subtitle LIKE ?', '%' . $adds['name_sort'] . '%')
                    ->order('a.id DESC')
                    ->limit($limit, ($page * $limit - $limit));
            
            $sql2 = $this->select()->from('articles', array('COUNT(*) AS count'))
                    ->where('category = ?', $adds['category_sort'])
                    ->where('title LIKE ?', '%' . $adds['name_sort'] . '%')
                    ->orWhere('subtitle LIKE ?', '%' . $adds['name_sort'] . '%');
            
            $res['query'] = $this->getAdapter()->query($sql)->fetchAll();
            $res['count'] = $this->getAdapter()->query($sql2)->fetch();
            
            return $res;
            
        } else {

            $sql = $this->select()
                    ->from('articles', array('id', 'title', 'date_published', 'status'))
                    ->order('id DESC')
                    ->limit($limit, ($page * $limit - $limit));

            $sql2 = $this->select()->from('articles', array('COUNT(*) AS count'));
            $res['count'] = $this->getAdapter()->query($sql2)->fetch();
            $res['query'] = $this->getAdapter()->query($sql)->fetchAll();
            return $res;
            
        }
    }

    public function getDataById($id)
    {
        $sql = $this->select()
                ->from($this->_name)
                ->where($this->getAdapter()->quoteInto('id = ?', $id))
                ->limit(1);
        return $this->getAdapter()->query($sql)->fetch();
    }

}
