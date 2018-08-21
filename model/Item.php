<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/17/2018
 * Time: 2:57 PM
 */

class Item
{
    private $id;
    private $name;
    private $description;
    private $category;
    private $brand;

    /**
     * Item constructor.
     * @param $name
     * @param $description
     * @param $category
     * @param $brand
     */
    public function __construct($name, $description, Category $category, Brand $brand)
    {
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->brand = $brand;
    }

    public static function fromDatabase($id, $name, $description, Category $category, Brand $brand)
    {
        $item = new self($name, $description, $category, $brand);
        $item->setId($id);

        return $item;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     */
    public function setBrand(Brand $brand): void
    {
        $this->brand = $brand;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

}