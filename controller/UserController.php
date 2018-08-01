<?php
/**
 * This class is to control CRUD of User Class
 */

class UserController
{

    private static $tableName = "user";

    /**
     * Insert new user into Database
     * @param User $user
     * @param mysqli $conn
     * @return string empty string on success or error message on fail
     */
    public static function create(User $user, mysqli $conn)
    {
        $result = '';
        $sql = 'INSERT INTO `user`(`name`, `email`, `password`) VALUES (?,?,?)';

        $stmt = $conn->prepare($sql);
        if (!$stmt)
            $result = 'Prepare Statement Fail: ' . $conn->error;
        else {
            $stmt->bind_param(
                'sss',
                $user->getName(), $user->getEmail(), $user->getPassword());
            if (!$stmt->execute())
                $result = "Statement Execute Fail: " . $stmt->error . PHP_EOL;
        }
        $stmt->close();
        return $result;
    }

    public static function fetchByEmailAndPassword(string $email, string $password, mysqli $conn)
    {
        $result = '';
        $sql = 'SELECT * FROM `user` WHERE `user`.`email` =? AND `user`.`password` = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        $stmt->close();
        return $result;
    }


    /**
     * @param string $email
     * @param mysqli $conn
     * @return bool|User
     * <p>return FALSE if user not found,</p>
     *
     * <p>return User information on Success</p>
     */
    public static function fetchByEmail(string $email, mysqli $conn)
    {
        $sql = 'SELECT * FROM `user` WHERE `user`.`email` =?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);

        if ($stmt->execute()) {
            $re = $stmt->get_result()->fetch_assoc();
            if (isset($re))
                $result = User::fromDatabase($re['id'], $re['name'], $re['email'], $re['password'], $re['created_on']);
            else $result = false;
        } else $result = false;

        $stmt->close();
        return $result;
    }

    /**
     * @param string $email
     * @param string $password
     * @param mysqli $conn
     * @return bool|string
     * <p> return TRUE on Success, FALSE on Failure</p>
     * <p> mysqli Error Message on Error</p>
     */
    public static function updatePassword(string $email, string $password, mysqli $conn)
    {
        $sql = 'UPDATE `user` SET password = ? WHERE email = ?';
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('ss', $password, $email);
            $result = $stmt->execute();
        } else $result = $conn->error;

        return $result;
    }

    public static function fetchAll(mysqli $conn)
    {
        $sql = 'SELECT * FROM ' . self::$tableName;
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $getResult = $stmt->get_result();
        $stmt->close();

        $allUsers = array();

        while ($re = $getResult->fetch_assoc()) {
            $allUsers[] = User::fromDatabase($re['id'], $re['name'], $re['email'], $re['password'], $re['created_on']);
        }

        return $allUsers;
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

}