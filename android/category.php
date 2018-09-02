<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 9/2/2018
 * Time: 2:53 PM
 */

require_once('../initialize.php');
require_once('../model/ResponseObject.php');
require_once('../controller/CategoryController.php');

const RETRIEVE_ALL = "retrieveAll";
const NEW_CATEGORY = "newCategory";

$action = $data->action;
$categoryController = new CategoryController($conn);
$responseObject = new ResponseObject();

switch ($action) {
    case RETRIEVE_ALL:
        $responseObject = $categoryController->retrieveAll();
        echo $responseObject->toJsonResponse();
        break;
    case NEW_CATEGORY:
        $categoryName = $data->category_name;
        $responseObject = $categoryController->createNew($categoryName);
        echo $responseObject->toJsonResponse();
        break;
}