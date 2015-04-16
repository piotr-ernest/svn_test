<?php

/**
 * Description of Log
 *
 * @author rnest
 */
class CloutWork_Log
{

    public static function saveError($exc, $service = 'frontend')
    {
        $path = REPORTS_PATH . '/' . strtolower($service) . '_log.txt';

        $date = date('Y-m-d H:i:s');
        $file = $exc->getFile();
        $line = $exc->getLine();
        $trace = $exc->getTraceAsString();
        $message = $exc->getMessage();

        file_put_contents($path, print_r('===========================================', true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);

        file_put_contents($path, print_r('DATA: ' . $date, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);

        file_put_contents($path, print_r('PLIK: ' . $file, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);

        file_put_contents($path, print_r('LINIA: ' . $line, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);

        file_put_contents($path, print_r('TRACE: ' . $trace, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);

        file_put_contents($path, print_r('TRESC: ' . $message, true), FILE_APPEND);
        file_put_contents($path, PHP_EOL, FILE_APPEND);

        file_put_contents($path, print_r('===========================================', true), FILE_APPEND);
    }

}
