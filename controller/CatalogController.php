<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/12/2018
 * Time: 5:14 PM
 */

require_once dirname(__FILE__).'/../model/Catalog.php';
require_once dirname(__FILE__).'/../model/ResponseObject.php';
require_once dirname(__FILE__).'/BaseController.php';

class CatalogController extends BaseController
{
    /**
     * CatalogController constructor.
     * @param mysqli $conn
     * @param string $table_name
     */
    public function __construct(mysqli $conn, string $table_name = "shop_catalog")
    {
        parent::__construct($conn,$table_name);
    }

    public static function fetchAll(mysqli $conn, string $userSearch)
    {
        $sql = 'SELECT 
      s.id          shop_id,
       s.name        shop_name,
       s.description shop_description,
       s.latitude      shop_latitude,
       s.longitude     shop_longitude,
       s.created_on    shop_created_on,
       i.id          item_id,
       i.name        item_name,
       i.description item_description,
       c.id          category_id,
       c.name        category_name,
       b.id          brand_id,
       b.name        brand_name,
       b.description brand_description

FROM shop_catalog sc
       JOIN shop s ON sc.shop_id = s.id
       JOIN item i ON sc.item_id = i.id
       JOIN brand b ON i.brand_id = b.id
       JOIN category c on i.category_id = c.id
WHERE s.name LIKE ?
   OR i.name LIKE ?
   OR b.name LIKE ?';

        $responseObject = new ResponseObject();
        if (!$conn) {
            $responseObject->setStatusFailWithMessage(ResponseObject::NO_DATABASE_CONNECTION);
            $responseObject->setErrorMessage($conn->error);
            return $responseObject;
        } else {
            try {
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    $responseObject->setStatusFailWithMessage(ResponseObject::FAIL_PREPARE_STMT);
                    $responseObject->setErrorMessage($conn->error);
                    return $responseObject;
                } else {
                    $userSearch = '%' . $userSearch . '%';

                    if (!$stmt->bind_param('sss', $userSearch, $userSearch, $userSearch)) {
                        $responseObject->setStatusFailWithMessage(ResponseObject::FAIL_STMT_BIND_PARAM);
                        $responseObject->setErrorMessage($stmt->error);
                        return $responseObject;
                    } else {
                        $stmt->execute();
                        $stmtResult = $stmt->get_result();
                        $stmt->close();
                        $cat = array();
                        $num = 0;
                        while ($result = $stmtResult->fetch_assoc()) {
                            ++$num;

                            $shop['id'] = utf8_encode($result['shop_id']);
                            $shop['name'] = utf8_encode($result['shop_name']);
                            $shop['description'] = utf8_encode($result['shop_description']);
                            $shop['latitude'] = utf8_encode($result['shop_latitude']);
                            $shop['longitude'] = utf8_encode($result['shop_longitude']);
                            $shop['created_on'] = utf8_encode($result['shop_created_on']);

                            $category['id'] = utf8_encode($result['category_id']);
                            $category['name'] = utf8_encode($result['category_name']);

                            $brand ['id'] = utf8_encode($result['brand_id']);
                            $brand ['name'] = utf8_encode($result['brand_name']);
                            $brand ['description'] = utf8_encode($result['brand_description']);

                            $item['id'] = utf8_encode($result['item_id']);
                            $item['name'] = utf8_encode($result['item_name']);
                            $item['description'] = utf8_encode($result['item_description']);
                            $item['category'] = $category;
                            $item['brand'] = $brand;

                            $catalog['shop'] = $shop;
                            $catalog['item'] = $item;

                            $c = new Catalog($shop, $item);
                            $cat[] = $c->toArray();
                        }
                        $responseObject->setStatusSuccess();
                        $responseObject->setMessageWithRetrieveCount($num);
                        $responseObject->setQueryResult($cat);
                    }
                }
            } finally {
                $stmt->close();
            }
        }
        return $responseObject;
    }

    public function createNew($param)
    {
        // TODO: Implement createNew() method.
    }

    public function retrieveAll()
    {
        // TODO: Implement retrieveAll() method.
    }
    public function retrieveByUserSearch(string $user_search){
        $sql = 'SELECT 
      s.id          shop_id,
       s.name        shop_name,
       s.description shop_description,
       s.latitude      shop_latitude,
       s.longitude     shop_longitude,
       s.created_on    shop_created_on,
       i.id          item_id,
       i.name        item_name,
       i.description item_description,
       c.id          category_id,
       c.name        category_name,
       b.id          brand_id,
       b.name        brand_name,
       b.description brand_description

FROM shop_catalog sc
       JOIN shop s ON sc.shop_id = s.id
       JOIN item i ON sc.item_id = i.id
       JOIN brand b ON i.brand_id = b.id
       JOIN category c on i.category_id = c.id
WHERE s.name LIKE ?
   OR i.name LIKE ?
   OR b.name LIKE ?';

        $responseObject = new ResponseObject();
        if (!$this->conn) {
            $responseObject->setStatusFailWithMessage(ResponseObject::NO_DATABASE_CONNECTION);
            $responseObject->setErrorMessage($this->conn->error);
            return $responseObject;
        } else {
            try {
                $stmt = $this->conn->prepare($sql);
                if (!$stmt) {
                    $responseObject->setStatusFailWithMessage(ResponseObject::FAIL_PREPARE_STMT);
                    $responseObject->setErrorMessage($this->conn->error);
                    return $responseObject;
                } else {
                    $userSearch = '%' . $user_search . '%';

                    if (!$stmt->bind_param('sss', $userSearch, $userSearch, $userSearch)) {
                        $responseObject->setStatusFailWithMessage(ResponseObject::FAIL_STMT_BIND_PARAM);
                        $responseObject->setErrorMessage($stmt->error);
                        return $responseObject;
                    } else {
                        $stmt->execute();
                        $stmtResult = $stmt->get_result();
                        $stmt->close();
                        $cat = array();
                        $num = 0;
                        while ($result = $stmtResult->fetch_assoc()) {
                            ++$num;

                            $shop['id'] = utf8_encode($result['shop_id']);
                            $shop['name'] = utf8_encode($result['shop_name']);
                            $shop['description'] = utf8_encode($result['shop_description']);
                            $shop['latitude'] = utf8_encode($result['shop_latitude']);
                            $shop['longitude'] = utf8_encode($result['shop_longitude']);
                            $shop['created_on'] = utf8_encode($result['shop_created_on']);

                            $category['id'] = utf8_encode($result['category_id']);
                            $category['name'] = utf8_encode($result['category_name']);

                            $brand ['id'] = utf8_encode($result['brand_id']);
                            $brand ['name'] = utf8_encode($result['brand_name']);
                            $brand ['description'] = utf8_encode($result['brand_description']);

                            $item['id'] = utf8_encode($result['item_id']);
                            $item['name'] = utf8_encode($result['item_name']);
                            $item['description'] = utf8_encode($result['item_description']);
                            $item['category'] = $category;
                            $item['brand'] = $brand;

                            $catalog['shop'] = $shop;
                            $catalog['item'] = $item;

                            $c = new Catalog($shop, $item);
                            $cat[] = $c->toArray();
                        }
                        $responseObject->setStatusSuccess();
                        $responseObject->setMessageWithRetrieveCount($num);
                        $responseObject->setQueryResult($cat);
                    }
                }
            } finally {
                $stmt->close();
            }
        }
        return $responseObject;
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