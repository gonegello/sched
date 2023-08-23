<?php
session_start();

require ('../../models/Class_year.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$class_year = new Class_year();

$id         = isset($_POST['id']) ? $_POST['id'] : ''; 
$actionType = isset($_POST['action_type']) ? $_POST['action_type']: ''; 
$name       = isset($_POST['name']) ? $_POST['name']: '';
$status      = isset($_POST['status']) ? $_POST['status']: '';

$userId     = $_SESSION['SESS_ID'];

$dateTime   = date('Y-m-d H:i:s');
$data = [
    'name'  => $name,
    'status' => $status,
    'updated_by'    => $userId,
    'updated_at'    => $dateTime
];

if($actionType == 'add') {
    $data = array_merge($data, ['created_at' => $dateTime, 'created_by' => $userId]);
}

if($actionType == 'add') {
    $where = " AND name = '$name' ";
    $checkClass_year = $class_year->getWhere($where);

    if(!empty($checkClass_year)) {
        echo json_encode(['code' => 2, 'message' => "$name already exist in our database."]);
        return;
    }
}

if($actionType == 'delete') {
    $data = array_merge( ['status' => 'D', 'created_at' => $dateTime, 'created_by' => $userId]);
    
}


//Add data
if($actionType == 'add') {
    $resClass_year = $class_year->insertData($data);
} else if($actionType == 'update') {
    $where = " id = $id";
    $resClass_year = $class_year->updateData($data, $where);
} else if($actionType == 'delete') {
    $where = " id = $id";
    $resClass_year = $class_year->updateData($data, $where);
}

if(!$class_year) {
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