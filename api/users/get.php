<?php
require ('../../models/Users.php'); 
require ('../../inc/Helpers.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$users = new Users();

//Helpers
$helpers = new Helpers();

$btnAction  = isset($_POST['action']) ? $_POST['action'] : '';

$params = $columns = $totalRecords = $data = [];
 
$params = $_REQUEST;
$urlFormer = '';

if(in_array($btnAction, ['excel', 'print'])) {
    $_SESSION['SESS_GEN_TOKEN'] = rand(10000, 10000000);

    $urlFormer = 'token='. $_SESSION['SESS_GEN_TOKEN'];
}

$columns = ['first_name','middle_initial', 'last_name', 'user_role_id','department_id','username','password','is_active', 'status', 'created_at'];

$whereCondition = $sqlTot = $sqlRec = '';

if( !empty($params['search']['value']) ) {
    $whereCondition .= " AND ";
    $whereCondition .= " ( first_name LIKE '%". $params['search']['value'] ."%' )";

    $urlFormer .= '&search_value=' . $params['search']['value'];
}

$sortBy = 'id DESC';

if(isset($params['order'])) {
    $sortBy = $columns[$params['order'][0]['column']]."   ". $params['order'][0]['dir'];
    $urlFormer .= '&sort_by=' . $columns[$params['order'][0]['column']];
    $urlFormer .= '&sort_type=' . $params['order'][0]['dir'];
}

$start  = $params['start'];
$length = $params['length'];

//Get total
$totalRecords = $users->getTotal($whereCondition, $sortBy);

//Get all tsag
$results = $users->getJoinWhere($whereCondition, $sortBy, $start, $length);
$data = [];
foreach($results AS $row) {
    $encryptedId = $helpers->encryptDecrypt($row['id']);
  
    $farmersUrl = $protocol . $_SERVER['HTTP_HOST'] . '/views/user-roles/farmers.php?id=' . $encryptedId;
   
    $action = '<a class="btn btn-circle btn-sm btn-primary btn-edit" data-id="'. $row['id'] .'" 
    data-first_name="'. $row['first_name'] .'" data-middle_initial="'. $row['middle_initial'] .'"
    data-last_name="'. $row['last_name'] .'"data-user_role_id="'. $row['user_role_id'] .'"
    data-department_id="'. $row['department_id'] .'"   data-username="'. $row['username'] .'"
    data-password="'. $row['password'] .'" data-is_active="'. $row['is_active'] .'" data-status="'.$row['status'].'"><i class="bi bi-pencil-square"></i></a>';

    $action .= '&nbsp; <a class="btn btn-secondary btn-sm btn-reset"
    data-id="'. $row['id'] .'" data-first_name="'. $row['first_name'] .'"
    data-last_name="'. $row['last_name'] .'"data-user_role_id="'. $row['user_role_id'] .'" data-username="'. $row['username'] .'"
    data-password="'. $row['password'] .'" data-is_active="'. $row['is_active'] .'" data-status="'.$row['status'].'"
    ><i class="bx bx-reset"></i></a>';
    
    $action .= '&nbsp; <a class="btn btn-circle btn-sm btn-danger btn-delete" data-id="'. $row['id'] .'" data-first_name="'. $row['first_name'] .'"
    data-last_name="'. $row['last_name'] .'"data-user_role_id="'. $row['user_role_id'] .'"data-username="'. $row['username'] .'"
    ><i class="bi bi-x"></i></a>';
    
    $is_active = '';
    if($row['is_active'] == 'Y') {
        $is_active = '<i class="bi bi-check"></i>';
    }
    if($row['is_active'] == 'N') {
        $is_active = '<i class="bi bi-x"></i>';
    }
    $status = '';
    if($row['status'] == 'Y') {
        $status = '<i class="bi bi-check"></i>';
    }
    if($row['status'] == 'D') {
        $status = '<i class="bi bi-x"></i>';
    }


    $data[] = [
        $row['first_name'],
        $row['middle_initial'],
        $row['last_name'],
        $row['user_role_name'],
        $row['department_name'],
        $row['username'],
        $status,
        date('M d, Y h:i a', strtotime($row['created_at'])),
        $action,
    ];
}

$baseUrl = $protocol . $_SERVER['HTTP_HOST'] . '/views/app-settings/'.$btnAction.'.php?' . $urlFormer;

$json_data = [
    "draw"            => intval( $params['draw'] ),   
    "recordsTotal"    => intval( $totalRecords ),  
    "recordsFiltered" => intval($totalRecords),
    "data"            => $data,
    'url'             => $baseUrl
];

echo json_encode($json_data);