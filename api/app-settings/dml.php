<?php
session_start();

require ('../../models/Config.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$config = new Config();

$id         = isset($_POST['id']) ? $_POST['id'] : ''; 
$name       = isset($_POST['name']) ? $_POST['name']: '';
$value      = isset($_POST['value']) ? $_POST['value']: '';
$actionType = isset($_POST['action_type']) ? $_POST['action_type']: ''; 
$userId     = $_SESSION['SESS_ID'];
$dateTime   = date('Y-m-d H:i:s');

    $data = [
        'name'  => $name,
        'value' => $value,
        'updated_by'    => $userId,
        'updated_at'    => $dateTime
    ];

if($actionType == 'add') {
    $data = array_merge($data, ['created_at' => $dateTime, 'created_by' => $userId]);
}

if($actionType == 'add') {
    $where = " AND name = '$name' ";
    $checkConfig = $config->getWhere($where);

    if(!empty($checkConfig)) {
        echo json_encode(['code' => 2, 'message' => "$name already exist in our database."]);
        return;
    }
}

//Add data
if($actionType == 'add') {
    $resConfig = $config->insertData($data);
} else if($actionType == 'update') {
    $where = " id = $id";
    $resConfig = $config->updateData($data, $where);
} else if($actionType == 'delete') {
    $resConfig = $config->delete($id);
}

if(!$config) {
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