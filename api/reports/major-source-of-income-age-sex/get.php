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
$source  = isset($_POST['source']) ? $_POST['source'] : '';

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

// if(!empty($first_name) && !empty($last_name)) {
//     // $whereCondition .= " ( h.household_no LIKE '%". $params['search']['value'] ."%' )";
//     $whereCondition .= " AND ( p.first_name LIKE '%". $first_name ."%' )";
//     $whereCondition .= " AND ( p.last_name LIKE '%". $last_name ."%' )";
// }
if(!empty($source)) {
    // $whereCondition .= " ( h.household_no LIKE '%". $params['search']['value'] ."%' )";
    $whereCondition .= " AND ( soi.name LIKE '%". $source ."%' )";
    $whereCondition .= " AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 15 AND 100 )";
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
$results = $individual_records->getMonthLy15($whereCondition, $sortBy, $start, $length);
$data = [];
foreach($results AS $row) {
    $encryptedId = $helpers->encryptDecrypt($row['personal_info_id']);
    $edit_url = $protocol . $_SERVER['HTTP_HOST'] . '/views/households/edit.php?id=' . $encryptedId;
    $view_url = BASE_URL . '/views/reports/individual-records/print.php?id=' . $encryptedId;
    $action = '';
    $action .= '<a class="btn btn-circle btn-sm btn-primary btn-print" data-id="'. $row['personal_info_id'] .'" data-href="'. $view_url .'"><i class="bi bi-printer"></i></a>';
    $action .= '';
    $dateOfBirth = $row['birthdate'];
    $today = date("Y-m-d");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    $data[] = [
        $row['first_name'],
        $row['last_name'],
        $row['middle_name'],
        $row['major_source'],
        $row['age'],
        $row['gender'],
        
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