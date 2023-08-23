<?php
session_start();

require ('../../models/Users.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}
 
$users = new Users();

$id              = isset($_POST['id']) ? $_POST['id'] : '';   
$actionType      = isset($_POST['action_type']) ? $_POST['action_type']: ''; 
$first_name      = isset($_POST['first_name']) ? $_POST['first_name']: '';
$middle_initial      = isset($_POST['middle_initial']) ? $_POST['middle_initial']: '';
$last_name       = isset($_POST['last_name']) ? $_POST['last_name']: '';
$user_role_id    = isset($_POST['user_role_id']) ? $_POST['user_role_id']: '';
$department_id    = isset($_POST['department_id']) ? $_POST['department_id']: '';
$username        = isset($_POST['username']) ? $_POST['username']: '';
$password        = isset($_POST['password']) ? $_POST['password']: '';
$confirmpasswword= isset($_POST['confirm_password']) ? $_POST['confirm_password']: '';
$status          = isset($_POST['status']) ? $_POST['status']: '';

$userId     = $_SESSION['SESS_ID'];
$dateTime   = date('Y-m-d H:i:s');
$data = [
    'first_name'        => $first_name,
    'middle_initial'    => $middle_initial,
    'last_name'         => $last_name,
    'user_role_id'      => $user_role_id,
    'department_id'     => $department_id,
    'username'          => $username,
    'status'            => $status,
    'updated_by'        => $userId,
    'updated_at'        => $dateTime
];

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

if(!$resUsers) {
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