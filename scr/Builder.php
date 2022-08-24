<?php
    namespace Indiciez\Vigilant;

    class Builder extends Security{
        protected static DBConfig $Database;
        protected static Security $Secure;

        public function __construct(){
            self::$Database = new DBConfig();
            self::$Secure = new Security(self::$Database->createConnection());
        }

        private static function organize(array $List,string $specify): string {
            $response = "";
            if($specify === "columns") {
                foreach ($List as $list) {
                    $cols = self::$Secure->validateInputs($list);
                    $response .= $cols . " , ";
                }
                $concatenate = ",";
            }else{
                foreach ($List as $key => $value){
                    $condition = self::$Secure->validateInputs($value);
                    $response .= " ".$key."'".$condition."' AND";
                }
                $concatenate = "AND";
            }
            return rtrim($response," ".$concatenate);
        }

        private static function processQuery(string $query_string): array {
            $response = [];
            $sql_query = self::$Database->createConnection()->query($query_string);
            while ($data = $sql_query->fetch_array()){ $response[] = $data; }
            mysqli_free_result($sql_query);
            return $response;
        }

        public static function builder(array $table,array $columns_list,array $conditions,int $limit): array {
            $table_name = $table[0];
            $columns = (sizeof($columns_list) > 0) ? self::organize($columns_list,"columns") : " * ";
            $where = (sizeof($conditions) > 0) ? " WHERE ".self::organize($conditions,"conditions") : " ";
            $sql_string = "SELECT {$columns} FROM {$table_name} {$where}  LIMIT {$limit}";
            return (new Builder())->processQuery($sql_string);
        }

        public static function rawQuery(string $raw_query_string): array {
            return (new Builder())->processQuery($raw_query_string);
        }
    }