<?php

    class Query{
        public $sql;
        private static $dbName;

        function __construct( $dbName ){
            self::$dbName = $dbName;
        }

        public function executeSql(){
            $this->sql = $connection->prepare("SELECT * FROM $dbName");
            $this->sql->execute();
        }

    }