<?php
    declare(strict_types=1);
    use Indiciez\Vigilant\DBConfig;

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once realpath('../vendor/autoload.php');

    $DB = new DBConfig();
    print_r($DB->createConnection());

    echo "<br><br>";

    $Secure = new \Indiciez\Vigilant\Security($DB->createConnection());
    echo "Password :: ". $Secure::encryptPassword("Justin");