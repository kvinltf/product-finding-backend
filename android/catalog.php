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
require_once('../model/ResponseObject.php');

$action = $data->action;
$catalogController = new CatalogController($conn);
$responseObject = new ResponseObject();

//$action = "itemListNotInShop";

switch ($action) {
    case 'searchall':
        $user_search = $data->user_search;
        $responseObject = $catalogController->retrieveByUserSearch($user_search);
        echo $responseObject->toJsonResponse();
        break;
    case 'itemListInShop':
        $shop_id = $data->shop_id;
        $responseObject = $catalogController->retrieveItemListByShopId($shop_id, true);
        echo $responseObject->toJsonResponse();
        break;
    case 'itemListNotInShop':
        $shop_id = $data->shop_id;
//        $shop_id = 1;
        $responseObject = $catalogController->retrieveItemListByShopId($shop_id, false);
        echo $responseObject->toJsonResponse();
        break;
    case "saveItemToShopCatalog":
        $catalog["shop_id"] = $data->shop_id;
        foreach ($data->item_id_list as $itemId){
            $itemIdList[] = $itemId;
        }
        $catalog["item_id_list"] = $itemIdList;
        $responseObject = $catalogController->createNew($catalog);
        echo $responseObject->toJsonResponse();
        break;
    default:
}