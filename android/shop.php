<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/1/2018
 * Time: 4:39 PM
 */


require_once('../Database.php');
require_once('../model/Shop.php');
require_once('../controller/ShopController.php');

$conn = Database::getConnection();
$data = json_decode(file_get_contents("php://input"));
$action = $data->action;

switch ($action) {
    case 'fetchall':
        if ($shopList = ShopController::fetchAll($conn)) {
            $result["status"] = 'SUCCESS';
            foreach ($shopList as $shop) {
                $shopJson[] = ($shop->toJson());
            }
            $result['result'] = $shopJson;
        } else {
            $result["status"] = 'FAIL';
            $result['result'] = 'Fail Retrive Result';
        }
        echo json_encode($result);
        break;
    default:
        $result["status"] = 'FAIL';
        $result['result'] = '';
        $result['data'] = $data;
        $result['action'] = $action;
        echo json_encode($result);
        break;
}