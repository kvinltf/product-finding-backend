<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/12/2018
 * Time: 5:13 PM
 */

require_once('../initialize.php');
require_once('../model/Shop.php');
require_once('../controller/CatalogController.php');
require_once('../controller/ShopController.php');
require_once('../model/ResponseObject.php');

$action = $data->action;
$catalogController = new CatalogController($conn);
$responseObject = new ResponseObject();

switch ($action) {
    case 'searchall':
        $user_search = $data->user_search;
        $responseObject = $catalogController->retrieveByUserSearch($user_search);
        echo $responseObject->toJsonResponse();
        break;
    default:
}