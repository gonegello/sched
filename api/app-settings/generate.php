<?php
session_start();

require ('../../models/Config.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$config = new Config();
$id       = isset($_POST['id_gen']) ? $_POST['id_gen']: '';
$actionType = isset($_POST['action_type_gen']) ? $_POST['action_type_gen']: ''; 
$name_gen       = isset($_POST['name_gen']) ? $_POST['name_gen']: '';
$city_id      = isset($_POST['city_id']) ? $_POST['city_id']: '';
$prov_id      = isset($_POST['prov_id']) ? $_POST['prov_id']: '';
$brgyy_id      = isset($_POST['brgy_id']) ? $_POST['brgy_id']: '';

// $address = ("{brgyID:$brgyy_id,provCode:$prov_id,cityMunCode:$city_id}");
$address = json_encode(['brgyID' => $brgyy_id, 'provCode' => $prov_id, 'cityMunCode' =>$city_id ]);

$userId     = $_SESSION['SESS_ID'];
$dateTime   = date('Y-m-d H:i:s');

    $data = [
        'name'  => $name_gen,
        'value' => $address,
        'updated_by'    => $userId,
        'updated_at'    => $dateTime
    ];

if($actionType == 'add') {
    $data = array_merge($data, ['created_at' => $dateTime, 'created_by' => $userId]);
}

if($actionType == 'add') {
    $where = " AND name = '$name_gen' ";
    $checkConfig = $config->getWhere($where);

    if(!empty($checkConfig)) {
        echo json_encode(['code' => 2, 'message' => "$name_gen already exist in our database."]);
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