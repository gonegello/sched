<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
// require ('../models/Users.php');
require ('../models/Users.bak.php');
require ('../models/Config.php');
require ('../models/Barangay.php');
require ('../models/Academic_year.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$helpers  = new Helpers();
$users  = new users();
$config = new Config();
$barangay  = new Barangay();
$academic_year = new Academic_year();

$userName = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if(empty($userName) || empty($password)) {
    echo json_encode(['code' => 3, 'message' => 'Email and password are required.']);
    return;
}

$password = hash('sha512', $password);

$resCheckUser = $users->checkUser($userName, $password);
$resCheckAcademicYear = $academic_year->getcurrentAcadYear(" AND status = 'Y'");
 
if(empty($resCheckUser)) {
    $params = [
        'userid'    => 0,
        'page'      => 'login',
        'action'    => 'login',
        'log'       => 'User attempt to login. Username: ' . $userName . ' | Password : ' . $_POST['password'],
        'created_at'=> date('Y-m-d H:i:s'),
        'updated_at'=> date('Y-m-d H:i:s')
    ];
    $helpers->logdata($params);
    echo json_encode(['code' => 2, 'message' => 'Invalid username and password.']);
    return;
}

//Get address
$where = " AND name = 'address'";
$resConfig = $config->getWhere($where);
 
//Check if there's an app settings
if (empty($resConfig) ) {
    $params = [
        'userid'    => $resCheckUser['id'],
        'page'      => 'login',
        'action'    => 'login',
        'log'       => 'Internal error. Please contact administrator for the app settings.',
        'created_at'=> date('Y-m-d H:i:s'),
        'updated_at'=> date('Y-m-d H:i:s')
    ];
    $helpers->logdata($params);
    echo json_encode(['code' => 1, 'message' => 'Internal error. Please contact administrator for the app settings.']);
    return;
}

foreach($resConfig AS $row) {
    if($row['name'] == 'address') {
        $obj = json_decode($row['value']);
        $wherebrgy = " AND b.id = $obj->brgyID";
        $resBrgy = $barangay->getAddress($wherebrgy);
        $_SESSION['SESS_BRGY_DESC'] = $resBrgy['brgyDesc'];
        $_SESSION['SESS_CITYMUN_DESC'] = $resBrgy['citymunDesc'];
        $_SESSION['SESS_PROV_DESC'] = $resBrgy['provDesc'];
        $_SESSION['SESS_REG_CODE'] = $resBrgy['regCode'];
    }
}
//get the current academic year


$_SESSION['SESS_AUTH'] = TRUE;
$_SESSION['SESS_ID'] = $resCheckUser['id'];
$_SESSION['SESS_FIRST_NAME'] = $resCheckUser['first_name'];
$_SESSION['SESS_LAST_NAME'] = $resCheckUser['last_name'];
$_SESSION['SESS_USER_ROLE_NAME'] = $resCheckUser['user_role_name'];
$_SESSION['SESS_DEPARTMENT_NAME'] = $resCheckUser['department_name'];
$_SESSION['SESS_DEPARTMENT_ID'] = $resCheckUser['department_id'];
#current academic year
$_SESSION['SESS_ACADEMIC_YEAR'] = $resCheckAcademicYear['name'];

$params = [
    'userid'    => $resCheckUser['id'],
    'page'      => 'login',
    'action'    => 'login',
    'log'       => 'Login successfully.',
    'created_at'=> date('Y-m-d H:i:s'),
    'updated_at'=> date('Y-m-d H:i:s')
];
$helpers->logdata($params);

echo json_encode(['code' => 0, 'message' => 'Successful.']);
return;