<?php
session_start();

require ('../../models/Classrooms.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$classrooms = new Classrooms();

$id         = isset($_POST['id']) ? $_POST['id'] : ''; 
$actionType = isset($_POST['action_type']) ? $_POST['action_type']: ''; 
$name       = isset($_POST['name']) ? $_POST['name']: '';
$department_id       = isset($_POST['department_id']) ? $_POST['department_id']: '';
$status      = isset($_POST['status']) ? $_POST['status']: '';

$userId     = $_SESSION['SESS_ID'];

$dateTime   = date('Y-m-d H:i:s');
$data = [
    'name'  => $name,
    'department_id'  => $department_id,
    'status' => $status,
    'updated_by'    => $userId,
    'updated_at'    => $dateTime
];

if($actionType == 'add') {
    $data = array_merge($data, ['created_at' => $dateTime, 'created_by' => $userId]);
}

if($actionType == 'add') {
    $where = " AND name = '$name' ";
    $checkClassrooms = $classrooms->getWhere($where);

    if(!empty($checkClassrooms)) {
        echo json_encode(['code' => 2, 'message' => "$name already exist in our database."]);
        return;
    }
}

if($actionType == 'delete') {
    $data = array_merge( ['status' => 'D', 'created_at' => $dateTime, 'created_by' => $userId]);
    
}


//Add data
if($actionType == 'add') {
    $resClassrooms = $classrooms->insertData($data);
} else if($actionType == 'update') {
    $where = " id = $id";
    $resClassrooms = $classrooms->updateData($data, $where);
} else if($actionType == 'delete') {
    $where = " id = $id";
    $resClassrooms = $classrooms->updateData($data, $where);
}

if(!$classrooms) {
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