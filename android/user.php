<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 7/21/2018
 * Time: 5:53 PM
 */

require_once('../Database.php');
require_once('../model/User.php');
require_once('../controller/UserController.php');

$conn = Database::getConnection();
$data = json_decode(file_get_contents("php://input"));
$action = $data->action;

switch ($action) {
    case 'login':
        $return = UserController::fetchByEmailAndPassword($data->email, $data->password, $conn);
        if (isset($return)) {
            $result['status'] = 'SUCCESS';
            $result['result'] = $return;
        } else {
            $result['status'] = 'FAIL';
            $result['result'] = $return;
        }
        echo json_encode($result);
        break;

    case 'register':
        $user = new User($data->name, $data->email, $data->password);
        $return = UserController::create($user, $conn);
        if ($return != '') {
            $result['status'] = 'FAIL';
            $result['result'] = $return;
        } else {
            $result['status'] = 'SUCCESS';
            $result['result'] = $user->toJson();
        }
        echo json_encode($result);
        break;

    case 'forgetpassword':
        $tmp = UserController::fetchByEmail($data->email, $conn);
        if ($tmp === false) {
            $result['status'] = 'FAIL';
            $result['result'] = 'User Not Found' . PHP_EOL . $data->email;

        } else if (isset($tmp)) {
            $newPass = substr(md5(rand()), 0, 8);
            $updateResult = UserController::updatePassword($data->email, $newPass, $conn);
            if ($updateResult == true) {
                $to = $data->email;
                $subject = "Reset Password for $to";
                $date = date('d F Y h:i A (e)');
                $message =
                    "You have reset the password at $date\nThe new password is: \"$newPass\" (without double quote \" \")";

                if (mail($to, $subject, $message)) {
                    $result['status'] = 'SUCCESS';
                    $result['result'] = 'Success'.PHP_EOL.'Please Check Your Email';
                } else {
                    $result['status'] = 'FAIL';
                    $result['result'] = 'Success Change Password, but Fail to Email User';
                }
            }
        } else {
            $result['status'] = 'FAIL';
            $result['result'] = 'Error on Database Connection';
            $result['error'] = $tmp;
        }
        echo json_encode($result);
        break;
    default:
        $result["status"] = 'FAIL';
        $result['result'] = '';
        $result['data'] = $data;
        $result['action'] = $action;
        echo json_encode($result);
        break;
}