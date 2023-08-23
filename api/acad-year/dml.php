<?php
session_start();

require ('../../models/Academic_year.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$acad_year = new Academic_year();

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
    $checkacad_year = $acad_year->getWhere($where);

    if(!empty($checkacad_year)) {
        echo json_encode(['code' => 2, 'message' => "$name already exist in our database."]);
        return;
    }
}

if($actionType == 'delete') {
    $data = array_merge( ['status' => 'D', 'created_at' => $dateTime, 'created_by' => $userId]);
    
}


//Add data
if($actionType == 'add') {
    $resacad_year = $acad_year->insertData($data);
} else if($actionType == 'update') {
    $where = " id = $id";
    $resacad_year = $acad_year->updateData($data, $where);
} else if($actionType == 'delete') {
    $where = " id = $id";
    $resacad_year = $acad_year->updateData($data, $where);
}

if(!$acad_year) {
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