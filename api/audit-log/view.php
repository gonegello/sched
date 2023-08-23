<?php
session_start();
 
require ('../../models/Logs.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$logs = new Logs();

$id         = isset($_POST['id']) ? $_POST['id'] : ''; 
$actionType = isset($_POST['action_type']) ? $_POST['action_type']: ''; 

$userId     = $_SESSION['SESS_ID'];

$where = "AND l.id = $id";
$reslogs = $logs->getlogs($where);

echo json_encode($reslogs);
return;