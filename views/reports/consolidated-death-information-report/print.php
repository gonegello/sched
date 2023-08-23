<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Reports.php');
require (DOCUMENT_ROOT . '../models/Cause_of_death.php');
 
$helpers = new Helpers();
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$records = new Reports();
$cause_of_death = new Cause_of_death();
$config = new Config();
$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];

$resRecords = $records->getDeathInfo();
$resCauseofDeath = $cause_of_death->getWhere();
//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");

$brgysecretary = $brgysec['value'];
#with summary on age and sex, and common cause of death

#age 0-6
$mm_0_6 = $records->getDeathInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$male_0_6 = count($mm_0_6);

$ff_0_6 = $records->getDeathInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$female_0_6 = count($ff_0_6);

#age 7-12
$mm_7_12 = $records->getDeathInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$male_7_12 = count($mm_7_12);

$ff_7_12 = $records->getDeathInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$female_7_12 = count($ff_7_12);

#age 13-19
$mm_13_19 = $records->getDeathInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$male_13_19 = count($mm_13_19);

$ff_13_19 = $records->getDeathInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$female_13_19 = count($ff_13_19);

#age 20-30
$mm_20_30 = $records->getDeathInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$male_20_30 = count($mm_20_30);

$ff_20_30 = $records->getDeathInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$female_20_30 = count($ff_20_30);

#age 20-30
$mm_31_59 = $records->getDeathInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$male_31_59 = count($mm_31_59);

$ff_31_59 = $records->getDeathInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$female_31_59 = count($ff_31_59);

#age above 60
$mm_60 = $records->getDeathInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 60 AND 100 )");
$male_60 = count($mm_60);

$ff_60 = $records->getDeathInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 60 AND 100 )");
$female_60 = count($ff_60);

$total_female = (int)$female_0_6 + (int)$female_7_12+ (int)$female_13_19 + (int)$female_20_30 + (int)$female_31_59 + (int)$female_60;
$total_male = (int)$male_0_6 + (int)$male_7_12 + (int)$male_13_19 + (int)$male_20_30 + (int)$male_31_59 + (int)$male_60;

$overall_total = $total_female + $total_male;
?> 

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Death Information Report (Consolidated) | PRINT</title>
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
            <td colspan="10" style="text-align: center;border:none;"><h3>CONSOLIDATED DEATH INFORMATION REPORT</h3></td>
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
            <td colspan="8" style="color:white;border:none;">0</td>
        </tr>
        <tr>
            <td rowspan="2" style="text-align:center;border:1px solid black;font-weight:bold;width:1%;">NO.</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" colspan="4" >FULL NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:5%;" rowspan="2">SEX</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:5%;" rowspan="2">AGE</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:10%;" rowspan="2">DATE OF DECEASED</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:15%;" rowspan="2">CAUSE OF DEATH</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:10%;" rowspan="2">BURRIED AT</td>


        </tr>
        <tr>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:15%;">LAST NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:15%;">FIRST NAME</td>
            <td style="text-align:center;border:1px solid black;font-weight:bold;width:15%;">MIDDLE NAME</td>
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
            <td style="border:1px solid black;text-align:center;"><?php echo $row['age'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['gender'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['date_of_deceased'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['cause_of_death'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['burried_at'];?></td>
        </tr>                                  
        <?php endforeach; ?>
        
        <tr>
            <td colspan="10" style="color:white;">0</td>
        </tr>
                                            
    </table>

 

    <table style="width:50%">
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
            <td valign="top">
                <h5>MOST COMMON CAUSE OF DEATH</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Cause</th>
                            <th>Count</th>                              
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                    <?php 
            #disease
            $sum = 0;
                foreach($resCauseofDeath AS $row): 
                $name = $row['name'];
                $re = $records->getDeathInfo(" AND cd.name = '$name'");
                $re_total = count($re);    
                $sum += (int)$re_total;   
        ?>
                            <tr>
                                <td>
                                <?php echo $row['name'];?>
                                </td>
                                <td class="t-center">
                                <?php echo $re_total;?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <tr>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600">
                              <?php echo $sum;?>
                            </td>
                        </tr>
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