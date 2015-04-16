<?php

/**
 * Description of ArticlesRelated
 *
 * @author rnest
 */
class CloutWork_Admin_Model_ArticlesRelated extends Zend_Db_Table_Abstract
{

    protected $_name = 'articles_related';
    protected $_primary = 'id';

    public function getByFrase($frase)
    {


        $adapter = $this->getAdapter();
        $query = $adapter->select()
                ->from(array('a' => 'articles'), array('a.id', 'a.title'))
                ->where('a.title LIKE ?', '%' . $frase . '%')
                ->order('a.id DESC')
                ->limit(10);

        $results = $this->getAdapter()->query($query)->fetchAll();

        if (empty($results)) {
            return array(array('id' => '0', 'title' => 'Brak wyników'));
        }

        return $results;
    }

    public function getRelatedByArticleId($id = null)
    {
        if (null === $id) {
            throw new Exception('Id artykułu nie może być null.');
        }

        $sql = $this->getAdapter()->select()
                ->from(array('r' => $this->_name), array('r.id', 'r.related_id', 'r.article_id'))
                ->join(array('a' => 'articles'), 'a.id = r.related_id', array('a.id', 'a.title'))
                ->where($this->getAdapter()->quoteInto('r.article_id = ?', $id));
        return $this->getAdapter()->query($sql)->fetchAll();
    }

    public function insertData(Array $rowData)
    {
        if ($rowData['articles'] == $rowData['related']) {
            return true;
        }

        if (!$rowData['articles']) {
            throw new Exception('articlesId nie może być puste.');
        }

        if (!$rowData['related']) {
            throw new Exception('relatedId nie może być puste.');
        }

        $adapter = $this->getAdapter();

        $sql = $adapter->select()
                ->from($this->_name)
                ->where($adapter->quoteInto('related_id = ?', $rowData['related']))
                ->where($adapter->quoteInto('article_id = ?', $rowData['articles']));

        $results = $adapter->query($sql)->fetch();

        if (count($results) > 1) {
            return true;
        }

        $data = array(
            'article_id' => $rowData['articles'],
            'related_id' => $rowData['related']
        );

        return $this->insert($data);
    }

    public function deleteData($articleId, $relatedId)
    {
        $adapter = $this->getAdapter();
        $where = array();
        $where[] = $adapter->quoteInto('article_id = ?', $articleId);
        $where[] = $adapter->quoteInto('related_id = ?', $relatedId);
        return $this->delete($where);
    }

    public function deleteDataById($articleId)
    {
        $result = array();
        
        $adapter = $this->getAdapter();
        $where = $adapter->quoteInto('article_id = ?', $articleId);
        $result[] = $this->delete($where);
        
        $where = $adapter->quoteInto('related_id = ?', $articleId);
        $result[] = $this->delete($where);
        
        return array_sum($result);
        
    }

}
