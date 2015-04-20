<?php

/**
 * Description of Standard
 *
 * @author rnest
 */
abstract class CloutWork_Admin_Model_Datatable_Standard extends Zend_Db_Table_Abstract
{

    protected $_name = null;
    protected $_primary = null;

    abstract public function getDataForDataTable($limit, $page, $adds = null);
}
