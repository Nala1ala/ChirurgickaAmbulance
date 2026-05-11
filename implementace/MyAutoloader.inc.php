<?php
/**
 * Automatic class registration
 */

define("BASE_NAMESPACE_NAME", "app");
define("BASE_APP_DIR_NAME", "");
define("FILE_EXTENSIONS", [".class.php", ".php"]);


spl_autoload_register(function ($className) {
    $path = str_replace(BASE_NAMESPACE_NAME, BASE_APP_DIR_NAME, $className);

    $path = str_replace("\\", DIRECTORY_SEPARATOR, $path);

    $fileName = dirname(__FILE__) . $path;

    foreach(FILE_EXTENSIONS as $ext) {
        if (file_exists($fileName . $ext)) {
            require_once($fileName . $ext);
            return;
        }
    }
});