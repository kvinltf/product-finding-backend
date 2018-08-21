<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/17/2018
 * Time: 2:57 PM
 */

require_once 'Shop.php';
require_once 'Item.php';

class Catalog
{
    private $shop;
    private $item;

    /**
     * Catalog constructor.
     * @param $shop
     * @param $item
     */
    public function __construct($shop, $item)
    {
        $this->shop = $shop;
        $this->item = $item;
    }

    /**
     * @return mixed
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * @param mixed $shop
     */
    public function setShop($shop): void
    {
        $this->shop = $shop;
    }

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $item
     */
    public function setItem($item): void
    {
        $this->item = $item;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    public function toJson(){
        return json_encode($this->toArray());
    }
}