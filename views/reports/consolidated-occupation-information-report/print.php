<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Reports.php');
require (DOCUMENT_ROOT . '../models/Occupations.php');
require (DOCUMENT_ROOT . '../models/Source_Income.php');
require (DOCUMENT_ROOT . '../models/Monthly_income.php');
require (DOCUMENT_ROOT . '../models/Livestocks.php');
require (DOCUMENT_ROOT . '../models/Status_Work_Business.php');
require (DOCUMENT_ROOT . '../models/Employment_status.php');
 
$helpers = new Helpers();
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

$resRecords = $records->getOccupationInfo();
$occupations = new Occupations();
$source_of_income = new Source_Income();
$monthly_income = new Monthly_income();
$livestocks = new Livestocks();
$status_work_business = new Status_Work_Business();
$resWork = $status_work_business->getWhere();
$employment_status = new Employment_status();
$resEmp = $employment_status->getWhere();

//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");
$brgysecretary = $brgysec['value'];

#with summary on age and sex, and common cause of death

#age 0-6
$mm_0_6 = $records->getOccupationInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$male_0_6 = count($mm_0_6);

$ff_0_6 = $records->getOccupationInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$female_0_6 = count($ff_0_6);

#age 7-12
$mm_7_12 = $records->getOccupationInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$male_7_12 = count($mm_7_12);

$ff_7_12 = $records->getOccupationInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$female_7_12 = count($ff_7_12);

#age 13-19
$mm_13_19 = $records->getOccupationInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$male_13_19 = count($mm_13_19);

$ff_13_19 = $records->getOccupationInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$female_13_19 = count($ff_13_19);

#age 20-30
$mm_20_30 = $records->getOccupationInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$male_20_30 = count($mm_20_30);

$ff_20_30 = $records->getOccupationInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$female_20_30 = count($ff_20_30);

#age 20-30
$mm_31_59 = $records->getOccupationInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$male_31_59 = count($mm_31_59);

$ff_31_59 = $records->getOccupationInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$female_31_59 = count($ff_31_59);

#age above 60
$mm_60 = $records->getOccupationInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 60 AND 100 )");
$male_60 = count($mm_60);

