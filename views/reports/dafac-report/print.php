<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Reports.php');
require (DOCUMENT_ROOT . '../models/Occupations.php');
require (DOCUMENT_ROOT . '../models/Personal_info.php');
require (DOCUMENT_ROOT . '../models/Dafac.php');
 
$helpers = new Helpers();
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$calamity       = $_GET['calamity'];
$extent       = $_GET['extent'];
$config         = new Config();
$records        = new Reports();
$occup          = new Occupations();
//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");

$brgysecretary = $brgysec['value'];
if(empty($calamity)){
    if(empty($extent))
    {
            $resRecords = $records->getDafacInfo();
            $par = $records->getDafacInfo(" AND ex.name = 'Partially'");
            $partially = count($par);
            $tot = $records->getDafacInfo(" AND ex.name = 'Totally'");
            $totally = count($tot);
                    
            #age 0-6
            $mm_0_6 = $records->getDafacInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 0 AND 6 )");
            $male_0_6 = count($mm_0_6);

            $ff_0_6 = $records->getDafacInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 0 AND 6 )");
            $female_0_6 = count($ff_0_6);

            #age 7-12
            $mm_7_12 = $records->getDafacInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 7 AND 12 )");
            $male_7_12 = count($mm_7_12);

            $ff_7_12 = $records->getDafacInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 7 AND 12 )");
            $female_7_12 = count($ff_7_12);

            #age 13-19
            $mm_13_19 = $records->getDafacInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 13 AND 19 )");
            $male_13_19 = count($mm_13_19);

            $ff_13_19 = $records->getDafacInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 13 AND 19 )");
            $female_13_19 = count($ff_13_19);

            #age 20-30
            $mm_20_30 = $records->getDafacInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 20 AND 30 )");
            $male_20_30 = count($mm_20_30);

            $ff_20_30 = $records->getDafacInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 20 AND 30 )");
            $female_20_30 = count($ff_20_30);

            #age 20-30
            $mm_31_59 = $records->getDafacInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 31 AND 59 )");
            $male_31_59 = count($mm_31_59);

            $ff_31_59 = $records->getDafacInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 31 AND 59 )");
            $female_31_59 = count($ff_31_59);

            #age above 60
            $mm_60 = $records->getDafacInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 60 AND 100 )");
            $male_60 = count($mm_60);

            $ff_60 = $records->getDafacInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 60 AND 100 )");
            $female_60 = count($ff_60);

            $total_female = (int)$female_0_6 + (int)$female_7_12+ (int)$female_13_19 + (int)$female_20_30 + (int)$female_31_59 + (int)$female_60;
            $total_male = (int)$male_0_6 + (int)$male_7_12 + (int)$male_13_19 + (int)$male_20_30 + (int)$male_31_59 + (int)$male_60;

            $overall_total = $total_female + $total_male;
    }
    if(!empty($extent))
    {
        $resRecords = $records->getDafacInfo(" AND ex.name = '$extent'");
        $par = $records->getDafacInfo(" AND ex.name = 'Partially'");
            $partially = count($par);
            $tot = $records->getDafacInfo(" AND ex.name = 'Totally'");
            $totally = count($tot);
                
            #age 0-6
            $mm_0_6 = $records->getDafacInfo(" AND ex.name = '$extent' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 0 AND 6 )");
            $male_0_6 = count($mm_0_6);

            $ff_0_6 = $records->getDafacInfo(" AND ex.name = '$extent' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 0 AND 6 )");
            $female_0_6 = count($ff_0_6);

            #age 7-12
            $mm_7_12 = $records->getDafacInfo(" AND ex.name = '$extent' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 7 AND 12 )");
            $male_7_12 = count($mm_7_12);

            $ff_7_12 = $records->getDafacInfo(" AND ex.name = '$extent' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 7 AND 12 )");
            $female_7_12 = count($ff_7_12);

            #age 13-19
            $mm_13_19 = $records->getDafacInfo(" AND ex.name = '$extent' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 13 AND 19 )");
            $male_13_19 = count($mm_13_19);

            $ff_13_19 = $records->getDafacInfo(" AND ex.name = '$extent' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 13 AND 19 )");
            $female_13_19 = count($ff_13_19);

            #age 20-30
            $mm_20_30 = $records->getDafacInfo(" AND ex.name = '$extent' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 20 AND 30 )");
            $male_20_30 = count($mm_20_30);

            $ff_20_30 = $records->getDafacInfo(" AND ex.name = '$extent' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 20 AND 30 )");
            $female_20_30 = count($ff_20_30);

            #age 20-30
            $mm_31_59 = $records->getDafacInfo(" AND ex.name = '$extent' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 31 AND 59 )");
            $male_31_59 = count($mm_31_59);

            $ff_31_59 = $records->getDafacInfo(" AND ex.name = '$extent' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 31 AND 59 )");
            $female_31_59 = count($ff_31_59);

            #age above 60
            $mm_60 = $records->getDafacInfo(" AND ex.name = '$extent' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 60 AND 100 )");
            $male_60 = count($mm_60);

            $ff_60 = $records->getDafacInfo(" AND ex.name = '$extent' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 60 AND 100 )");
            $female_60 = count($ff_60);

            $total_female = (int)$female_0_6 + (int)$female_7_12+ (int)$female_13_19 + (int)$female_20_30 + (int)$female_31_59 + (int)$female_60;
            $total_male = (int)$male_0_6 + (int)$male_7_12 + (int)$male_13_19 + (int)$male_20_30 + (int)$male_31_59 + (int)$male_60;

            $overall_total = $total_female + $total_male;
    }
}

