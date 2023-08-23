<?php
require ('../models/Address.php');
require ('../inc/Helpers.php');

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

//Helpers
$helpers = new Helpers();

$cityMun    = new Address('refcitymun');
$barangays  = new Address('refbrgy');

$code = isset($_POST['code']) ? $_POST['code'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';

$sql = "";
if ($type == 'municipality') {
    $resAddress = $cityMun->getWhere(" WHERE provCode = $code ", 'citymunDesc ASC');
} else if ($type == 'barangay') {
    $resAddress = $barangays->getWhere(" WHERE citymunCode = $code", 'brgyDesc ASC');
}

$results = [];
foreach ($resAddress AS $row) {
    $code = ($type == 'municipality') ? (int) $row['citymunCode'] : $row['id'];
    $desc = ($type == 'municipality') ? $row['citymunDesc'] : $row['brgyDesc'];
    $results[] = [
        'code' =>$code,
        'name' => $desc
    ];
}

echo json_encode($results);
return;