<?php
    namespace Indiciez\Vigilant;

    class DBConfig{
        private static $connection = null;
        private static array $variables = ['host' => 'localhost', 'username' => 'root', 'password' => 'root', 'database' => 'ehms_kcmc'];

        public function createConnection(): array|bool|\mysqli|null {
            if (is_null(self::$connection)) {
                self::$connection = mysqli_connect(self::$variables['host'],self::$variables['username'],self::$variables['password'],self::$variables['database']);
            }
            return (!self::$connection) ? ["not connected"] : self::$connection;
        }
    }