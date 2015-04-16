<?php

/**
 * Description of Tools
 *
 * @author rnest
 */
class Core_Tools
{

    public static function getBaseUrl()
    {
        $protocol = 'http://';

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $protocol = 'https://';
        }


        return $protocol . $_SERVER['HTTP_HOST'];
    }

    public static function getRootPath()
    {
        return dirname(APPLICATION_PATH);
    }

    public static function listDirectory($resourcesPath)
    {
        $rowFiles = scandir($resourcesPath);
        $files = array();
        while ($rowFile = each($rowFiles)) {
            if ($rowFile['value'] != '.' && $rowFile['value'] != '..') {
                if(!is_dir($rowFile['value'])){
                    $files[] = $rowFile['value'];
                }
            }
        }
        return $files;
    }

}
