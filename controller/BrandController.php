<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 9/2/2018
 * Time: 1:07 PM
 */

require_once dirname(__FILE__) . '/../model/Brand.php';
require_once dirname(__FILE__) . '/../model/ResponseObject.php';
require_once dirname(__FILE__) . '/BaseController.php';

class BrandController extends BaseController
{
    public function __construct(mysqli $conn, string $table_name = "brand")
    {
        parent::__construct($conn, $table_name);
    }


    public function createNew($brand): ResponseObject
    {
        $_brandName = $brand["brand_name"];
        $_brandDesc = $brand["brand_desc"];

        $sql = "INSERT INTO product_finding.brand (name, description) VALUES (?,?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $_brandName, $_brandDesc);
        $stmt->execute();
        if ($this->conn->errno == 0) {
            $this->responseObject->setStatusSuccessWithMessage("Success Create New Brand");
        } else {
            $this->responseObject->setStatusFailWithMessage($this->conn->error);
        }
        $stmt->close();
        return $this->responseObject;
    }

    public function retrieveAll(): ResponseObject
    {
        // TODO: Implement retrieveAll() method.
        $sql = "SELECT * FROM product_finding.brand";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        if ($this->conn->errno == 0) {
            $result = $stmt->get_result();

            while ($assoc_result = $result->fetch_assoc()) {
                $brandList[] = array_map("utf8_encode", $assoc_result);
            }
            $this->responseObject->setQueryResult($brandList);
            $this->responseObject->setStatusSuccessWithMessage("Success Retrieve All Brand");
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

;