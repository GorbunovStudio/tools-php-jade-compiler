<?php
class Autoloader {
    static public function loader($className) {

        $filename = __DIR__ . DIRECTORY_SEPARATOR . str_replace("\\",  DIRECTORY_SEPARATOR, $className) . ".php";

        if (file_exists($filename)) {
            include($filename);
            if (class_exists($className)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}

spl_autoload_register('Autoloader::loader');