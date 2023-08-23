<?php
session_start();

require ('../../models/Instructors.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$instructors = new Instructors();

$id         = isset($_POST['id']) ? $_POST['id'] : ''; 
$actionType = isset($_POST['action_type']) ? $_POST['action_type']: ''; 
$firstname       = isset($_POST['firstname']) ? $_POST['firstname']: '';
$middle_initial       = isset($_POST['middle_initial']) ? $_POST['middle_initial']: '';
$lastname       = isset($_POST['lastname']) ? $_POST['lastname']: '';
$department_id       = isset($_POST['department_id']) ? $_POST['department_id']: '';
$status      = isset($_POST['status']) ? $_POST['status']: '';

$userId     = $_SESSION['SESS_ID'];

$dateTime   = date('Y-m-d H:i:s');
$data = [
    'firstname'         => $firstname,
    'middle_initial'    => $middle_initial,
    'lastname'          => $lastname,
    'department_id'     => $department_id,
    'status'            => $status,
    'updated_by'        => $userId,
    'updated_at'        => $dateTime
];

if($actionType == 'add') {
    $data = array_merge($data, ['created_at' => $dateTime, 'created_by' => $userId]);
}

if($actionType == 'add') {
    $where = " AND firstname = '$firstname' ";
    $where = " AND lastname = '$lastname' ";
    $checkInstructors = $instructors->getWhere($where);

    if(!empty($checkInstructors)) {
        echo json_encode(['code' => 2, 'message' => "$firstname already exist in our database."]);
        return;
    }
}

if($actionType == 'delete') {
    $data = array_merge( ['status' => 'D', 'created_at' => $dateTime, 'created_by' => $userId]);
    
}


//Add data
if($actionType == 'add') {
    $resInstructors = $instructors->insertData($data);
} else if($actionType == 'update') {
    $where = " id = $id";
    $resInstructors = $instructors->updateData($data, $where);
} else if($actionType == 'delete') {
    $where = " id = $id";
    $resInstructors = $instructors->updateData($data, $where);
}

if(!$instructors) {
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