<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/1/2018
 * Time: 4:40 PM
 */

class ShopController
{
    private static $tableName = "shop";


    public static function fetchAll(mysqli $conn)
    {
        $sql = 'SELECT * FROM ' . self::$tableName;
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $getResult = $stmt->get_result();
        $stmt->close();

        $allShop = array();

        while ($re = $getResult->fetch_assoc()) {
            $id = $re['id'];
            $name = $re['name'];
            $lat = $re['latitude'];
            $lng = $re['longitude'];
            $description = $re['description'];
            $created_on = $re['created_on'];

            $allShop[] = Shop::fromDatabase($id, $name, $lat, $lng, $description, $created_on);
        }

        return $allShop;
    }
}
