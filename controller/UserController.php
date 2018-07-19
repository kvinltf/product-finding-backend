<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 7/19/2018
 * Time: 4:26 PM
 */

class UserController
{
    /**
     * Insert new user into Database
     * @param User $user
     * @param mysqli $conn
     * @return string empty string if success or error message if fail
     */

    private static $tableName = "user";

    public static function create(User $user, mysqli $conn)
    {
        //$conn = Database::getConnection();
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

    public function read()
    {
        // TODO: Implement read() method.
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