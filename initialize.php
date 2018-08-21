<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/20/2018
 * Time: 11:31 AM
 */

require_once 'Database.php';

$conn = Database::getConnection();
$data = json_decode(file_get_contents("php://input"));
//header('Content-type:application/json;charset=utf-8');