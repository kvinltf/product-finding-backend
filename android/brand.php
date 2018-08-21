<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/17/2018
 * Time: 3:15 PM
 */

include_once '../initialize.php';
include_once '../model/Brand.php';
include_once '../model/Category.php';
include_once '../model/ResponseObject.php';
include_once '../controller/CatalogController.php';

//$action = $data->action;

$responseObject = CatalogController::fetchAll($conn,'giant');
echo $responseObject->toJsonResponse();
