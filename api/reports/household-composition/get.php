<?php
require ('../../../models/Personal_info.php'); 
require ('../../../models/Individual_records.php'); 
require ('../../../inc/Helpers.php');
require ('../../../inc/app_settings.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    echo json_encode(['code' => 4, 'message' => 'You are not authorized to access this page']);
    return;
}

$individual_records = new Individual_records();
 

//Helpers
$helpers = new Helpers();

$btnAction  = isset($_POST['action']) ? $_POST['action'] : '';
$age  = isset($_POST['age']) ? $_POST['age'] : '';
$gender  = isset($_POST['gender']) ? $_POST['gender'] : '';
$house_size  = isset($_POST['house_size']) ? $_POST['house_size'] : '';

$params = $columns = $totalRecords = $data = [];
 
$params = $_REQUEST;
$urlFormer = '';

if(in_array($btnAction, ['excel', 'print'])) {
    $_SESSION['SESS_GEN_TOKEN'] = rand(10000, 10000000);

    $urlFormer = 'token='. $_SESSION['SESS_GEN_TOKEN'];
}

$columns = ['h.household_no', 'p.first_name', 'p.last_name','created_at'];

$whereCondition = $sqlTot = $sqlRec = '';

if( !empty($params['search']['value']) ) {
    $whereCondition .= " AND ( p.first_name LIKE '%". $params['search']['value'] ."%' )";
    $whereCondition .= " AND ( p.last_name LIKE '%". $params['search']['value'] ."%' )";

    $urlFormer .= '&search_value=' . $params['search']['value'];
}

if($age == '0-6' ) {
    // $whereCondition .= " AND ( p.gender LIKE '%". $gender ."%')";
    $whereCondition .= " AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
    + 0 BETWEEN 0 AND 6 )";
}

$sortBy = 'p.id DESC';

if(isset($params['order'])) {
    $sortBy = $columns[$params['order'][0]['column']]."   ". $params['order'][0]['dir'];
    $urlFormer .= '&sort_by=' . $columns[$params['order'][0]['column']];
    $urlFormer .= '&sort_type=' . $params['order'][0]['dir'];
}

$start  = $params['start'];
$length = $params['length'];

//Get total
$totalRecords = $individual_records->getTotal($whereCondition, $sortBy);

//Get all tsag
$results = $individual_records->getsumarryhousehold($whereCondition, $sortBy, $start, $length);
$data = [];
foreach($results AS $row) {
    // $encryptedId = $helpers->encryptDecrypt($row['id']);
    // $edit_url = $protocol . $_SERVER['HTTP_HOST'] . '/views/households/edit.php?id=' . $encryptedId;
    // $view_url = BASE_URL . '/views/reports/individual-records/print.php?id=' . $encryptedId;
    // $action = '';
    // $action .= '<a class="btn btn-circle btn-sm btn-primary btn-print" data-id="'. $row['id'] .'" data-href="'. $view_url .'"><i class="bi bi-printer"></i></a>';
    // $action .= '';
   
    $data[] = [
        $row['household_no'],
        $row['first_name'],
        $row['age'],
        $row['gender'],
        $row['duplicates'],
        
    ];
  
}

$baseUrl = BASE_URL . '/views/app-settings/'.$btnAction.'.php?' . $urlFormer;

$json_data = [
    "draw"            => intval( $params['draw'] ),   
    "recordsTotal"    => intval( $totalRecords ),  
    "recordsFiltered" => intval($totalRecords),
    "data"            => $data,
    'url'             => $baseUrl
];

echo json_encode($json_data);