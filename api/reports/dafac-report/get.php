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
$calamity  = isset($_POST['calamity']) ? $_POST['calamity'] : '';
$extent  = isset($_POST['extent']) ? $_POST['extent'] : '';

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
    $whereCondition .= " AND ( p.first_name LIKE '%". $params['search']['value'] ."%' ";
    $whereCondition .= " OR p.last_name LIKE '%". $params['search']['value'] ."%' )";

    $urlFormer .= '&search_value=' . $params['search']['value'];
}


if(!empty($calamity) && !empty($extent)) {
    $whereCondition .= " AND ( c.name LIKE '%". $calamity ."%' )";
    $whereCondition .= " AND ( ex.name LIKE '%". $extent ."%' )";
}
if(empty($calamity) && !empty($extent)) {
    $whereCondition .= " AND ( ex.name LIKE '%". $extent ."%' )";
}
if(!empty($calamity) && empty($extent)) {
    $whereCondition .= " AND ( c.name LIKE '%". $calamity ."%' )";
}


$sortBy = 'daf.id ASC';

if(isset($params['order'])) {
    $sortBy = $columns[$params['order'][0]['column']]."   ". $params['order'][0]['dir'];
    $urlFormer .= '&sort_by=' . $columns[$params['order'][0]['column']];
    $urlFormer .= '&sort_type=' . $params['order'][0]['dir'];
}

$start  = $params['start'];
$length = $params['length'];


$totalRecords = $individual_records->getTotal($whereCondition, $sortBy);


$results = $individual_records->getDafacInfo($whereCondition, $sortBy, $start, $length);
$data = [];
foreach($results AS $row) {
    $data[] = [
        $row['household_no'],
        $row['last_name'],
        $row['first_name'],
        $row['middle_name'],
        $row['calamity_name'],
        $row['extent_of_damage'],
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