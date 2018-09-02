<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/17/2018
 * Time: 3:15 PM
 */

include_once '../initialize.php';
include_once '../model/ResponseObject.php';
require_once('../controller/BrandController.php');

const ADD_NEW_BRAND = "addNewBrand";
const RETRIEVE_ALL_BRAND = "retrieveAllBrand";

$action = $data->action;
$brandController = new BrandController($conn);
$responseObject = new ResponseObject();

switch ($action) {
    case ADD_NEW_BRAND:
        $newBrand["brand_name"] = $data->brand_name;
        $newBrand["brand_desc"] = $data->brand_description;
        $responseObject = $brandController->createNew($newBrand);
        echo $responseObject->toJsonResponse();
        break;
    case RETRIEVE_ALL_BRAND:
        $responseObject = $brandController->retrieveAll();
        echo $responseObject->toJsonResponse();
        break;
}