$ff_60 = $records->getOccupationInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
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
    <title>Occupation Information Report (Consolidated) | PRINT</title>
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
            <td colspan="14" style="text-align: center;border:none;"><h3>CONSOLIDATED OCCUPATION INFORMATION REPORT</h3></td>
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
            <td rowspan="2" style="text-align:center;width:1%;border:1px solid black;font-weight:bold;">NO.</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" colspan="4" >FULL NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">SEX</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">AGE</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">OCCUPATIONS</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">MAJOR SOURCE OF INCOME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">MONTHLY INCOME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">OTHER SOURCE OF INCOME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">STATUS OF WORK/BUSINESS</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">PLACE OF WORK</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">EMPLOYMENT STATUS</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">BUSINESS</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">LIVESTOCKS</td>
            


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
            <td style="border:1px solid black;text-align:center;">
            <?php
            if (!empty($row['occupations'])) {
                $occ_results = $occupations->getoccupationname("AND id IN (". $row['occupations'] . ")");
                 echo $occ_results['name'];
                   
            }
            else{
                echo 'None';
            }  
            ?>
        </td>

        <td style="border:1px solid black;text-align:center;"><?php echo $row['major_source_income'];?></td>
        <td style="border:1px solid black;text-align:center;"><?php echo $row['monthly_income'];?></td>
        <td style="border:1px solid black;text-align:center;">
            <?php
            if (!empty($row['other_source_of_income'])) {
                $major_res = $source_of_income->getOtherSourceIncome("AND id IN (". $row['other_source_of_income'] . ")");
                 echo $major_res['name'];
                   
            }
            else{
                echo 'None';
            }  
            ?>
        </td>
        <td style="border:1px solid black;text-align:center;"><?php echo $row['status_of_work'];?></td>
        <td style="border:1px solid black;text-align:center;"><?php echo $row['place_of_work'];?></td>
        <td style="border:1px solid black;text-align:center;"><?php echo $row['employment_status'];?></td>
        <td style="border:1px solid black;text-align:center;">
            <?php
            if($row['have_business'] == 'Y')
            {
                echo $row['business_name'];
            }
            else{
                echo 'None';
            }
            ?>
        </td>
        <td style="border:1px solid black;text-align:center;">
            <?php
            if ($row['have_livestock'] == 'Y') {
                $res_lives = $livestocks->getLivestocksname("AND id IN (". $row['livestocks'] . ")");
                 echo $res_lives['name'];
                   
            }
            else{
                echo 'None';
            }  
            ?>
        </td>
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
                <h5>STATUS OF WORK</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Level</th>
                            <th>Male</th>                              
                            <th>Female</th>                              
                            <th>Count</th>                              
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                    <?php 
                        $overall_female = 0;
                        $overall_male = 0;
                        $overall_line = 0;
                        foreach($resWork AS $row): 
                        $name = $row['name'];
                        $re_male = $records->getOccupationInfo(" AND swb.name = '$name' AND p.gender = 'M'");
                        $remale_total = count($re_male);    
                        $re_female = $records->getOccupationInfo(" AND swb.name = '$name' AND p.gender = 'F'");
                        $refemale_total = count($re_female);
                        $line_total = (int)$remale_total + (int)$refemale_total;

                        $overall_male += $remale_total;
                        $overall_female += $refemale_total;
                        $overall_line += $line_total;

                        ?>
                            <tr>
                                <td>
                            <?php echo $row['name'];?>
                                </td>
                                <td class="t-center">
                           <?php echo $remale_total;?>
                                </td>
                                <td class="t-center">
                            <?php echo $refemale_total;?>
                                </td>
                                <td class="t-center">
                             <?php echo $line_total;?>
                                </td>
                            </tr>
                  <?php endforeach;?>
                        <tr>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600">
                         <?php echo $overall_male;?>
                            </td>
                            <td class="t-center b-600">
                            <?php echo $overall_female;?>
                            </td>
                            <td class="t-center b-600">
                            <?php echo $overall_line;?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td valign="top">
                <h5>EMPLOYMENT STATUS</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Level</th>
                            <th>Male</th>                              
                            <th>Female</th>                              
                            <th>Count</th>                              
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                    <?php 
                        $e_overall_female = 0;
                        $e_overall_male = 0;
                        $e_overall_line = 0;
                        foreach($resEmp AS $row_1): 
                        $e_name = $row_1['name'];
                        $e_re_male = $records->getOccupationInfo(" AND es.name = '$e_name' AND p.gender = 'M'");
                        $e_remale_total = count($e_re_male);    
                        $e_re_female = $records->getOccupationInfo(" AND es.name = '$e_name' AND p.gender = 'F'");
                        $e_refemale_total = count($e_re_female);
                        $e_line_total = (int)$e_remale_total + (int)$e_refemale_total;
        
                        $e_overall_male += $e_remale_total;
                        $e_overall_female += $e_refemale_total;
                        $e_overall_line += $e_line_total;

                        ?>
                            <tr>
                                <td>
                            <?php echo $row_1['name'];?>
                                </td>
                                <td class="t-center">
                           <?php echo $e_remale_total;?>
                                </td>
                                <td class="t-center">
                            <?php echo $e_refemale_total;?>
                                </td>
                                <td class="t-center">
                             <?php echo $e_line_total;?>
                                </td>
                            </tr>
                  <?php endforeach;?>
                        <tr>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600">
                         <?php echo $e_overall_male;?>
                            </td>
                            <td class="t-center b-600">
                            <?php echo $e_overall_female;?>
                            </td>
                            <td class="t-center b-600">
                            <?php echo $e_overall_line;?>
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