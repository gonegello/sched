<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Reports.php');
require (DOCUMENT_ROOT . '../models/Highest_level_of_education.php');
 
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

$resRecords = $records->getEducationInfo();
$level_of_education = new highest_level_of_education();
$resLevel = $level_of_education->getWhere();
//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");
$brgysecretary = $brgysec['value'];


$male_still = $records->getEducationInfo(" AND p.gender = 'M' AND ed.still_schooling = 'Y'");
$total_male_still = count($male_still);
$female_still = $records->getEducationInfo(" AND p.gender = 'F' AND ed.still_schooling = 'Y'");
$total_female_still = count($female_still);

$still_overall = (int)$total_male_still + (int)$total_female_still;
#with summary on age and sex, and common cause of death

#age 0-6
$mm_0_6 = $records->getEducationInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$male_0_6 = count($mm_0_6);

$ff_0_6 = $records->getEducationInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$female_0_6 = count($ff_0_6);

#age 7-12
$mm_7_12 = $records->getEducationInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$male_7_12 = count($mm_7_12);

$ff_7_12 = $records->getEducationInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$female_7_12 = count($ff_7_12);

#age 13-19
$mm_13_19 = $records->getEducationInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$male_13_19 = count($mm_13_19);

$ff_13_19 = $records->getEducationInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$female_13_19 = count($ff_13_19);

#age 20-30
$mm_20_30 = $records->getEducationInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$male_20_30 = count($mm_20_30);

$ff_20_30 = $records->getEducationInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$female_20_30 = count($ff_20_30);

#age 20-30
$mm_31_59 = $records->getEducationInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$male_31_59 = count($mm_31_59);

$ff_31_59 = $records->getEducationInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$female_31_59 = count($ff_31_59);

#age above 60
$mm_60 = $records->getEducationInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 60 AND 100 )");
$male_60 = count($mm_60);

$ff_60 = $records->getEducationInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
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
    <title>Education Information Report (Consolidated) | PRINT</title>
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
            <td colspan="14" style="text-align: center;border:none;"><h3>CONSOLIDATED EDUCATION INFORMATION REPORT</h3></td>
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
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:5%;" rowspan="2">AGE</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:5%;" rowspan="2">SEX</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:10%;" rowspan="2">HIGHEST ATTAINMENT</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:10%;" rowspan="2">STILL SCHOOLING - SCHOOL LEVEL</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:10%;" rowspan="2">SCHOOL NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:5%;" rowspan="2">SCHOOL TYPE</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:10%;" rowspan="2">LOCATION TYPE - ADDRESS</td>
            


        </tr>
        <tr>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:10%;">LAST NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;width:10%;">FIRST NAME</td>
            <td style="text-align:center;border:1px solid black;font-weight:bold;width:10%;">MIDDLE NAME</td>
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
            <td style="border:1px solid black;text-align:center;"><?php echo $row['highest_level'];?></td>
            <td style="border:1px solid black;text-align:center;">
            <?php
            if($row['still_schooling'] == 'Y')
            {
                echo $row['grade_year_level'];
            }
            else{
                echo 'No';
            }

            ?>
            </td>
            <td style="border:1px solid black;"><?php echo $row['school_name'];?></td>
            <td style="border:1px solid black;">
            <?php
            if($row['school_type'] == 'PU')
            {
                    echo 'Public';
            }
            else{
                echo 'Private';
            }
            ?>
            </td>
            <td style="border:1px solid black;">
            <?php
            if($row['location_type'] == 'L')
            {
                echo 'Local';
            }
            if($row['location_type'] == 'A')
            {
                echo 'Abroad - '; echo $row['address_for_abroad'];
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
                <h5>LEVEL OF EDUCATION</h5>
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
                        foreach($resLevel AS $row): 
                        $name = $row['name'];
                        $re_male = $records->getEducationInfo(" AND hloe.name = '$name' AND p.gender = 'M'");
                        $remale_total = count($re_male);    
                        $re_female = $records->getEducationInfo(" AND hloe.name = '$name' AND p.gender = 'F'");
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
                <h5>STILL SCHOOLING</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Male</th>
                            <th>Female</th>                              
                            <th>TOTAL</th>                              
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                   
                            <tr>
                                <td class="t-center">
                                <?php echo $overall_male;?>
                                </td>
                                <td class="t-center">
                                <?php echo $overall_female;?>
                                </td>
                                <td class="t-center">
                                <?php echo $overall_line;?>
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