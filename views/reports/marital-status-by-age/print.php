<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Reports.php');

$helpers = new Helpers();
 
$age = $_GET['age'];
$marital_status = $_GET['marital'];
//$type_val = $_GET['bracket'];
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$records = new Reports();
$config = new Config();
$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];
//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");
$brgysecretary = $brgysec['value'];

if(empty($marital_status))
{
    if($age == '0-6'){
        $resRecords = $records->getJoinWhere("AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");

        //MARRIED
        $mar = $records->getJoinWhere(" AND cs.name = 'Married' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");
        $married = count($mar);
        //SINGLE
        $sing = $records->getJoinWhere(" AND cs.name = 'Single' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");
        $single = count($sing);
        //WIDOWER
        $wid = $records->getJoinWhere(" AND cs.name = 'Widower' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");
        $widower = count($wid);
        //SEPARATED
        $sep = $records->getJoinWhere(" AND cs.name = 'Separated' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");
        $separated = count($sep);

    }
    if($age == '7-12')
    {
        $resRecords = $records->getJoinWhere("AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");

        //MARRIED
        $mar = $records->getJoinWhere(" AND cs.name = 'Married' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $married = count($mar);
        //SINGLE
        $sing = $records->getJoinWhere(" AND cs.name = 'Single' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $single = count($sing);
        //WIDOWER
        $wid = $records->getJoinWhere(" AND cs.name = 'Widower' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $widower = count($wid);
        //SEPARATED
        $sep = $records->getJoinWhere(" AND cs.name = 'Separated' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $separated = count($sep);
    }
    if($age == '13-19'){
        $resRecords = $records->getJoinWhere("AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");

        //MARRIED
        $mar = $records->getJoinWhere(" AND cs.name = 'Married' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $married = count($mar);
        //SINGLE
        $sing = $records->getJoinWhere(" AND cs.name = 'Single' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $single = count($sing);
        //WIDOWER
        $wid = $records->getJoinWhere(" AND cs.name = 'Widower' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $widower = count($wid);
        //SEPARATED
        $sep = $records->getJoinWhere(" AND cs.name = 'Separated' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $separated = count($sep);
    }
    if($age == '20-30'){
        $resRecords = $records->getJoinWhere("AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");

        //MARRIED
        $mar = $records->getJoinWhere(" AND cs.name = 'Married' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $married = count($mar);
        //SINGLE
        $sing = $records->getJoinWhere(" AND cs.name = 'Single' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $single = count($sing);
        //WIDOWER
        $wid = $records->getJoinWhere(" AND cs.name = 'Widower' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $widower = count($wid);
        //SEPARATED
        $sep = $records->getJoinWhere(" AND cs.name = 'Separated' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $separated = count($sep);
    }
    if($age == '31-59'){
        $resRecords = $records->getJoinWhere("AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");

        //MARRIED
        $mar = $records->getJoinWhere(" AND cs.name = 'Married' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $married = count($mar);
        //SINGLE
        $sing = $records->getJoinWhere(" AND cs.name = 'Single' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $single = count($sing);
        //WIDOWER
        $wid = $records->getJoinWhere(" AND cs.name = 'Widower' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $widower = count($wid);
        //SEPARATED
        $sep = $records->getJoinWhere(" AND cs.name = 'Separated' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $separated = count($sep);
    }
    if($age == '60'){
        $resRecords = $records->getJoinWhere("AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");

        //MARRIED
        $mar = $records->getJoinWhere(" AND cs.name = 'Married' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $married = count($mar);
        //SINGLE
        $sing = $records->getJoinWhere(" AND cs.name = 'Single' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $single = count($sing);
        //WIDOWER
        $wid = $records->getJoinWhere(" AND cs.name = 'Widower' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $widower = count($wid);
        //SEPARATED
        $sep = $records->getJoinWhere(" AND cs.name = 'Separated' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $separated = count($sep);
    }
    if(empty($age)){
        $resRecords = $records->getJoinWhere();
        #All Data

        #0-6
            //MARRIED
            $mar_0_6 = $records->getJoinWhere(" AND cs.name = 'Married' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 0 AND 6 )");
            $married_0_6 = count($mar_0_6);
            //SINGLE
            $sing_0_6 = $records->getJoinWhere(" AND cs.name = 'Single' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 0 AND 6 )");
            $single_0_6 = count($sing_0_6);
            //WIDOWER
            $wid_0_6 = $records->getJoinWhere(" AND cs.name = 'Widower' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 0 AND 6 )");
            $widower_0_6 = count($wid_0_6);
            //SEPARATED
            $sep_0_6 = $records->getJoinWhere(" AND cs.name = 'Separated' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 0 AND 6 )");
            $separated_0_6 = count($sep_0_6);


        #7-12
        //MARRIED
        $mar_7_12 = $records->getJoinWhere(" AND cs.name = 'Married' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $married_7_12 = count($mar_7_12);
        //SINGLE
        $sing_7_12 = $records->getJoinWhere(" AND cs.name = 'Single' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $single_7_12 = count($sing_7_12);
        //WIDOWER
        $wid_7_12 = $records->getJoinWhere(" AND cs.name = 'Widower' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $widower_7_12 = count($wid_7_12);
        //SEPARATED
        $sep_7_12 = $records->getJoinWhere(" AND cs.name = 'Separated' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $separated_7_12 = count($sep_7_12);

        #13-19
        $mar_13_19 = $records->getJoinWhere(" AND cs.name = 'Married' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $married_13_19 = count($mar_13_19);
        //SINGLE
        $sing_13_19 = $records->getJoinWhere(" AND cs.name = 'Single' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $single_13_19 = count($sing_13_19);
        //WIDOWER
        $wid_13_19 = $records->getJoinWhere(" AND cs.name = 'Widower' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $widower_13_19 = count($wid_13_19);
        //SEPARATED
        $sep_13_19 = $records->getJoinWhere(" AND cs.name = 'Separated' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $separated_13_19 = count($sep_13_19);

        #20-30
        $mar_20_30 = $records->getJoinWhere(" AND cs.name = 'Married' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $married_20_30 = count($mar_20_30);
        //SINGLE
        $sing_20_30 = $records->getJoinWhere(" AND cs.name = 'Single' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $single_20_30 = count($sing_20_30);
        //WIDOWER
        $wid_20_30 = $records->getJoinWhere(" AND cs.name = 'Widower' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $widower_20_30 = count($wid_20_30);
        //SEPARATED
        $sep_20_30 = $records->getJoinWhere(" AND cs.name = 'Separated' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $separated_20_30 = count($sep_20_30);

        #31-59
        $mar_31_59 = $records->getJoinWhere(" AND cs.name = 'Married' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $married_31_59 = count($mar_31_59);
        //SINGLE
        $sing_31_59 = $records->getJoinWhere(" AND cs.name = 'Single' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $single_31_59 = count($sing_31_59);
        //WIDOWER
        $wid_31_59 = $records->getJoinWhere(" AND cs.name = 'Widower' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $widower_31_59 = count($wid_31_59);
        //SEPARATED
        $sep_31_59 = $records->getJoinWhere(" AND cs.name = 'Separated' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $separated_31_59 = count($sep_31_59);

        #60 Above
        $mar_60 = $records->getJoinWhere(" AND cs.name = 'Married' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $married_60 = count($mar_60);
        //SINGLE
        $sing_60 = $records->getJoinWhere(" AND cs.name = 'Single' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $single_60 = count($sing_60);
        //WIDOWER
        $wid_60 = $records->getJoinWhere(" AND cs.name = 'Widower' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $widower_60 = count($wid_60);
        //SEPARATED
        $sep_60 = $records->getJoinWhere(" AND cs.name = 'Separated' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100)");
        $separated_60 = count($sep_60);

        $allsingle = (int)$single_0_6 + (int)$single_7_12 + (int)$single_13_19 + (int)$single_20_30 + (int)$single_31_59 + (int)$single_60;
        $allmarried = (int)$married_0_6 + (int)$married_7_12 + (int)$married_13_19 + (int)$married_20_30 + (int)$married_31_59 + (int)$married_60;
        $allseparated = (int)$separated_0_6 + (int)$separated_7_12 + (int)$separated_13_19 + (int)$separated_20_30 + (int)$separated_31_59 + (int)$separated_60;
        $allwidower = (int)$widower_0_6 + (int)$widower_7_12 + (int)$widower_13_19 + (int)$widower_20_30 + (int)$widower_31_59 + (int)$widower_60;
    }
    
}

if(!empty($marital_status))
{
    if($age == '0-6')
    {
        $resRecords = $records->getJoinWhere("AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");

        $c_0_6 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");
        $count_0_6 = count($c_0_6);

    }
    if($age == '7-12'){
        $resRecords = $records->getJoinWhere("AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");

        $c_0_7 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $count_0_7 = count($c_0_7);
    }
    if($age == '13-19'){
        $resRecords = $records->getJoinWhere("AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");

        $c_0_13 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $count_0_13 = count($c_0_13);
    }
    if($age == '20-30'){
        $resRecords = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");

        $c_0_20 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $count_0_20 = count($c_0_20);
    }
    if($age == '31-59'){
        $resRecords = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");

        $c_0_31 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $count_0_31 = count($c_0_31);
    }
    if($age == '60'){
        $resRecords = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");

        $c_0_60 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $count_0_60 = count($c_0_60);
    }
    if(empty($age)){
        $resRecords = $records->getJoinWhere(" AND cs.name = '$marital_status'");
        $notemptyMbutemptyAge = count($resRecords);
        #SINGLE
         #0-6
        $si_0 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");
        $single_0 = count($si_0);
         #7-12

         $si_7 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 7 AND 12 )");
         $single_7 = count($si_7);

         #13-19

         $si_13 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 13 AND 19 )");
         $single_13 = count($si_13);
        #20-30
         $si_20 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 20 AND 30 )");
         $single_20 = count($si_20);
         #31-59
         $si_31 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 31 AND 59 )");
         $single_31 = count($si_31);
         #60 above
         $si_60 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 60 AND 100 )");
         $single_60 = count($si_60);

         $all_total = (int)$single_0 + (int)$single_7 + (int)$single_13 + (int)$single_20 + (int)$single_31 + (int)$single_60;
    }   
}




?> 



<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marital Status by Age | PRINT</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/print.css">
    <link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css”/>
</head>
<style>
  body{
font-family: Arial, Helvetica, sans-serif;
    margin:0;
}
table, th, td {
  padding:3px;
  font-size:13px;
  
}
table {
  border-spacing: 0px;
  margin:0;
  border-collapse: collapse;

  
}
td{
    width: 2%; 
}
.border-bottom{
    border-bottom: 1px solid black;
    font-weight: bold;
}
.th-heading {
        text-align: center;
        border:1px solid black;
        font-weight:bold;
        font-size:13px;
    }

    .b-600 {
        font-weight: 600;
    }

    .t-center {
        text-align: center;
    }

    .b-line {
        border:1px solid black;
    }

    td{
        font-size: 13px;
    }

    .households-type {
        border-collapse: collapse;
        border: 1px solid #ccc;
    }

    thead, th {
        font-size: 13px;
    }

    tbody.tbody-households-type > tr > td {
        border: 1px solid #ccc;
    }

    thead.thead-households-type > tr > th {
        border: 1px solid #ccc;
    }
         
</style>
<body>
    <table>
    <tr>
            <td colspan="8" style="text-align: center;border:none;"><h3>MARITAL STATUS OF THE TOTAL POPULATION BY AGE</h3></td>
        </tr>

        <tr>
            <td colspan="8" style="text-align: center;border:none;"><h3>

            <?php
            if(!empty($marital_status) && !empty($age)){
                echo $marital_status; echo " Age : "; echo $age; echo ' )';
            }

            if(empty($marital_status) && empty($age)){
                echo '( All Records )';
            }
            if(!empty($marital_status) && empty($age)){
                echo '( '; echo $marital_status; echo ' : All Age )'; 
            }
            if(empty($marital_status) && !empty($age)){
                if($age == '60')
                {
                    echo '( All Status : 60 years and above )';
                }
                else
                {
                     echo '( All Status : '; echo $age; echo ' years old )';
                }
            }
            ?>
            </h3></td>
        </tr>
    </table>
<table width="23%">
   

   <tr>
       <td colspan="8" style="text-align: center;border:none;"><h3>       
       </h3></td>
   </tr>

   <tr>
       <td colspan="8" style="color:white;border:none;">space</td>
   </tr>
   <tr>
       <td style="">A. REGION</td>
       <td style="" class="border-bottom"><?php echo $region;?></td>
   </tr>
   <tr>
       <td style="">PROVINCE</td>
       <td  style="" class="border-bottom"><?php echo $prov_name;?></td>

   </tr>
   <tr>
       <td style="">MUNICIPALITY</td>
       <td style="" class="border-bottom"><?php echo $municipal_name;?></td>
   </tr>
   <tr>
       <td style="">BARANGAY</td>
       <td  style="" class="border-bottom"><?php echo $brgy_name;?></td>
   </tr>
</table>
    <table>
      
        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
        <tr>
            <td rowspan="2" style="text-align:center;width:1%;border:1px solid black;font-weight:bold;">NO.</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" colspan="4" >FULL NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">MARITAL STATUS</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">AGE</td>

        </tr>
        <tr>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">LAST NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">FIRST NAME</td>
            <td style="text-align:center;border:1px solid black;font-weight:bold;">MIDDLE NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">QUALIFIER</td>
        </tr>

       

        <?php 
        $i = 0;
        foreach($resRecords AS $row): $i++;?>
         <tr>
            <td style="border:1px solid black;text-align:center;"><?php echo $i;?>.</td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['last_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['first_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['middle_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['qualifier'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['civil_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['age'];?></td>
        </tr>
                                        
        <?php endforeach; ?>
        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>

    </table>
    <table style="width:10%;">
        <tr>
            <td valign = "top"></td>
            <h5>MARITAL STATUS SUMMARY BY AGE</h5>
            <table class="households-type" style="width:50%;">
                <thead class="thead-households-type">
                <?php
                if(empty($marital_status))
                {
                    echo '
                    <th>Age</th>
                    <th>Single</th>
                    <th>Married</th>
                    <th>Separated</th>
                    <th>Widower</th>
                    ';
                }
                if(!empty($marital_status))
                {
                    echo '
                    <th>Age</th>
                    <th>'.$marital_status.'</th>
                    ';
                }
        
                ?>
                </thead>

                <tbody class="tbody-households-type">
                    <?php
                        if(!empty($marital_status))
                        {
                            if($age == '0-6')
                            {
                                echo
                                '
                                <tr>
                                <td>0-6 years</td>
                                <td class="t-center">'.$count_0_6.'</td>
                                </tr>
                                '
                                ;
                            }
                        }

                        if(empty($marital_status))
                        {
                            if($age == '0-6')
                            {
                                echo
                                '
                                <tr>
                                <td>0-6 years</td>
                                <td class="t-center">'.$single.'</td>
                                <td class="t-center">'.$married.'</td>
                                <td class="t-center">'.$separated.'</td>
                                <td class="t-center">'.$widower.'</td>
                                </tr>
                                '
                                ;
                            }
                        }
            
                        if(empty($marital_status) && empty($age))
                        {
                            echo
                            '
                            <tr>
                            <td>0-6 years</td>
                            <td class="t-center">'.$single_0_6.'</td>
                            <td class="t-center">'.$married_0_6.'</td>
                            <td class="t-center">'.$separated_0_6.'</td>
                            <td class="t-center">'.$widower_0_6.'</td>
                            </tr>
                            '   
                            ;
                        }

                        if(!empty($marital_status) && empty($age)){
                            echo
                            '
                            <tr>
                            <td>0-6 years</td>
                            <td class="t-center">'.$single_0.'</td>
                            </tr>
                            '
                            ;
                        }
            
                        ?>

                        <?php
                        if(!empty($marital_status))
                        {
                            if($age == '7-12')
                            {
                                echo
                                '
                                <tr>
                                <td>7-12 years</td>
                                <td class="t-center">'.$count_0_7.'</td>
                                </tr>
                                '
                                ;
                            }
                        }

                        if(empty($marital_status))
                            {
                            if($age == '7-12')
                                {
                                    echo
                                    '
                                    <tr>
                                    <td>7-12 years</td>
                                    <td class="t-center">'.$single.'</td>
                                    <td class="t-center">'.$married.'</td>
                                    <td class="t-center">'.$separated.'</td>
                                    <td class="t-center">'.$widower.'</td>
                                    </tr>
                                    '
                                    ;
                                }
                            }

              
           
                        if(empty($marital_status) && empty($age))
                        {
                            echo
                            '
                            <tr>
                            <td>7-12 years</td>
                            <td class="t-center">'.$single_7_12.'</td>
                            <td class="t-center">'.$married_7_12.'</td>
                            <td class="t-center">'.$separated_7_12.'</td>
                            <td class="t-center">'.$widower_7_12.'</td>
                            </tr>
                            '
                            ;
                        }

                        if(!empty($marital_status) && empty($age)){
                            echo
                            '
                            <tr>
                            <td>7-12 years</td>
                            <td class="t-center">'.$single_7.'</td>
                            </tr>
                            '
                            ;
                        }
                    ?>  
                    <?php
                    if(!empty($marital_status))
                    {
                        if($age == '13-19')
                        {
                            echo
                            '
                            <tr>
                            <td>13-19 years</td>
                            <td class="t-center">'.$count_0_13.'</td>
                            </tr>
                            '
                            ;
                        }
                    }

                    if(empty($marital_status))
                            {
                            if($age == '13-19')
                                {
                                    echo
                                    '
                                    <tr>
                                    <td>7-12 years</td>
                                    <td class="t-center">'.$single.'</td>
                                    <td class="t-center">'.$married.'</td>
                                    <td class="t-center">'.$separated.'</td>
                                    <td class="t-center">'.$widower.'</td>
                                    </tr>
                                    '
                                    ;
                                }
                            }
            
                            if(empty($marital_status) && empty($age))
                            {
                                echo
                                '
                                <tr>
                                <td>13-19 years</td>
                                <td class="t-center">'.$single_13_19.'</td>
                                <td class="t-center">'.$married_13_19.'</td>
                                <td class="t-center">'.$separated_13_19.'</td>
                                <td class="t-center">'.$widower_13_19.'</td>
                                </tr>
                                '
                                ;
                            }

                            if(!empty($marital_status) && empty($age)){
                                echo
                                '
                                <tr>
                                <td>13-19 years</td>
                                <td class="t-center">'.$single_13.'</td>
                                </tr>
                                '
                                ;
                            }
                        ?>  
                        <?php
                        if(!empty($marital_status))
                        {
                            if($age == '20-30')
                            {
                                echo
                                '
                                <tr>
                                <td>20-30 years</td>
                                <td class="t-center">'.$count_0_20.'</td>
                                </tr>
                                '
                                ;
                            }
                        }

                        if(empty($marital_status))
                                {
                                if($age == '20-30')
                                    {
                                        echo
                                        '
                                        <tr>
                                        <td>20-30 years</td>
                                        <td class="t-center">'.$single.'</td>
                                        <td class="t-center">'.$married.'</td>
                                        <td class="t-center">'.$separated.'</td>
                                        <td class="t-center">'.$widower.'</td>
                                        </tr>
                                        '
                                        ;
                                    }
                                }
            
                        if(empty($marital_status) && empty($age))
                        {
                            echo
                            '
                            <tr>
                            <td>20-30 years</td>
                            <td class="t-center">'.$single_20_30.'</td>
                            <td class="t-center">'.$married_20_30.'</td>
                            <td class="t-center">'.$separated_20_30.'</td>
                            <td class="t-center">'.$widower_20_30.'</td>
                            </tr>
                            '
                            ;
                        }

                        if(!empty($marital_status) && empty($age)){
                            echo
                            '
                            <tr>
                            <td>20-30 years</td>
                            <td class="t-center">'.$single_20.'</td>
                            </tr>
                            '
                            ;
                        }

                        ?>  
                        <?php
                        if(!empty($marital_status))
                        {
                            if($age == '31-59')
                            {
                                echo
                                '
                                <tr>
                                <td>31-59 years</td>
                                <td class="t-center">'.$count_0_31.'</td>
                                </tr>
                                '
                                ;
                            }
                        }

                        if(empty($marital_status))
                        {
                        if($age == '31-59')
                            {
                                echo
                                '
                                <tr>
                                <td>31-59 years</td>
                                <td class="t-center">'.$single.'</td>
                                <td class="t-center">'.$married.'</td>
                                <td class="t-center">'.$separated.'</td>
                                <td class="t-center">'.$widower.'</td>
                                </tr>
                                '
                                ;
                            }
                        }
    
            
                        if(empty($marital_status) && empty($age))
                        {
                            echo
                            '
                            <tr>
                            <td>31-59 years</td>
                            <td class="t-center">'.$single_31_59.'</td>
                            <td class="t-center">'.$married_31_59.'</td>
                            <td class="t-center">'.$separated_31_59.'</td>
                            <td class="t-center">'.$widower_31_59.'</td>
                            </tr>
                            '
                            ;
                        }

                        if(!empty($marital_status) && empty($age)){
                            echo
                            '
                            <tr>
                            <td>31-59 years</td>
                            <td class="t-center">'.$single_31.'</td>
                            </tr>
                            '
                            ;
                        }

                        ?>  

                        <?php
                        if(!empty($marital_status))
                        {
                            if($age == '60')
                            {
                                echo
                                '
                                <tr>
                                <td>60 years above</td>
                                <td class="t-center">'.$count_0_60.'</td>
                                </tr>
                                '
                                ;
                            }
                        }

                        if(empty($marital_status))
                        {
                            if($age == '60')
                            {
                                echo
                                '
                                <tr>
                                <td>60 years above</td>
                                <td class="t-center">'.$single.'</td>
                                <td class="t-center">'.$married.'</td>
                                <td class="t-center">'.$separated.'</td>
                                <td class="t-center">'.$widower.'</td>
                                </tr>
                                '
                                ;
                            }
                        }
    
           
                        if(empty($marital_status) && empty($age))
                        {
                            echo
                            '
                            <tr>
                            <td >60 years above</td>
                            <td class="t-center">'.$single_60.'</td>
                            <td class="t-center">'.$married_60.'</td>
                            <td class="t-center">'.$separated_60.'</td>
                            <td class="t-center">'.$widower_60.'</td>
                            </tr>
                            '
                            ;
                        }

                        if(!empty($marital_status) && empty($age)){
                            echo
                            '
                            <tr>
                            <td>60 years above</td>
                            <td class="t-center">'.$single_60.'</td>
                            </tr>
                            '
                            ;
                        }

                    ?>   
                    <tr>

                    <?php if (empty($marital_status) && empty($age)) : ?>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600"><?php echo $allsingle;?></td>
                            <td class="t-center b-600"><?php echo $allmarried;?></td>
                            <td class="t-center b-600"><?php echo $allseparated;?></td>
                            <td class="t-center b-600"><?php echo $allwidower;?></td>
                         
                      
                        </tr>  
                    <?php endif;?>

                    <?php if(!empty($marital_status) && empty($age)): ?>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600"><?php echo $notemptyMbutemptyAge;?></td>
                    <?php endif;?>
                            
                    <?php if (empty($marital_status) && !empty($age)): ?>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600"><?php echo $single;?></td>
                            <td class="t-center b-600"><?php echo $married;?></td>
                            <td class="t-center b-600"><?php echo $separated;?></td>
                            <td class="t-center b-600"><?php echo $widower;?></td>
                    <?php endif;?>

                    <?php if(!empty($marital_status) && !empty($age)): ?>
                           <?php if($age == '0-6'): ?>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600"><?php echo $count_0_6;?></td>
                            <?php endif;?>

                            <?php if($age == '7-12'): ?>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600"><?php echo $count_0_7;?></td>
                            <?php endif;?>

                            <?php if($age == '13-19'): ?>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600"><?php echo $count_0_13;?></td>
                            <?php endif;?>

                            <?php if($age == '20-30'): ?>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600"><?php echo $count_0_20;?></td>
                            <?php endif;?>

                            <?php if($age == '31-59'): ?>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600"><?php echo $count_0_31;?></td>
                            <?php endif;?>

                            <?php if($age == '60'): ?>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600"><?php echo $count_0_60;?></td>
                            <?php endif;?>
                    <?php endif;?>
            </tbody>
    </table>
    </td>
        </tr>
    </table>
    <br>
 <br>
    <?php echo $helpers->getsignage($brgysecretary) ?>

</body>
</html>