if(!empty($calamity)){
    if(empty($extent))
    {
        $resRecords = $records->getDafacInfo(" AND c.name = '$calamity'");
        $par = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = 'Partially'");
            $partially = count($par);
            $tot = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = 'Totally'");
            $totally = count($tot);

         #age 0-6
         $mm_0_6 = $records->getDafacInfo(" AND c.name = '$calamity' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 0 AND 6 )");
         $male_0_6 = count($mm_0_6);

         $ff_0_6 = $records->getDafacInfo(" AND c.name = '$calamity' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 0 AND 6 )");
         $female_0_6 = count($ff_0_6);

         #age 7-12
         $mm_7_12 = $records->getDafacInfo(" AND c.name = '$calamity' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 7 AND 12 )");
         $male_7_12 = count($mm_7_12);

         $ff_7_12 = $records->getDafacInfo(" AND c.name = '$calamity' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 7 AND 12 )");
         $female_7_12 = count($ff_7_12);

         #age 13-19
         $mm_13_19 = $records->getDafacInfo(" AND c.name = '$calamity' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 13 AND 19 )");
         $male_13_19 = count($mm_13_19);

         $ff_13_19 = $records->getDafacInfo(" AND c.name = '$calamity' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 13 AND 19 )");
         $female_13_19 = count($ff_13_19);

         #age 20-30
         $mm_20_30 = $records->getDafacInfo(" AND c.name = '$calamity' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 20 AND 30 )");
         $male_20_30 = count($mm_20_30);

         $ff_20_30 = $records->getDafacInfo(" AND c.name = '$calamity' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 20 AND 30 )");
         $female_20_30 = count($ff_20_30);

         #age 20-30
         $mm_31_59 = $records->getDafacInfo(" AND c.name = '$calamity' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 31 AND 59 )");
         $male_31_59 = count($mm_31_59);

         $ff_31_59 = $records->getDafacInfo(" AND c.name = '$calamity' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 31 AND 59 )");
         $female_31_59 = count($ff_31_59);

         #age above 60
         $mm_60 = $records->getDafacInfo(" AND c.name = '$calamity' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 60 AND 100 )");
         $male_60 = count($mm_60);

         $ff_60 = $records->getDafacInfo(" AND c.name = '$calamity' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 60 AND 100 )");
         $female_60 = count($ff_60);

         $total_female = (int)$female_0_6 + (int)$female_7_12+ (int)$female_13_19 + (int)$female_20_30 + (int)$female_31_59 + (int)$female_60;
         $total_male = (int)$male_0_6 + (int)$male_7_12 + (int)$male_13_19 + (int)$male_20_30 + (int)$male_31_59 + (int)$male_60;

         $overall_total = $total_female + $total_male;
    }
    if(!empty($extent))
    {
        $resRecords = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent'");
        $par = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = 'Partially'");
            $partially = count($par);
            $tot = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = 'Totally'");
            $totally = count($tot);

         #age 0-6
         $mm_0_6 = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent'AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 0 AND 6 )"); 
         $male_0_6 = count($mm_0_6);

         $ff_0_6 = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 0 AND 6 )");
         $female_0_6 = count($ff_0_6);

         #age 7-12
         $mm_7_12 = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 7 AND 12 )");
         $male_7_12 = count($mm_7_12);

         $ff_7_12 = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 7 AND 12 )");
         $female_7_12 = count($ff_7_12);

         #age 13-19
         $mm_13_19 = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 13 AND 19 )");
         $male_13_19 = count($mm_13_19);

         $ff_13_19 = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 13 AND 19 )");
         $female_13_19 = count($ff_13_19);

         #age 20-30
         $mm_20_30 = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 20 AND 30 )");
         $male_20_30 = count($mm_20_30);

         $ff_20_30 = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 20 AND 30 )");
         $female_20_30 = count($ff_20_30);

         #age 20-30
         $mm_31_59 = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 31 AND 59 )");
         $male_31_59 = count($mm_31_59);

         $ff_31_59 = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 31 AND 59 )");
         $female_31_59 = count($ff_31_59);

         #age above 60
         $mm_60 = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 60 AND 100 )");
         $male_60 = count($mm_60);

         $ff_60 = $records->getDafacInfo(" AND c.name = '$calamity' AND ex.name = '$extent' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
         + 0 BETWEEN 60 AND 100 )");
         $female_60 = count($ff_60);

         $total_female = (int)$female_0_6 + (int)$female_7_12+ (int)$female_13_19 + (int)$female_20_30 + (int)$female_31_59 + (int)$female_60;
         $total_male = (int)$male_0_6 + (int)$male_7_12 + (int)$male_13_19 + (int)$male_20_30 + (int)$male_31_59 + (int)$male_60;

         $overall_total = $total_female + $total_male;
    }
}



