<?php
session_start();
 
require ('../../models/Users.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}
 
$users = new Users();

$id              = isset($_POST['user_id']) ? $_POST['user_id'] : '';   
$actionType      = isset($_POST['action_type']) ? $_POST['action_type']: ''; 
$currentPassword        = isset($_POST['currentPassword']) ? $_POST['currentPassword']: '';
$currentPassword_entered = isset($_POST['currentPassword_entered']) ? $_POST['currentPassword_entered']: '';
$newPassword= isset($_POST['confirmPassword']) ? $_POST['confirmPassword']: '';
$userId     = $_SESSION['SESS_ID'];
$dateTime   = date('Y-m-d H:i:s');

$current_pass_hash = hash('sha512', $currentPassword_entered);

if($current_pass_hash == $currentPassword)
{
$new_pass = hash('sha512', $newPassword);

$data = [
    'password'      => $new_pass,
    'updated_by'    => $userId,
    'updated_at'    => $dateTime
];

}
if($currentPassword != $current_pass_hash)
{
    echo json_encode(['code' => 2, 'message' => "Current Password is Incorrect."]);
    return;
}


if($actionType == 'add') {
    $data = array_merge($data, [
        'password'  => hash('sha512', $password),
        'created_at'=> $dateTime, 
        'created_by'=> $userId]
    );
}

if($actionType == 'delete') {
    $data = array_merge(['status' => 'D','updated_at' => $dateTime, 'updated_by' => $userId]);
}

if($actionType == 'add') {
    $where = " AND username = '$username' ";
    $checkUsers = $users->getWhere($where);

    if(!empty($checkUsers)) {
        echo json_encode(['code' => 2, 'message' => "$username already exist in our database."]);
        return;
    }
}

//Add data
if($actionType == 'add') {
    $resUsers = $users->insertData($data);
} else if($actionType == 'update') {
    $where = " id = $id";
    $resUsers = $users->updateData($data, $where);
} else if($actionType == 'delete') {
    $where = " id = $id";
    $resUsers = $users->updateData($data, $where);
}

if(!$users) {
    echo json_encode(['code' => 1, 'message' => 'Internal error. Please contact administrator.']);
    return;
}

$actionMessage = 'added';
if($actionType == 'update') {
    $actionMessage = 'updated';
} else if($actionType == 'delete') {
    $actionMessage = 'deleted';
}

echo json_encode(['code' => 0, 'message' => 'Password has been successully ' . $actionMessage]);
return;