<?php
    namespace Indiciez\Vigilant;

    class Security{
        protected static $connect;

        public function __construct($conn){
            self::$connect = $conn;
        }

        public static function validateInputs(string $inputValue): string {
            return mysqli_real_escape_string(self::$connect,$inputValue);
        }

        public static function encryptPassword(string $password): string {
            return hash("sha256",$password);
        }
    }