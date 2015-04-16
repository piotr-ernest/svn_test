<?php

/**
 * Description of Cookie
 *
 * @author rnest
 */
class CloutWork_Cookie
{
    /**
     *
     * @var Zend_Db_Adapter_Abstract $db
     */
    protected static $db;

    protected function __construct()
    {
        
    }

    public function __clone()
    {
        return;
    }

    public static function setCountingCookie()
    {
        Zend_Session::start();

        self::$db = Zend_Registry::get('db');
        
        $name = 'cid';
        $sessionId = Zend_Session::getId();
        
        if (isset($_COOKIE[$name])) {
            
            $cid = filter_input(INPUT_COOKIE, $name, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = self::getCIDData($cid);
            
            if($data['current_session'] != $sessionId){
                $counter = $data['counter'] + 1;
                self::updateCIDData($cid, $counter);
            }
            
        } else {
            
            $value = uniqid('cid_') . '_' . time();
            $expire = time() + (60 * 60 * 24 * 30 * 12);
            $path = '/';
            $domain = null;
            setcookie($name, $value, $expire, $path, $domain);
            self::insertCIDData($value);
            
        }
    }

    protected static function getCIDData($cid)
    {
        $query = self::$db->select()
                ->from('customers_visits')
                ->where(self::$db->quoteInto('cid = ?', $cid))
                ->limit(1);
        return self::$db->query($query)->fetch();
    }

    protected static function updateCIDData($cid, $counter)
    {
        $table = 'customers_visits';
        $data = array(
            'current_session' => Zend_Session::getId(),
            'counter' => $counter
        );
        $where = self::$db->quoteInto('cid = ?', $cid);
        return self::$db->update($table, $data, $where);
    }
    
    protected static function insertCIDData($cid)
    {
        $data = array(
            'cid' => $cid,
            'date_created' => time(),
            'current_session' => Zend_Session::getId(),
            'counter' => 1
        );
        return self::$db->insert('customers_visits', $data);
    }

}