$brgy_name      = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name      = $_SESSION['SESS_PROV_DESC'];
$region         = $_SESSION['SESS_REG_CODE'];

?> 


<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAFAC Report | PRINT</title>
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
    <table >
    
            <td colspan="16" style="text-align:center;">
            <h3>DAFAC REPORT</h3> 

            <h5>       
            <?php
            if(empty($calamity)){
                if(!empty($extent)){
                    echo '(All Calamity'; echo ' Records with '; echo $extent; echo ' Damage House)';
                }
                if(empty($extent)){
                    echo '(All Records)';
                }
            }
            if(!empty($calamity)){

                if(!empty($extent))
                {
                    echo '(All '; echo $calamity; echo ' Records with '; echo $extent; echo ' Damage House )';
                }
                if(empty($extent)){
                    echo '(All '; echo $calamity; echo ' Records)';
                }
                
            }

            ?></td>
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
        
        </tr>

        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
        
        <tr>
            <td colspan="8" style="color:white;border:none;">0</td>
        </tr>
        
        <tr>
        <td class="th-heading" rowspan="2">
            H.H
        </td>
        <td class="th-heading" rowspan="2">FAM. #</td>

            <td class="th-heading" rowspan="2">SURNAME</td>
            <td class="th-heading" rowspan="2">FIRSTNAME</td>
            <td class="th-heading" rowspan="2">MIDDLE NAME</td>
            <td class="th-heading" rowspan="2">EXTENSION NAME</td>
            <td class="th-heading" rowspan="2">Family Size</td>
            <td class="th-heading" rowspan="2">BIRTHDATE</td>
            <td class="th-heading" rowspan="2">AGE</td>
            <td class="th-heading" rowspan="2">SEX</td>
            <td class="th-heading" rowspan="2">OCCUPATION</td>
            <td class="th-heading" rowspan="2">MONTHLY INCOME</td>
            <td class="th-heading">STATUS</td>
            <td class="th-heading" colspan="2">HOUSE STATUS/EXTENT OF DAMAGE</td>
            <td class="th-heading" rowspan="2">Owner, renter, sharer</td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:10px;border:1px solid black;">Affected or Affected with house damage</td>
            <td style="text-align:center;font-size:13px;border:1px solid black;">PARTIALLY</td>
            <td style="text-align:center;font-size:13px;border:1px solid black;">TOTALLY</td>
        </tr>

        <?php 
        $i = 0;
        foreach($resRecords AS $row): 
        $h_id = $row['house_hold_id'];
        $size = $records->getRBIcount(" AND p.house_hold_id = $h_id");
        $family_size = count($size);
        $i++;?>
         <tr>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['household_no'];?>.</td>
            <td style="border:1px solid black;text-align:center;"></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['last_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['first_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['middle_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['qualifier'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $family_size;?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['birthdate'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['age'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['gender'];?></td>
            <td style="border:1px solid black;text-align:center;">
            <?php
            if (!empty($row['occupations'])) {
                $occ_res = $occup->getoccupationname("AND id IN (". $row['occupations'] . ")");
                $occ_names = $occ_res['name'];
                 echo $occ_names; 
            }
            else{
                echo 'None';
            }  
            ?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['monthly_income'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['house_status'];?></td>
            <td style="border:1px solid black;text-align:center;">
            <?php 
            if ($row['extent_of_damage'] == 'Partially')
                {
                    echo '<span style="font-size:15px;">/</span>';
                }
            ;?></td>
            <td style="border:1px solid black;text-align:center;"><?php 
            if ($row['extent_of_damage'] == 'Totally')
                {
                    echo '<span style="font-size:15px;">/</span>';
                }
            ;?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['owner_renter_sharer'];?></td>


        </tr>                                  
        <?php endforeach; ?>
      
       
    </table>

    <table style="width:30%">
        <tr>
            <td valign="top">
                <h5>SUMMARY BY SEX AND AGE</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Age</th>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Count</th>                
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                       
                            <tr>
                                <td>
                                0-6
                                </td>
                                <td class="t-center">
                                <?php echo $male_0_6;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female_0_6;?>
                                
                                </td>
                                <td class="t-center">
                                <?php echo (int)$female_0_6 + (int)$male_0_6;?>    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                7-12
                                </td>
                                <td class="t-center">
                                <?php echo $male_7_12;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female_7_12;?>
                                </td>
                                <td class="t-center">
                                <?php echo (int)$male_7_12 + (int)$female_7_12;?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                13-19
                                </td>
                                <td class="t-center">
                                <?php echo $male_13_19;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female_13_19;?>
                                </td>
                                <td class="t-center">
                                <?php echo (int)$female_13_19 + (int)$male_13_19;?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                20-30
                                </td>
                                <td class="t-center">
                                <?php echo $male_20_30;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female_20_30;?>
                                </td>
                                <td class="t-center">
                                <?php echo (int)$female_20_30 + (int)$male_20_30;?>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                31-59
                                </td>
                                <td class="t-center">
                                <?php echo $male_31_59;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female_31_59;?>
                                </td>
                                <td class="t-center">
                                <?php echo (int)$female_31_59 + (int)$male_31_59;?>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                60 above
                                </td>
                                <td class="t-center">
                                <?php echo $male_60;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female_60;?>
                                </td>
                                <td class="t-center">
                                <?php echo (int)$female_60 + (int)$male_60;?>
                                </td>
                            </tr>
                    
                        <tr>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600">
                            <?php echo $total_male;?>
                            </td>
                            <td class="t-center b-600">
                            <?php echo $total_female;?>
                             </td>
                             <td class="t-center b-600">
                             <?php echo $overall_total;?>
                             </td>
                        </tr>
                    </tbody>
                </table>
            </td>

            <?php if ($extent == '') : ?>
            <td valign="top">
                <h5>EXTENT OF DAMAGE</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Partially</th>
                            <th>Totally</th>                              
                            <th>TOTAL</th>                              
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                   
                            <tr>
                                <td class="t-center">
                                <?php echo $partially;?>
                                </td>
                                <td class="t-center">
                                <?php echo $totally;?>
                               
                                </td>
                                <td class="t-center">
                                <?php echo (int)$partially + (int)$totally;?>
                             
                                </td>
                            </tr>
                     
                    </tbody>
                </table>
            </td>
            <?php endif; ?>
        </tr>
    </table>
    <br>
    <br>
    <?php echo $helpers->getsignage($brgysecretary) ?>

            
</body>
</html>