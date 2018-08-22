<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/22/2018
 * Time: 1:25 PM
 */

require_once '../initialize.php';
require_once '../model/User.php';
require_once '../model/Shop.php';
require_once('../model/ResponseObject.php');
require_once('../controller/ShopOwnerController.php');

$responseObject = new ResponseObject();
$shopOwnerController = new ShopOwnerController($conn);
$action = $data->action;
//$action ='retriveownershoplist';

switch ($action) {
    case 'addshopowner':
        $inputValue['user_id'] = $data->user->id;
        foreach ($data->shop_list as $s) {
            $shopId[] = $s->id;
        }
        $inputValue['shop_id'] = $shopId;
        $responseObject = $shopOwnerController->createNew($inputValue);

        echo $responseObject->toJsonResponse();
        break;

    case 'retrieveOwnShopList':
        $responseObject = $shopOwnerController->retrieveShopListByUserId($data->user_id);
        echo $responseObject->toJsonResponse();
        break;
    case 'retrieveNotOwnShopList':
        $responseObject = $shopOwnerController->retrieveShopListByUserId($data->user_id,false);
        echo $responseObject->toJsonResponse();
        break;
}
