<?php

/**
 * Description of ArticlesCategories
 *
 * @author rnest
 */
class CloutWork_Model_ArticlesCategories extends Zend_Db_Table_Abstract
{

    protected $_name = 'articles_categories';
    protected $_primary = 'id';

    public function getCategories()
    {
        $adapter = $this->getAdapter();
        $sql = $this->select()
                ->from($this->_name)
                ->where('status = 1');
        return $adapter->query($sql)->fetchAll();
    }

    public function getCategoriesIds()
    {
        $adapter = $this->getAdapter();
        $sql = $this->select()
                ->from($this->_name, array('id', 'name'))
                ->where('status = 1');
        $res = $adapter->query($sql)->fetchAll();

        $array = array();

        while ($a = each($res)) {
            $array[$a['value']['id']] = $a['value']['name'];
        }
        return $array;
    }

    

}
