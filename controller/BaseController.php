<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 7/19/2018
 * Time: 4:30 PM
 */
//require_once('..\model
//\ResponseObject.php');

abstract class BaseController
{
    protected $conn;
    protected $table_name;
    protected $responseObject;

    public function __construct(mysqli $conn, string $table_name)
    {
        $this->conn = $conn;
        $this->table_name = $table_name;
        $this->responseObject = new ResponseObject();
    }

    /*CREATE*/
    abstract public function createNew($param);

    /*RETRIEVE*/
    abstract public function retrieveAll();

    /*UPDATE*/
    abstract public function updateById($param, $id);

    /*DELETE*/
    abstract public function deleteById($id);

    /**
     * @return mysqli
     */
    public function getConn(): mysqli
    {
        return $this->conn;
    }

    /**
     * @param mysqli $conn
     */
    public function setConn(mysqli $conn): void
    {
        $this->conn = $conn;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table_name;
    }

    /**
     * @param string $table_name
     */
    public function setTableName(string $table_name): void
    {
        $this->table_name = $table_name;
    }

    /**
     * @return mixed
     */
    public function getResponseObject(): ResponseObject
    {
        return $this->responseObject;
    }

    /**
     * @param mixed $responseObject
     */
    public function setResponseObject(ResponseObject $responseObject): void
    {
        $this->responseObject = $responseObject;
    }
}