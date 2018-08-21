<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 7/21/2018
 * Time: 5:53 PM
 */

require_once('../initialize.php');
require_once('../model/User.php');
require_once('../model/ResponseObject.php');
require_once('../controller/UserController.php');

$responseObject = new ResponseObject();
$userController = new UserController($conn);
$action = $data->action;

switch ($action) {
    case 'login':
        $responseObject = $userController->retrieveByEmailAndPassword($data->email, $data->password);
        echo $responseObject->toJsonResponse();
        break;

    case 'register':
        $newuser = new User($data->name, $data->email, $data->password);

        $responseObject = $userController->createNew($newuser);
        echo $responseObject->toJsonResponse();
        break;

    case 'forgetpassword':
        $responseObject = $userController->retrieveByEmail($data->email);
        if ($responseObject->getStatus() === ResponseObject::STATUS_FAIL) {
            $responseObject->setMessage("Email Not Found");
            $responseObject->setErrorMessage("Email Not Found");

        } else {
            $newPass = substr(md5(rand()), 0, 8);
            $responseObject = $userController->updatePasswordByEmail($data->email, $newPass);
            if ($responseObject->getStatus() === ResponseObject::STATUS_SUCCESS) {
                $to = $data->email;
                $subject = "Reset Password for $to";
                $date = date('d F Y h:i A (e)');
                $message =
                    "You have reset the password at $date\nThe new password is: \"$newPass\" (without double quote \" \")";

                if (mail($to, $subject, $message)) {
                } else {
                    $msg = 'Success Change Password, but Fail to Email User\nPlease Reset Again';
                    $responseObject->setStatusFailWithMessage($msg);
                }
            }
        }
        echo $responseObject->toJsonResponse();
        break;
    default:
        $responseObject->setStatusFailWithMessage("No Action Found");
        echo $responseObject->toJsonResponse();
        break;
}