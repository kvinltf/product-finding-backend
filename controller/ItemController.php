<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 9/2/2018
 * Time: 3:13 PM
 */
require_once dirname(__FILE__) . '/../model/Item.php';
require_once dirname(__FILE__) . '/../model/ResponseObject.php';
require_once dirname(__FILE__) . '/BaseController.php';
class ItemController extends BaseController
{
    public function __construct(mysqli $conn, string $table_name="item")
    {
        parent::__construct($conn, $table_name);
    }


    public function createNew($item)
    {
        $itemName = $item["item_name"];
        $itemDesc=$item["item_desc"];
        $brandId=$item["brand_id"];
        $categoryId=$item["category_id"];

        $sql = "INSERT INTO product_finding.item (name, description, category_id, brand_id) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii",$itemName,$itemDesc,$categoryId,$brandId);
        $stmt->execute();
        if ($this->conn->errno == 0) {
            $this->responseObject->setStatusSuccessWithMessage("Success Create New Item");
        } else {
            $this->responseObject->setStatusFailWithMessage($this->conn->error);
        }
        $stmt->close();
        return $this->responseObject;
    }

    public function retrieveAll()
    {
        // TODO: Implement retrieveAll() method.
    }

    public function updateById($param, $id)
    {
        // TODO: Implement updateById() method.
    }

    public function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }
}