<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 7/18/2018
 * Time: 4:30 PM
 */

require_once('./Database.php');
require_once './controller/UserController.php';

echo nl2br("Welcome to Product Finding PHP index" . PHP_EOL);

//$conn = Database::getConnection();
if ($conn) {
    echo nl2br("Success Connect to Database" . PHP_EOL);
    $conn->close();
}