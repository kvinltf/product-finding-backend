<?php
//
//Class Database
//{
//    private $host = 'localhost';
//    private $username = 'kevin999990';
//    private $password = 'mysqladmin';
//    private $database = 'product_finding';
//    private $connection;
//
//    public function __construct()
//    {
//        $this->connection =
//            mysqli_connect($this->host, $this->username, $this->password, $this->database);
//
//        if (mysqli_connect_error()) {
//            trigger_error("Fail to connect to MySQL: " . mysqli_connect_error(), E_USER_ERROR);
//        }
//    }
//
//    public function __clone()
//    {
//        // TODO: Implement __clone() method.
//    }
//
//    public function getConnection()
//    {
//        return $this->connection;
//    }
//}
//

Class Database
{
//    private static $host = 'localhost';
//    private static $username = 'kevin999990';
//    private static $password = 'mysqladmin';
//    private static $database = 'product_finding';
//    private $connection;


    public static function getConnection()
    {
        $host = 'localhost';
        $username = 'kevin999990';
        $password = 'mysqladmin';
        $database = 'product_finding';

        $conn = mysqli_connect($host, $username, $password, $database) or die("Database Connection Error");

        return $conn;
    }
}