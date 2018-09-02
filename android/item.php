<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 9/2/2018
 * Time: 3:13 PM
 */

require_once('../initialize.php');
require_once('../model/ResponseObject.php');
require_once('../controller/ItemController.php');

const RETRIEVE_ALL = "retrieveAll";
const CRATE_NEW = "createNew";


$action = $data->action;
$itemController = new ItemController($conn);
$responseObject = new ResponseObject();

switch ($action) {
    case CRATE_NEW:
        $newItem["item_name"] = $data->item_name;
        $newItem["item_desc"] = $data->item_desc;
        $newItem["brand_id"] = $data->brand_id;
        $newItem["category_id"] = $data->category_id;
        $responseObject = $itemController->createNew($newItem);
        echo $responseObject->toJsonResponse();
        break;
}