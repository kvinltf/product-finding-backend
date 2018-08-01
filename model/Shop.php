<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/1/2018
 * Time: 4:26 PM
 */

class Shop
{
    private $id;
    private $name;
    private $lat;
    private $lng;
    private $description;
    private $created_on;

    /**
     * Shop constructor.
     * @param $name
     * @param $lat
     * @param $lng
     * @param $description
     */
    public function __construct($name, $lat, $lng, $description)
    {
        $this->name = $name;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->description = $description;
    }

    public static function fromDatabase($id, $name, $lat, $lng, $description, $created_on)
    {
        $instance = new self($name,$lat,$lng,$description);
        $instance->setId($id);
        $instance->setCreatedOn($created_on);
        return $instance;
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
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng): void
    {
        $this->lng = $lng;
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
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->created_on;
    }

    /**
     * @param mixed $created_on
     */
    public function setCreatedOn($created_on): void
    {
        $this->created_on = $created_on;
    }


    public function __toString()
    {
        return
            "ID: " . $this->getId() .
            " | Name: " . $this->getName() .
            " | Lat: " . $this->getLat() .
            " | Lng: " . $this->getLng() .
            " | Description: " . $this->getDescription() .
            " | Created On: " . $this->getCreatedOn();
    }

    public function toJson()
    {
        return get_object_vars($this);
    }
}