<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/1/2018
 * Time: 4:40 PM
 */

require_once '../model/Shop.php';
require_once '../model/ResponseObject.php';
require_once 'BaseController.php';

class ShopController extends BaseController
{
    const ACTION_FETCH_ALL = 'fetchall';

    public function __construct(mysqli $conn, string $table_name = 'shop')
    {
        parent::__construct($conn, $table_name);
    }

    public
    function createNew($shop)
    {
        // TODO: Implement createNew() method.
    }

    public
    function retrieveAll(): ResponseObject
    {
        $sql = 'SELECT * FROM ' . $this->table_name;
        try {
            /*CHECK PREPARE SQL SUCCESS*/
            if (!$stmt = $this->conn->prepare($sql)) {
                /*PREPARE SQL FAIL*/
                $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_PREPARE_STMT);
                $this->responseObject->setErrorMessage($this->conn->error);
            } else {
                /*PREPARE SQL SUCCESS*/

                /*CHECK STATEMENT EXECUTE RESULT*/
                if ($stmt->execute()) {
                    /*SUCCESS EXECUTE STATEMENT*/
                    $stmtResult = $stmt->get_result();
                    $allShop = array();
                    $num = 0;
                    while ($assoc_result = $stmtResult->fetch_assoc()) {
                        ++$num;
                        $id = $assoc_result['id'];
                        $name = $assoc_result['name'];
                        $lat = $assoc_result['latitude'];
                        $lng = $assoc_result['longitude'];
                        $description = $assoc_result['description'];
                        $created_on = $assoc_result['created_on'];

                        $allShop[] = Shop::fromDatabase($id, $name, $lat, $lng, $description, $created_on)->toArray();
                    }
                    $this->responseObject->setStatusSuccess();
                    $this->responseObject->setQueryResult($allShop);
                    $this->responseObject->setMessageWithRetrieveCount($num);
                } else {
                    /*FAIL EXECUTE RESULT*/
                    $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_EXECUTES_QUERY);
                    $this->responseObject->setErrorMessage($stmt->error);
                }
            }
            return $this->responseObject;
        } finally {
            $stmt->close();
        }
    }

    public
    function updateById($param, $id)
    {
        // TODO: Implement updateById() method.
    }

    public
    function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }
}
