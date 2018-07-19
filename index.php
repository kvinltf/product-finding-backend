<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 7/18/2018
 * Time: 4:30 PM
 */

require_once('./Database.php');
require_once('./model/User.php');
require_once('./controller/UserController.php');

echo nl2br("Welcome to Product Finding PHP index" . PHP_EOL);

$conn = Database::getConnection();

if ($conn) {
    echo nl2br("Success Connect to Database" . PHP_EOL);

    $table = "user";
    echo nl2br('Select form table ' . $table . PHP_EOL);

    $newUser = new User($_POST['name'], $_POST['email'], $_POST['password']);

    if ($newUser->getName()) {
        if ($result = UserController::create($newUser, $conn)) {
            echo nl2br($result . PHP_EOL);
        } else echo nl2br('Success : INSERT ' . $newUser->getName() . ' into ' . $table . PHP_EOL);

    } else echo nl2br("The INSERT not triggered" . PHP_EOL);

    echo nl2br("FETCH ALL:" . PHP_EOL);

    if ($allUsers = UserController::fetchAll($conn)) {
        foreach ($allUsers as $u) {
            echo nl2br($u . PHP_EOL);
        }
    } else
        echo nl2br("User is Empty" . PHP_EOL);


    $conn->close();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
</head>
<body>
<form action="./index.php" method="post">
    <table>
        <tr>
            <td>Name:</td>
            <td><input type="text" name="name"></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="email" name="email"></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password"></td>
        </tr>


    </table>
    <button name="submit">Submit</button>
</form>
</body>
</html>
