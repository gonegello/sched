<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Reports.php');

$helpers = new Helpers();
$age = $_GET['bracket'];
$sex = $_GET['sex'];
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
#if not empty sex
if(!empty($sex)){

    if(!empty($age))
    {
    if($age == '0-6'){
        $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");

        $count = count($resRecords);
    }
    if($age == '7-12'){
        $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $count = count($resRecords);

    }
    if($age == '13-19'){
        $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $count = count($resRecords);

    }
    if($age == '20-30'){
        $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $count = count($resRecords);

    }
    if($age == '31-59'){
        $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $count = count($resRecords);

    }
    if($age == '60'){
        $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $count = count($resRecords);

    }
    }
    if(empty($age)){
        $resRecords = $records->getJoinWhere(" AND gender = '$sex'");

        #0-6
        $reSult_0_6 = $records->getJoinWhere(" AND gender = '$sex' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");
        $c_0_6 = count($reSult_0_6);

        #7-12
        $reSult_7_12 = $records->getJoinWhere(" AND gender = '$sex' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $c_7_12 = count($reSult_7_12);

        #13-19
        $reSult_13_19 = $records->getJoinWhere(" AND gender = '$sex' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $c_13_19 = count($reSult_13_19);

        #20-30
        $reSult_20_30 = $records->getJoinWhere(" AND gender = '$sex' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $c_20_30 = count($reSult_20_30);

        #31-59
        $reSult_31_59 = $records->getJoinWhere(" AND gender = '$sex' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $c_31_59 = count($reSult_31_59);

        #31-59
        $reSult_60 = $records->getJoinWhere(" AND gender = '$sex' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $c_60 = count($reSult_60);

        $c_total = (int)$c_0_6 + (int)$c_7_12 + (int)$c_13_19 + (int)$c_20_30 + (int)$c_31_59 + (int)$c_60;

    }
}
if(empty($sex))
{
    if(!empty($age))
    {
    if($age == '0-6'){
        $resRecords = $records->getJoinWhere(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");

        $resMale = $records->getJoinWhere(" AND gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");
        $male = count($resMale);
        $resFemale = $records->getJoinWhere(" AND gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 0 AND 6 )");
        $female = count($resFemale);
        $total = (int)$male + (int)$female;
    }
    if($age == '7-12'){
        $resRecords = $records->getJoinWhere(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $count = count($resRecords);
        $resMale = $records->getJoinWhere(" AND gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $male = count($resMale);
        $resFemale = $records->getJoinWhere(" AND gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 7 AND 12 )");
        $female = count($resFemale);
        $total = (int)$male + (int)$female;

    }
    if($age == '13-19'){
        $resRecords = $records->getJoinWhere(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $count = count($resRecords);
        $resMale = $records->getJoinWhere(" AND gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $male = count($resMale);
        $resFemale = $records->getJoinWhere(" AND gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 13 AND 19 )");
        $female = count($resFemale);
        $total = (int)$male + (int)$female;
    }
    if($age == '20-30'){
        $resRecords = $records->getJoinWhere(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $count = count($resRecords);
        $resMale = $records->getJoinWhere(" AND gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $male = count($resMale);
        $resFemale = $records->getJoinWhere(" AND gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 20 AND 30 )");
        $female = count($resFemale);
        $total = (int)$male + (int)$female;
    }
    if($age == '31-59'){
        $resRecords = $records->getJoinWhere(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $count = count($resRecords);
        $resMale = $records->getJoinWhere(" AND gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $male = count($resMale);
        $resFemale = $records->getJoinWhere(" AND gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 31 AND 59 )");
        $female = count($resFemale);
        $total = (int)$male + (int)$female;
    }
    if($age == '60'){
        $resRecords = $records->getJoinWhere(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $count = count($resRecords);
        $resMale = $records->getJoinWhere(" AND gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $male = count($resMale);
        $resFemale = $records->getJoinWhere(" AND gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 60 AND 100 )");
        $female = count($resFemale);
        $total = (int)$male + (int)$female;
    }
    } 
}
if(empty($sex) && empty($age)){
    $resRecords = $records->getJoinWhere();
     //0-6
     $f_0_6 = $records->getJoinWhere(" AND gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
     + 0 BETWEEN 0 AND 6 )");

     $m_0_6 = $records->getJoinWhere(" AND gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
     + 0 BETWEEN 0 AND 6 )");

     $male_0_6 = count($m_0_6);
     $female_0_6 = count($f_0_6);
     $total_0_6 = (int)$male_0_6 + (int)$female_0_6;

     //7-12
     $f_7_12 = $records->getJoinWhere(" AND gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
     + 0 BETWEEN 7 AND 12 )");

     $m_7_12 = $records->getJoinWhere(" AND gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
     + 0 BETWEEN 7 AND 12 )");

     $male_7_12 = count($m_7_12);
     $female_7_12 = count($f_7_12);
     $total_7_12 = (int)$male_7_12 + (int)$female_7_12;

     //13-19
     $f_13_19 = $records->getJoinWhere(" AND gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
     + 0 BETWEEN 13 AND 19 )");

     $m_13_19 = $records->getJoinWhere(" AND gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
     + 0 BETWEEN 13 AND 19 )");

     $male_13_19 = count($m_13_19);
     $female_13_19 = count($f_13_19);
     $total_13_19 = (int)$male_13_19 + (int)$female_13_19;

     //20-30
     $f_20_30 = $records->getJoinWhere(" AND gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
     + 0 BETWEEN 20 AND 30 )");

     $m_20_30 = $records->getJoinWhere(" AND gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
     + 0 BETWEEN 20 AND 30 )");

     $male_20_30 = count($m_20_30);
     $female_20_30 = count($f_20_30);
     $total_20_30 = (int)$male_20_30 + (int)$female_20_30;

     //31-59
     $f_31_59 = $records->getJoinWhere(" AND gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
     + 0 BETWEEN 31 AND 59 )");

     $m_31_59 = $records->getJoinWhere(" AND gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
     + 0 BETWEEN 31 AND 59 )");

     $male_31_59 = count($m_31_59);
     $female_31_59 = count($f_31_59);
     $total_31_59= (int)$male_31_59 + (int)$female_31_59;

     //60 above
     $f_60 = $records->getJoinWhere(" AND gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
     + 0 BETWEEN 60 AND 100 )");

     $m_60 = $records->getJoinWhere(" AND gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
     + 0 BETWEEN 60 AND 100 )");

     $male_60 = count($m_60);
     $female_60 = count($f_60);
     $total_60= (int)$male_60 + (int)$female_60;


     $overall = $total_0_6 + $total_7_12 + $total_13_19 + $total_20_30 + $total_31_59 + $total_60;
     $female_total = (int)$female_0_6 + (int)$female_7_12 + (int)$female_13_19 + 
     (int)$female_20_30 + (int)$female_31_59 + (int)$female_60;
     $male_total = (int)$male_0_6 + (int)$male_7_12 + (int)$male_13_19 + 
     (int)$male_20_30 + (int)$male_31_59 + (int)$male_60;

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Population by sex & age | Print</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/print.css">
    <link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css”/>
</head>
<style>body{
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
            <td colspan="8" style="text-align: center;"><h3>TOTAL POPULATION BY SEX AND AGE</h3><br>
            <?php
            if(empty($age)){
                if(empty($sex))
                {
                    echo '( All Records )';
                }
                if($sex == 'M'){
                    echo '( All Male )';
                }
                if($sex == 'F'){
                    echo '( All Female )';
                }
            }
            if(!empty($age)){
                if($age == '60' && empty($sex))
                {
                    echo '( All Sex  : Age '; echo $age; echo ' Above )';
                }
                if($age != '60' && empty($sex)){
                    echo '( All Sex : Age '; echo $age; echo ' )';
                }
                if($age == '60' && $sex == 'F'){
                    echo '( All Female'; echo ' : Age '; echo $age; echo ' Above )';
                }
                if($age == '60' && $sex == 'M'){
                    echo '( All Male'; echo ' : Age '; echo $age; echo ' Above)';
                }
                if($age != '60' && $sex == 'F'){
                    echo '( All Female'; echo ' : Age '; echo $age; echo ' )';
                }
                if($age != '60' && $sex == 'M'){
                    echo '( All Male'; echo ' : Age '; echo $age; echo ' )';
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
       
       
        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
        <tr>
            <td rowspan="2" style="text-align:center;border:1px solid black;font-weight:bold;">NO.</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" colspan="4" >FULL NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">SEX</td>
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
            <td style="border:1px solid black;text-align:center;"><?php echo $row['gender'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['age'];?></td>
        </tr>
                                        
        <?php endforeach; ?>

        <tr>

        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>

        
    </table>

    <table style="width:50%">
        <tr>
            <td valign="top">
                <h5>SUMMARY BY SEX AND AGE</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <?php
                        if(empty($sex) && empty($age))
                        {
                            echo 
                            '
                            <tr>
                            <th>Age</th>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Count</th>                
                            </tr>
                            ';
                        }
                        if($sex == 'M')
                        {
                            echo 
                            '
                            <tr>
                            <th>Age</th>
                            <th>Male</th>
                            <th>Count</th>                
                            </tr>
                            '
                            ;
                        }
                        if($sex == 'F')
                        {
                            echo 
                            '
                            <tr>
                            <th>Age</th>
                            <th>Female</th>
                            <th>Count</th>                
                            </tr>
                            '
                            ;
                        }
                        if(!empty($age) && empty($sex))
                        {
                            echo 
                            '
                            <tr>
                            <th>Age</th>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Count</th>                
                            </tr>
                            ';

                        }
                        

                        ?>
                        
                    </thead>
                    <tbody class="tbody-households-type">
                       
                    <?php 
                    #all empty
                    if(empty($age) && empty($sex))
                    {
                        echo 
                        '
                        <tr>
                        <td>
                        0-6
                        </td>
                        <td class="t-center">
                        '.$male_0_6.'
                        </td>
                        <td class="t-center">
                        '.$female_0_6.'
                        </td>
                        <td class="t-center">
                        '.$total_0_6.'
                        </td>
                        </tr>

                        <tr>
                        <td>
                        7-12
                        </td>
                        <td class="t-center">
                        '.$male_7_12.'
                        </td>
                        <td class="t-center">
                        '.$female_7_12.'
                        </td>
                        <td class="t-center">
                        '.$total_7_12.'
                        </td>
                        </tr>

                        <tr>
                        <td>
                        13-19
                        </td>
                        <td class="t-center">
                        '.$male_13_19.'
                        </td>
                        <td class="t-center">
                        '.$female_13_19.'
                        </td>
                        <td class="t-center">
                        '.$total_13_19.'
                        </td>
                        </tr>

                        <tr>
                        <td>
                        20-30
                        </td>
                        <td class="t-center">
                        '.$male_20_30.'
                        </td>
                        <td class="t-center">
                        '.$female_20_30.'
                        </td>
                        <td class="t-center">
                        '.$total_20_30.'
                        </td>
                        </tr>

                        <tr>
                        <td>
                        31-59
                        </td>
                        <td class="t-center">
                        '.$male_31_59.'
                        </td>
                        <td class="t-center">
                        '.$female_31_59.'
                        </td>
                        <td class="t-center">
                        '.$total_31_59.'
                        </td>
                        </tr>

                        <tr>
                        <td>
                        Above 60
                        </td>
                        <td class="t-center">
                        '.$male_60.'
                        </td>
                        <td class="t-center">
                        '.$female_60.'
                        </td>
                        <td class="t-center">
                        '.$total_60.'
                        </td>
                        </tr>

                        '


                        ;
                    }

                    if(!empty($sex) && !empty($age))
                    {
                        #if not empty all
                        echo
                        '
                        <tr>
                        <td>
                        '.$age.'
                        </td>
                        <td class="t-center">
                        '.$count.'
                        </td>
                        <td class="t-center">
                        '.$count.'
                        </td>
                        </tr>

                        '
                        ;
                    }

                    if(!empty($age) && empty($sex))
                    {
                        #if not empty age but empty sex
                        echo
                        '
                        <tr>
                        <td>
                        '.$age.'
                        </td>
                        <td class="t-center">
                        '.$male.'
                        </td>
                        <td class="t-center">
                        '.$female.'
                        </td>
                        <td class="t-center">
                        '.$total.'
                        </td>

                        </tr>

                        ';
                    }

                    if(empty($age) && !empty($sex))
                    {
                        echo 
                        '
                        <tr>
                        <td>
                        0-6
                        </td>
                        <td class="t-center">
                        '.$c_0_6.'
                        </td>
                        <td class="t-center">
                        '.$c_0_6.'
                        </td>
                        </tr>

                        <tr>
                        <td>
                        7-12
                        </td>
                        <td class="t-center">
                        '.$c_7_12.'
                        </td>
                        <td class="t-center">
                        '.$c_7_12.'
                        </td>
                        </tr>

                        <tr>
                        <td>
                        13-19
                        </td>
                        <td class="t-center">
                        '.$c_13_19.'
                        </td>
                        <td class="t-center">
                        '.$c_13_19.'
                        </td>
                        </tr>

                        <tr>
                        <td>
                       20-30
                        </td>
                        <td class="t-center">
                        '.$c_20_30.'
                        </td>
                        <td class="t-center">
                        '.$c_20_30.'
                        </td>
                        </tr>

                        <tr>
                        <td>
                        31-59
                        </td>
                        <td class="t-center">
                        '.$c_31_59.'
                        </td>
                        <td class="t-center">
                        '.$c_31_59.'
                        </td>
                        </tr>

                        <tr>
                        <td>
                        31-59
                        </td>
                        <td class="t-center">
                        '.$c_60.'
                        </td>
                        <td class="t-center">
                        '.$c_60.'
                        </td>
                        </tr>
                        '
                        ;
                    }
                    
                    ?>
                           
                       <?php
                       #total
                       if(empty($age) && empty($sex))
                       {
                        echo 
                        '
                        <tr>
                        <td class="b-600">TOTAL</td>
                        <td class="t-center b-600">
                        '.$male_total.'
                        </td>
                        <td class="t-center b-600">
                        '.$female_total.'
                         </td>
                         <td class="t-center b-600">
                        '.$overall.'
                         </td>
                    </tr>
                        ';
                       }

                       if(!empty($sex) && !empty($age))
                       {
                        echo
                        '
                        <tr>
                        <td class="b-600">TOTAL</td>
                        <td class="t-center b-600">
                        '.$count.'
                        </td>
                        <td class="t-center b-600">
                        '.$count.'
                        </td>
                        </tr>
                        ';
                       }

                       if(!empty($age) && empty($sex))
                       {
                        #if not empty age but empty sex
                        echo
                        '
                        <tr>
                        <td class="b-600">TOTAL</td>
                        <td class="t-center b-600">
                        '.$male.'
                        </td>
                        <td class="t-center b-600">
                        '.$female.'
                        </td>
                        <td class="t-center b-600">
                        '.$total.'
                        </td>

                        </tr>

                        ';
                       }

                       if(empty($age) && !empty($sex))
                       {
                        #if not empty age but empty sex
                        echo
                        '
                        <tr>
                        <td class="b-600">TOTAL</td>
                        <td class="t-center b-600">
                        '.$c_total.'
                        </td>
                        <td class="t-center b-600">
                        '.$c_total.'
                        </td>
                        </tr>

                        ';
                       }



                        ?>
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