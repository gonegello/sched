<?php
session_start();

require ('../../models/Users.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}
 
$users = new Users();

$id              = isset($_POST['pass_id']) ? $_POST['pass_id'] : '';   
$actionType      = isset($_POST['action_type_res']) ? $_POST['action_type_res']: ''; 
$first_name      = isset($_POST['first_name_res']) ? $_POST['first_name_res']: '';
$last_name       = isset($_POST['last_name_res']) ? $_POST['last_name_res']: '';
$user_role_id    = isset($_POST['user_role_id_res']) ? $_POST['user_role_id_res']: '';
$username        = isset($_POST['username_res']) ? $_POST['username_res']: '';
$old_pass        = isset($_POST['old_pass']) ? $_POST['old_pass']: '';
// $currentPassword = isset($_POST['currentPassword']) ? $_POST['currentPassword']: '';
$newPassword= isset($_POST['confirmPassword']) ? $_POST['confirmPassword']: '';
$status          = isset($_POST['status_res']) ? $_POST['status_res']: '';
$userId     = $_SESSION['SESS_ID'];
$dateTime   = date('Y-m-d H:i:s');

// $current_pass = hash('sha512', $currentPassword);

// if($old_pass == $current_pass)
// {
$new_pass = hash('sha512', $newPassword);

$data = [
    'first_name'    => $first_name,
    'last_name'     => $last_name,
    'user_role_id'  => $user_role_id,
    'username'      => $username,
    'password'      => $new_pass,
    'status'        => $status,
    'updated_by'    => $userId,
    'updated_at'    => $dateTime
];

// }
// if($old_pass != $current_pass)
// {
//     echo json_encode(['code' => 2, 'message' => "Current Password is Incorrect."]);
//     return;
// }


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

echo json_encode(['code' => 0, 'message' => 'Record has been successully ' . $actionMessage]);
return;