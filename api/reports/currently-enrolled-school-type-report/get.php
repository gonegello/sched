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
 
$year = 'Grade 1';
//Helpers
$helpers = new Helpers();

$btnAction  = isset($_POST['action']) ? $_POST['action'] : '';
$grade  = isset($_POST['school_type']) ? $_POST['school_type'] : '';
$sex  = isset($_POST['sex']) ? $_POST['sex'] : '';
$age  = isset($_POST['age']) ? $_POST['age'] : '';

$params = $columns = $totalRecords = $data = [];
 
$params = $_REQUEST;
$urlFormer = '';

if(in_array($btnAction, ['excel', 'print'])) {
    $_SESSION['SESS_GEN_TOKEN'] = rand(10000, 10000000);

    $urlFormer = 'token='. $_SESSION['SESS_GEN_TOKEN'];
}

$columns = ['h.household_no', 'p.first_name', 'p.last_name','created_at'];

$whereCondition = $sqlTot = $sqlRec = '';

if(!empty($params['search']['value']) ) {
    $whereCondition .= " AND ( p.first_name LIKE '%". $params['search']['value'] ."%' )";
    $whereCondition .= " AND ( p.last_name LIKE '%". $params['search']['value'] ."%' )";
    // $whereCondition .= " AND ( educ.grade_year_level LIKE '%". $year ."%' )";
    $urlFormer .= '&search_value=' . $params['search']['value'];
}

if(!empty($grade) || empty($grade)){

    if($sex == 'M' || $sex == 'F' || empty($sex))
    {
        if($age == '0-6')
        {
            $whereCondition .= " AND ( sch.school_type LIKE '%". $grade ."%' )";
            $whereCondition .= " AND ( gender LIKE '%". $sex ."%' )";
            $whereCondition .= " AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
                + 0 BETWEEN 0 AND 6 )";
        }
        if($age == '7-12')
        {
            $whereCondition .= " AND ( sch.school_type LIKE '%". $grade ."%' )";
            $whereCondition .= " AND ( gender LIKE '%". $sex ."%' )";
            $whereCondition .= " AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
                + 0 BETWEEN 7 AND 12 )";
        }
        if($age == '13-19')
        {
            $whereCondition .= " AND ( sch.school_type LIKE '%". $grade ."%' )";
            $whereCondition .= " AND ( gender LIKE '%". $sex ."%' )";
            $whereCondition .= " AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
                + 0 BETWEEN 13 AND 19 )";
        }
        if($age == '20-30')
        {
            $whereCondition .= " AND ( sch.school_type LIKE '%". $grade ."%' )";
            $whereCondition .= " AND ( gender LIKE '%". $sex ."%' )";
            $whereCondition .= " AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
                + 0 BETWEEN 20 AND 30 )";
        }
        if($age == '31-59')
        {
            $whereCondition .= " AND ( sch.school_type LIKE '%". $grade ."%' )";
            $whereCondition .= " AND ( gender LIKE '%". $sex ."%' )";
            $whereCondition .= " AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
                + 0 BETWEEN 31 AND 59 )";
        }
        if($age == '60')
        {
            $whereCondition .= " AND ( sch.school_type LIKE '%". $grade ."%' )";
            $whereCondition .= " AND ( gender LIKE '%". $sex ."%' )";
            $whereCondition .= " AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
                + 0 BETWEEN 60 AND 100 )";
        }
        if(empty($age)){
            $whereCondition .= " AND ( sch.school_type LIKE '%". $grade ."%' )";
            $whereCondition .= " AND ( gender LIKE '%". $sex ."%' )";
        }
        
    }
    
}




$sortBy = 'p.id DESC';

if(isset($params['order'])) {
    $sortBy = $columns[$params['order'][0]['column']]."   ". $params['order'][0]['dir'];
    $urlFormer .= '&sort_by=' . $columns[$params['order'][0]['column']];
    $urlFormer .= '&sort_type=' . $params['order'][0]['dir'];
}

$start  = $params['start'];
$length = $params['length'];

$totalRecords = $individual_records->getTotal($whereCondition, $sortBy);

$results = $individual_records->getJoinSchool($whereCondition, $sortBy, $start, $length);
$data = [];
foreach($results AS $row) {
    $encryptedId = $helpers->encryptDecrypt($row['personal_info_id']);
    $edit_url = $protocol . $_SERVER['HTTP_HOST'] . '/views/households/edit.php?id=' . $encryptedId;
    $view_url = BASE_URL . '/views/reports/individual-records/print.php?id=' . $encryptedId;
    $action = '';
    $action .= '<a class="btn btn-circle btn-sm btn-primary btn-print" data-id="'. $row['personal_info_id'] .'" data-href="'. $view_url .'"><i class="bi bi-printer"></i></a>';
    $action .= '';
   if($row['school_type'] == 'PU'){
       $type = 'Public';
   }else{
       $type = 'Private';
   }
    $data[] = [
        $row['first_name'],
        $row['last_name'],
        $row['middle_name'],
        $type,
        $row['gender'],
        $row['age'],
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