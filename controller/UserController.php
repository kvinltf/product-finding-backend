<?php
/**
 * This class is to control CRUD of User Class
 */
require_once 'BaseController.php';

class UserController extends BaseController
{
    public function __construct(mysqli $conn, string $table_name = 'user')
    {
        parent::__construct($conn, $table_name);
    }

    public function createNew($user)
    {

        $name = $user->getName();
        $email = $user->getEmail();
        $password = $user->getPassword();

        $sql = 'INSERT INTO user (`name`, `email`, `password`) VALUES (?,?,?)';

        if ($stmt = $this->conn->prepare($sql)) {

            try {
                if ($stmt->bind_param('sss', $name, $email, $password)) {
                    if ($stmt->execute()) {
                        if ($this->conn->errno == 0)
                            $this->responseObject->setStatusSuccessWithMessage("Success Create User");
                        else {
                            $this->responseObject->setErrorMessage($this->conn->error);
                            $this->responseObject->setStatusFail($this->conn->error);
                        }
                    } else {
                        $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_EXECUTES_QUERY);
                        $this->responseObject->setErrorMessage($stmt->error);
                    }
                } else {
                    $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_STMT_BIND_PARAM);
                    $this->responseObject->setErrorMessage($stmt->error);
                }
            } catch (Exception $e) {
                $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_EXCEPTION);
                $this->responseObject->setErrorMessage($e->getMessage());
                return $this->responseObject;
            } finally {
                $stmt->close();
            }

        } else {
            $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_PREPARE_STMT);
            $this->responseObject->setErrorMessage($this->conn->error);
        }
        return $this->responseObject;
    }

    public function retrieveByEmailAndPassword($email, $password)
    {
        try {
            $sql = 'SELECT * FROM `user` WHERE `user`.`email` =? AND `user`.`password` = ?';

            if ($stmt = $this->conn->prepare($sql)) {

                if ($stmt->bind_param('ss', $email, $password)) {
                    if ($stmt->execute()) {
                        if ($result = $stmt->get_result()->fetch_assoc()) {
                            $this->responseObject->setQueryResult($result);
                            $this->responseObject->setStatusSuccessWithMessage("Success Fetch User");
                        } else {
                            $this->responseObject->setStatusFailWithMessage("No User Found");
                        }

                    } else {
                        $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_EXECUTES_QUERY);
                        $this->responseObject->setErrorMessage($stmt->error);
                    }

                } else {
                    $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_STMT_BIND_PARAM);
                    $this->responseObject->setErrorMessage($stmt->error);
                }
            } else {
                $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_PREPARE_STMT);
                $this->responseObject->setErrorMessage($this->conn->error);
            }
        } catch (Exception $e) {
            $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_EXCEPTION);
            $this->responseObject->setErrorMessage($e->getMessage());
            return $this->responseObject;
        } finally {
            $stmt->close();
        }
        return $this->responseObject;
    }

    public function retrieveAll()
    {
        $sql = 'SELECT * FROM ' . $this->table_name;

        try {
            if ($stmt = $this->conn->prepare($sql)) {
                if ($stmt->execute()) {
                    $stmtResult = $stmt->get_result();
                    while ($resultAssoc = $stmtResult->fetch_assoc()) {
                        $userLists[] = $resultAssoc;
                    }
                    $this->responseObject->setStatusSuccess();
                    $this->responseObject->setQueryResult($userLists);
                } else {
                    $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_EXECUTES_QUERY);
                    $this->responseObject->setErrorMessage($stmt->error);
                }
            } else {
                $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_PREPARE_STMT);
                $this->responseObject->setErrorMessage($this->conn->error);

            }
        } catch (Exception $e) {
            $this->responseObject->setStatusFailWithMessage(ResponseObject::FAIL_EXCEPTION);
            $this->responseObject->setErrorMessage($e->getMessage());
            return $this->responseObject;
        } finally {
            $stmt->close();
        }

        return $this->responseObject;
    }

    public function retrieveByEmail(string $email)
    {
        $sql = 'SELECT * FROM ' . $this->table_name . ' WHERE user.`email` =?';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmtResult = $stmt->get_result()->fetch_assoc();

        if ($this->conn->errno == 0) {
            if (isset($stmtResult)) {
                $this->responseObject->setStatusSuccess();
                $this->responseObject->setQueryResult($stmtResult);
            } else {
                $this->responseObject->setStatusFailWithMessage(ResponseObject::NO_RESULT);
            }
        } else {
            $this->responseObject->setStatusFail();
            $this->responseObject->setErrorMessage($this->conn->error);
            $this->responseObject->setMessage("Error Number: " . $this->conn->errno);
            $this->responseObject->setQueryResult($stmtResult);
        }

        $stmt->close();
        return $this->responseObject;
    }

    public function updatePasswordByEmail(string $email, string $password)
    {
        $sql = '';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ss', $password, $email);
        if ($stmt->execute()) {
            if ($this->conn->errno == 0) {
                $this->responseObject->setStatusSuccessWithMessage("Success Change Password\nPlease Check Your Email");
            } else {
                $this->responseObject->setErrorMessage($this->conn->error);
                $this->responseObject->setStatusFailWithMessage("Error Occur");
            }
            $stmt->close();
        } else {
            $this->responseObject->setStatusFailWithMessage($this->conn->error);
        }
        return $this->responseObject;
    }

    public function updateById($user, $id)
    {
        // TODO: Implement updateById() method.
    }

    public function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }


}