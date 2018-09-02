<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/12/2018
 * Time: 5:14 PM
 */

require_once dirname(__FILE__) . '/../model/Catalog.php';
require_once dirname(__FILE__) . '/../model/Category.php';
require_once dirname(__FILE__) . '/../model/Brand.php';

require_once dirname(__FILE__) . '/../model/ResponseObject.php';
require_once dirname(__FILE__) . '/BaseController.php';

const  item_name = "item_name";
const  item_desc = "item_desc";
const  shop_name = "shop_name";
const  shop_desc = "shop_desc";
const  brand_name = "brand_name";
const  brand_desc = "brand_desc";
const  category = "category";


class CatalogController extends BaseController
{
    /**
     * CatalogController constructor.
     * @param mysqli $conn
     * @param string $table_name
     */
    public function __construct(mysqli $conn, string $table_name = "shop_catalog")
    {
        parent::__construct($conn, $table_name);
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

    public function createNew($catalog): ResponseObject
    {
        // TODO: Implement createNew() method.

        try {
            $sql = "INSERT INTO product_finding.shop_catalog (shop_id, item_id) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);

            foreach ($catalog["item_id_list"] as $itemId) {
                $stmt->bind_param('ii', $catalog['shop_id'], $itemId);
                $stmt->execute();
            }

            if ($this->conn->errno == 0) {
                $this->responseObject->setStatusSuccessWithMessage("Success Add Catalog to Shop");

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

    public function retrieveByUserSearch(string $user_search, $search_condition)
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
WHERE ';

        /*s.name LIKE ?
OR s.description LIKE ?
   OR i.name LIKE ?
   OR i.description LIKE ?
   OR b.name LIKE ?
   OR b.description LIKE ?
   OR c.name LIKE ?*/

        $appendCondition = '';
        $userSearch = '\'%' . $user_search . '%\'';
        $i = 0;
        foreach ($search_condition as $condition) {
            if ($i > 0) {
                $appendCondition = $appendCondition . " OR ";
            }
            $i++;
            if ($condition === item_name) {
                $appendCondition = $appendCondition . " i.name LIKE " . $userSearch;
            } elseif ($condition === item_desc) {
                $appendCondition = $appendCondition . " i.description LIKE " . $userSearch;
            } elseif ($condition === shop_name) {
                $appendCondition = $appendCondition . " s.name LIKE " . $userSearch;
            } elseif ($condition === shop_desc) {
                $appendCondition = $appendCondition . " s.description LIKE" . $userSearch;
            } elseif ($condition === brand_name) {
                $appendCondition = $appendCondition . " b.name LIKE " . $userSearch;
            } elseif ($condition === brand_desc) {
                $appendCondition = $appendCondition . " b.description LIKE " . $userSearch;
            } elseif ($condition === category) {
                $appendCondition = $appendCondition . " c.name LIKE " . $userSearch;
            }
        }
        if ($i == 0) {
            $appendCondition =
                "s.name LIKE " . $userSearch .
                "OR s.description LIKE " . $userSearch .
                "OR i.name LIKE " . $userSearch .
                "OR i.description LIKE " . $userSearch .
                "OR b.name LIKE " . $userSearch .
                "OR b.description LIKE " . $userSearch .
                "OR c.name LIKE " . $userSearch;
        }

        $sql = $sql . $appendCondition;

        $responseObject = new ResponseObject();
        if (!$this->conn) {
            $responseObject->setStatusFailWithMessage(ResponseObject::NO_DATABASE_CONNECTION);
            $responseObject->setErrorMessage($this->conn->error);
            return $responseObject;
        } else {

                $stmt = $this->conn->prepare($sql);
                if (!$stmt) {
                    $responseObject->setStatusFailWithMessage(ResponseObject::FAIL_PREPARE_STMT);
                    $responseObject->setErrorMessage($this->conn->error);
                    return $responseObject;
                } else {
                    /*$userSearch = '%' . $user_search . '%';

                    if (!$stmt->bind_param('sss', $userSearch, $userSearch, $userSearch)) {
                        $responseObject->setStatusFailWithMessage(ResponseObject::FAIL_STMT_BIND_PARAM);
                        $responseObject->setErrorMessage($stmt->error);
                        return $responseObject;
                    } else {*/
                    $stmt->execute();
                    $stmtResult = $stmt->get_result();
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
        return $responseObject;
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

    public
    function retrieveItemListByShopId(string $shop_id, bool $isShopOwnedItem)
    {

        if ($isShopOwnedItem) {
            $sql = "
SELECT i.id item_id,
       i.name item_name,
       i.description item_desc,
       b.id brand_id,
       b.name brand_name,
       b.description brand_desc,
       c.id cat_id,
       c.name cat_name,
       is_deleted cat_isdelete,
       parent_id cat_parent_id
FROM item i
JOIN brand b on i.brand_id = b.id
JOIN category c on i.category_id = c.id
WHERE i.id
        IN (SELECT sc.item_id FROM shop_catalog sc
                               JOIN shop s on sc.shop_id = s.id WHERE s.id = ?)";
        } else {
            $sql = "
SELECT i.id item_id,
       i.name item_name,
       i.description item_desc,
       b.id brand_id,
       b.name brand_name,
       b.description brand_desc,
       c.id cat_id,
       c.name cat_name,
       is_deleted cat_isdelete,
       parent_id cat_parent_id
FROM item i
JOIN brand b on i.brand_id = b.id
JOIN category c on i.category_id = c.id
WHERE i.id
        NOT IN (SELECT sc.item_id FROM shop_catalog sc
                               JOIN shop s on sc.shop_id = s.id WHERE s.id = ?)";
        }


        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $shop_id);
        $stmt->execute();


        if ($this->conn->errno == 0) {

            $stmtResult = $stmt->get_result();

            while ($assoc_result = $stmtResult->fetch_assoc()) {

                $category['id'] = utf8_encode($assoc_result['cat_id']);
                $category['name'] = utf8_encode($assoc_result['cat_name']);

                $brand ['id'] = utf8_encode($assoc_result['brand_id']);
                $brand ['name'] = utf8_encode($assoc_result['brand_name']);
                $brand ['description'] = utf8_encode($assoc_result['brand_desc']);

                $item['id'] = utf8_encode($assoc_result['item_id']);
                $item['name'] = utf8_encode($assoc_result['item_name']);
                $item['description'] = utf8_encode($assoc_result['item_desc']);
                $item['category'] = $category;
                $item['brand'] = $brand;
//                $item['isChecked'] = false;

                $allItem[] = $item;
            }
            $this->responseObject->setStatusSuccessWithMessage("Success Retrieve Item List By Shop ID");
            $this->responseObject->setQueryResult($allItem);
        } else {
            $this->responseObject->setStatusFailWithMessage($this->conn->error);
        }
        $stmt->close();
        return $this->responseObject;
    }
}