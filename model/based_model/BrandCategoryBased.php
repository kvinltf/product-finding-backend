<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/17/2018
 * Time: 3:40 PM
 */

class BrandCategoryBased
{
    private $id;
    private $name;
    private $description;

    /**
     * Brand constructor.
     * @param $name
     * @param $description
     */
    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    public static function fromDatabase($id, $name, $description)
    {
        $brand = new self($name, $description);
        $brand->setId($id);
        return $brand;
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

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return 'ID: ' . $this->getId() .
            ' | Name: ' . $this->getName() .
            ' | Description: ' . $this->getDescription();
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}