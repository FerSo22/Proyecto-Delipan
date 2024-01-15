<?php
    class Connection {
        private $connection;
        
        function __construct() {
            $this -> connection = mysqli_connect("localhost", "root", "", "delipan");
        }

        public function getConnection() {
            return $this -> connection;
        }

        public function closeConnection() {
            mysqli_close($this -> connection);
        }
    }
?>