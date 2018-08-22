<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/22/2018
 * Time: 1:27 PM
 */
require_once 'BaseController.php';

class ShopOwnerController extends BaseController
{
    public function __construct(mysqli $conn, string $table_name = "shop_owner")
    {
        parent::__construct($conn, $table_name);
    }


    public function createNew($owner_shop)
    {
        // TODO: Implement createNew() method.
        try {
            $sql = "INSERT INTO shop_owner VALUES(?,?)";
            $stmt = $this->conn->prepare($sql);

            foreach ($owner_shop["shop_id"] as $sId) {
                $stmt->bind_param('ii', $owner_shop['user_id'], $sId);
                $stmt->execute();
            }

            if ($this->conn->errno == 0) {
                $this->responseObject->setStatusSuccessWithMessage("Success Add Shop");

            } else {
                $this->responseObject->setStatusFailWithMessage($this->conn->error);
                $this->responseObject->setErrorMessage($this->conn->error);
            }

        } catch (Exception $e) {
            $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_EXCEPTION);
            $this->responseObject->setErrorMessage($e->getMessage());
        }
        $stmt->close();
        return $this->responseObject;
    }

    public function retrieveAll()
    {
        // TODO: Implement retrieveAll() method.
    }

    public function retrieveShopListByUserId(int $userId, bool $ownedShop = true)
    {
        $sql =
            $ownedShop ?
                'SELECT *
FROM shop s
WHERE s.id IN
      (SELECT s2.id FROM shop_owner so JOIN shop s2 on so.shop_id = s2.id WHERE so.user_id = ?)'
                :
                'SELECT *
FROM shop s
WHERE s.id NOT IN
      (SELECT s2.id FROM shop_owner so JOIN shop s2 on so.shop_id = s2.id WHERE so.user_id = ?)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);

        $stmt->execute();

        if ($this->conn->errno == 0) {
            $stmtResult = $stmt->get_result();

            while ($assoc_result = $stmtResult->fetch_assoc()) {
                $allShop[] = $assoc_result;
            }
            $this->responseObject->setStatusSuccessWithMessage("Success Retrieve Shop By User List");
            $this->responseObject->setQueryResult($allShop);

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