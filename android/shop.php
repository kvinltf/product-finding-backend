<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/1/2018
 * Time: 4:39 PM
 */


require_once('../initialize.php');
require_once('../model/Shop.php');
require_once('../controller/ShopController.php');

$action = $data->action;
$responseObject = new ResponseObject();
$shopController = new ShopController($conn);

switch ($action) {
    case ShopController::ACTION_FETCH_ALL:
        $responseObject = $shopController->retrieveAll();
        echo $responseObject->toJsonResponse();
        break;
    default:
        $responseObject->setStatusFail();
        $responseObject->setMessage("No Action Match");
        echo $responseObject->toJsonResponse();
        break;

}