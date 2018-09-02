<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/1/2018
 * Time: 4:39 PM
 */


require_once('../initialize.php');
require_once('../model/ResponseObject.php');
require_once('../controller/ShopController.php');


$action = $data->action;
$responseObject = new ResponseObject();
$shopController = new ShopController($conn);

switch ($action) {
    case ShopController::ACTION_FETCH_ALL:
        $responseObject = $shopController->retrieveAll();
        echo $responseObject->toJsonResponse();
        break;
    case "addNewShop":

        $shop["shop_name"] = $data->shop_name;
        $shop["shop_desc"] = $data->shop_desc;
        $shop["lat"] = $data->lat;
        $shop["lng"] = $data->lng;
        $responseObject = $shopController->createNew($shop);
        echo $responseObject->toJsonResponse();
        break;
    default:
        $responseObject->setStatusFail();
        $responseObject->setMessage("No Action Match");
        echo $responseObject->toJsonResponse();
        break;

}