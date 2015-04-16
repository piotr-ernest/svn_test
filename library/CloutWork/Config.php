<?php

/**
 * Description of Config
 *
 * @author rnest
 */
class CloutWork_Config 
{

    const RETURN_ARRAY = 1;
    const RETURN_OBJECT = 0;

    protected $iterator;
    protected $config;
    protected $path;

    public function __construct($path = null, $file = null, $ext = '.php')
    {
        
        if (null === $path) {
            $this->path = APPLICATION_PATH . '/configs';
        } else {
            $this->path = $path;
        }

        if (null === $file) {
            throw new CloutWork_Config_Exception('Należy podać nazwę pliku z konfiguracją.');
        }

        $array = include($this->path . '/' . $file . $ext);
        
        if (!is_array($array)) {
            throw new CloutWork_Config_Exception('Plik konfiguracji musi być tablicą.');
        }

        $this->config = new Zend_Config($array);
        
    }

    public function __call($name, $arguments)
    {
        return $this->get($name, $arguments);
    }

    public function __toString()
    {
        $it = new ArrayIterator($this->config->toArray());
        return $it->serialize();
    }
    
    protected function get($name, $args)
    {
        $type = false;

        if (count($args) > 1) {
            throw CloutWork_Config_Exception('Liczba argumentów nie może być większa niż 1.');
        }

        if (isset($args[0])) {
            $type = $args[0] > 0 ? true : false;
        }

        $name = str_replace('get', '', $name);
        $name = strtolower($name);

        $it = new ArrayIterator($this->config->toArray());

        if ($it->offsetExists($name)) {

            $offset = $it->offsetGet($name);

            if (is_array($offset)) {
                return json_decode(json_encode($offset), $type);
            }

            return $it->offsetGet($name);
        }
    }

}
