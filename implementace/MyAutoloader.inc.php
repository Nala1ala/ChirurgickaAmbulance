<?php
/**
 * Automatická registrace tříd
 */

// Definice konstant pro mapování
// Namespace 'app' odpovídá kořenovému adresáři aplikace
define("BASE_NAMESPACE_NAME", "app");
define("BASE_APP_DIR_NAME", "");
define("FILE_EXTENSIONS", [".class.php", ".php"]);

spl_autoload_register(function ($className) {
    // 1. Odstraníme základní jmenný prostor (app)
    // Z "app\controllers\PatientController" uděláme "\controllers\PatientController"
    $path = str_replace(BASE_NAMESPACE_NAME, BASE_APP_DIR_NAME, $className);

    // 2. Převod zpětných lomítek z namespace na systémová lomítka (pro Windows/Linux)
    $path = str_replace("\\", DIRECTORY_SEPARATOR, $path);

    // 3. Sestavení absolutní cesty k souboru
    // dirname(__FILE__) vrací cestu ke složce, kde je tento autoloader (kořen)
    $fileName = dirname(__FILE__) . $path;

    // 4. Projdeme povolené přípony a zkusíme soubor načíst
    foreach(FILE_EXTENSIONS as $ext) {
        if (file_exists($fileName . $ext)) {
            require_once($fileName . $ext);
            return;
        }
    }

    // Volitelné: Pokud třídu nenajdeme, vypíšeme chybu (pomůže při ladění překlepů)
    // echo "Autoloader: Nelze načíst třídu '$className'. Hledáno v: '$fileName'";
});