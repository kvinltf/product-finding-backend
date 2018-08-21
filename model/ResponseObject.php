<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 8/12/2018
 * Time: 10:28 PM
 */

class ResponseObject
{
    const NO_DATABASE_CONNECTION = 'No Connection To Database';
    const FAIL_PREPARE_STMT = 'Fail to Prepare SQL statement';
    const FAIL_STMT_BIND_PARAM = 'Fail to Binds variables to a prepared statement as parameter';
    const FAIL_EXECUTES_QUERY = 'Fail Executes a prepared Query';
    const FAIL_EXCEPTION = 'Encounter Exception';
    const NO_RESULT = 'No Result Found';
    const STATUS_SUCCESS = 'Success';
    const STATUS_FAIL = 'Fail';

    private $status;
    private $message;
    private $error_message;

    private $query_result;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatusSuccess(): void
    {
        $this->status = self::STATUS_SUCCESS;
    }


    public function setStatusFail(): void
    {
        $this->status = self::STATUS_FAIL;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * @param mixed $error_message
     */
    public function setErrorMessage($error_message): void
    {
        $this->error_message = $error_message;
    }


    /**
     * @return mixed
     */
    public function getQueryResult()
    {
        return $this->query_result;
    }

    /**
     * @param mixed $query_result
     */
    public function setQueryResult($query_result): void
    {
        $this->query_result = $query_result;
    }

    public function setStatusFailWithMessage(String $message)
    {
        $this->setStatusFail();
        $this->setMessage($message);
    }

    public function setStatusSuccessWithMessage(String $message)
    {
        $this->setStatusSuccess();
        $this->setMessage($message);
    }


    public function toResponseObject()
    {
        return get_object_vars($this);
    }

    public function toJsonResponse()
    {
        return json_encode($this->toResponseObject());
    }

    public function setMessageWithRetrieveCount(int $number)
    {
        $this->setMessage($this->getRetrieveCountToString($number));
    }

    private function getRetrieveCountToString(int $number): string
    {
        return 'Retrieve ' . $number . ' result';
    }
}