<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 9/2/2018
 * Time: 2:23 PM
 */

require_once dirname(__FILE__) . '/../model/Category.php';
require_once dirname(__FILE__) . '/../model/ResponseObject.php';
require_once dirname(__FILE__) . '/BaseController.php';

class CategoryController extends BaseController
{
    public function __construct(mysqli $conn, string $table_name = "category")
    {
        parent::__construct($conn, $table_name);
    }


    public function createNew($categoryName)
    {
        $_categoryName = $categoryName;

        $sql = "INSERT INTO product_finding.category (name) VALUES (?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $_categoryName);
        $stmt->execute();
        if ($this->conn->errno == 0) {
            $this->responseObject->setStatusSuccessWithMessage("Success Create New Category");
        } else {
            $this->responseObject->setStatusFailWithMessage($this->conn->error);
        }
        $stmt->close();
        return $this->responseObject;
    }

    public function retrieveAll()
    {
        $sql = "SELECT * FROM category";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        if ($this->conn->errno == 0) {
            $result = $stmt->get_result();

            while ($assoc_result = $result->fetch_assoc()) {
                $categoryList["id"] = utf8_encode($assoc_result["id"]);
                $categoryList["name"] = utf8_encode($assoc_result["name"]);

                $catList[]= $categoryList;
            }
            $this->responseObject->setQueryResult($catList);
            $this->responseObject->setStatusSuccessWithMessage("Success Retrieve All Category");
        } else {
            $this->responseObject->setStatusFailWithMessage($this->conn->error);
        }
        $stmt->close();
        return $this->responseObject;
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