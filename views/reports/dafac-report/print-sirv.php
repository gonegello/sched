<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Individual_records.php');
require (DOCUMENT_ROOT . '../models/Occupations.php');
require (DOCUMENT_ROOT . '../models/Personal_info.php');
require (DOCUMENT_ROOT . '../models/Dafac.php');
 
$helpers = new Helpers();
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}


$calamity       = $_GET['calamity'];
$config         = new Config();
$records        = new Individual_records();
$occupations    = new Occupations();
$personalinfo   = new Personal_info();
$dafac          = new Dafac();

$brgy_name      = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name      = $_SESSION['SESS_PROV_DESC'];
$region         = $_SESSION['SESS_REG_CODE'];
$joinwhere      = '';
if(empty($calamity)){
    $resRecords = $records->getDafacInfo();
}

if(!empty($calamity)){
    $resRecords = $records->getDafacInfo(" AND c.name = '$calamity'");
    $count = count($resRecords);

    $joinwhere = " AND c.name = '$calamity' ";
}

$resdafacstatus = $dafac->gethousestatus('', $joinwhere);

$resextendofdamage = $dafac->getextendofdamage('', $joinwhere);

#with summary on age and sex, and common cause of death
if(!empty($calamity))
{
#age 0-6
$mm_0_6 = $records->getDafacInfo(" AND p.gender = 'M' AND c.name = '$calamity' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$male_0_6 = count($mm_0_6);

$ff_0_6 = $records->getDafacInfo(" AND p.gender = 'F' AND c.name = '$calamity' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$female_0_6 = count($ff_0_6);

#age 7-12
$mm_7_12 = $records->getDafacInfo(" AND p.gender = 'M' AND c.name = '$calamity' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$male_7_12 = count($mm_7_12);

$ff_7_12 = $records->getDafacInfo(" AND p.gender = 'F' AND c.name = '$calamity' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$female_7_12 = count($ff_7_12);

#age 13-19
$mm_13_19 = $records->getDafacInfo(" AND p.gender = 'M' AND c.name = '$calamity' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$male_13_19 = count($mm_13_19);

$ff_13_19 = $records->getDafacInfo(" AND p.gender = 'F' AND c.name = '$calamity' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$female_13_19 = count($ff_13_19);

#age 20-30
$mm_20_30 = $records->getDafacInfo(" AND p.gender = 'M' AND c.name = '$calamity' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$male_20_30 = count($mm_20_30);

$ff_20_30 = $records->getDafacInfo(" AND p.gender = 'F' AND c.name = '$calamity' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$female_20_30 = count($ff_20_30);

#age 20-30
$mm_31_59 = $records->getDafacInfo(" AND p.gender = 'M' AND c.name = '$calamity' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$male_31_59 = count($mm_31_59);

$ff_31_59 = $records->getDafacInfo(" AND p.gender = 'F' AND c.name = '$calamity' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$female_31_59 = count($ff_31_59);

#age above 60
$mm_60 = $records->getDafacInfo(" AND p.gender = 'M' AND c.name = '$calamity' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 60 AND 100 )");
$male_60 = count($mm_60);

$ff_60 = $records->getDafacInfo(" AND p.gender = 'F' AND c.name = '$calamity' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 60 AND 100 )");
$female_60 = count($ff_60);

$total_female = (int)$female_0_6 + (int)$female_7_12+ (int)$female_13_19 + (int)$female_20_30 + (int)$female_31_59 + (int)$female_60;
$total_male = (int)$male_0_6 + (int)$male_7_12 + (int)$male_13_19 + (int)$male_20_30 + (int)$male_31_59 + (int)$male_60;

$overall_total = $total_female + $total_male;
}

if(empty($calamity))
{
    #age 0-6
$mm_0_6 = $records->getDafacInfo(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$male_0_6 = count($mm_0_6);

$ff_0_6 = $records->getDafacInfo(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$female_0_6 = count($ff_0_6);

#age 7-12
$mm_7_12 = $records->getDafacInfo(" AND p.gender = 'M'  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$male_7_12 = count($mm_7_12);

$ff_7_12 = $records->getDafacInfo(" AND p.gender = 'F'  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$female_7_12 = count($ff_7_12);

#age 13-19
$mm_13_19 = $records->getDafacInfo(" AND p.gender = 'M'  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$male_13_19 = count($mm_13_19);

$ff_13_19 = $records->getDafacInfo(" AND p.gender = 'F'  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$female_13_19 = count($ff_13_19);

#age 20-30
$mm_20_30 = $records->getDafacInfo(" AND p.gender = 'M'  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$male_20_30 = count($mm_20_30);

$ff_20_30 = $records->getDafacInfo(" AND p.gender = 'F'  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$female_20_30 = count($ff_20_30);

#age 20-30
$mm_31_59 = $records->getDafacInfo(" AND p.gender = 'M'  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$male_31_59 = count($mm_31_59);

$ff_31_59 = $records->getDafacInfo(" AND p.gender = 'F'  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$female_31_59 = count($ff_31_59);

#age above 60
$mm_60 = $records->getDafacInfo(" AND p.gender = 'M'  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 60 AND 100 )");
$male_60 = count($mm_60);

$ff_60 = $records->getDafacInfo(" AND p.gender = 'F'  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 60 AND 100 )");
$female_60 = count($ff_60);

$total_female = (int)$female_0_6 + (int)$female_7_12+ (int)$female_13_19 + (int)$female_20_30 + (int)$female_31_59 + (int)$female_60;
$total_male = (int)$male_0_6 + (int)$male_7_12 + (int)$male_13_19 + (int)$male_20_30 + (int)$male_31_59 + (int)$male_60;

$overall_total = $total_female + $total_male;
}

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
    
    }
    table {
    border-spacing: 0px;
    margin:0;
    border-collapse: collapse;
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
</style>
<body>
    <table>
        <tr>
            <td colspan="16" style="text-align: center;border:none;"><h3>DAFAC REPORT</h3></td>
        </tr>
        <tr>
            <td colspan="16" style="text-align: center;border:none;"><h5>       
            <?php
            if(empty($calamity)){
                echo '(All Records)';
            }
            if(!empty($calamity)){
                echo $calamity;
            }

            ?>
            </h5></td>
        </tr>

        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
        <tr>
            <td style="font-size:12px;">A. REGION</td>
            <td style="font-size:12px;" class="border-bottom b-600"><?php echo $region;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="font-size:12px;">PROVINCE</td>
            <td style="font-size:12px;" class="border-bottom b-600"><?php echo $prov_name;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td> 
        </tr>
        <tr>
            <td style="font-size:12px;">MUNICIPALITY</td>
            <td style="font-size:12px;" class="border-bottom b-600"><?php echo $municipal_name;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="font-size:12px;">BARANGAY</td>
            <td style="font-size:12px;" class="border-bottom b-600"><?php echo $brgy_name;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

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
        $hhctr = [];
        foreach($resRecords AS $row): $i++;
            $householdno= $row['household_no'];
            $explode    = explode('-', $householdno);

            $hh = isset($explode[2]) ? $explode[2] : '';             

            //Check if array is not empty
            if(!empty($hhctr)) {
                // Check if household no exist in the array
                if(in_array($householdno, $hhctr)) {
                    // Push household in the array
                    array_push($hhctr, $householdno);
                } else {
                    //Otherwise reset it
                    $hhctr = [];
                }
            }

            if(empty($hhctr)) {
                array_push($hhctr, $householdno);
            }

            $where = " AND family_head_id = " . $row['personal_info_id'];
            $familysize = $personalinfo->gettotalcountmemberperfamilyhead($where);
        ?>
            <tr>
                <td class="b-line t-center">
                    <?php echo $householdno; ?>
                </td>
                <td class="b-line t-center">
                    <?php echo $hh . '.' . count($hhctr) ?>
                </td>
                <td class="b-line">
                    <?php echo $row['last_name'];?>
                </td>
                <td class="b-line">
                    <?php echo $row['first_name'];?>
                </td>
                <td class="b-line">
                    <?php echo $row['middle_name'];?>
                </td>
                <td class="b-line">
                    <?php echo $row['qualifier'];?>
                </td>
                <td class="t-center b-line">
                    <?php echo $familysize ?>
                </td>
                <td class="b-line">
                    <?php echo date('M d, Y', strtotime($row['birthdate'])) ?>
                </td>
                <td class="b-line">
                    <?php echo $row['age']; ?>
                </td>
                <td class="b-line">
                    <?php echo $row['gender']; ?>
                </td>
                <td class="b-line">
                    <?php
                    if (!empty($row['occupations'])) {
                        $occ_results = $occupations->getoccupationname("AND id IN (". $row['occupations'] . ")");
                        echo $occ_results['name'];   
                    } else {
                        echo 'None';
                    }
                    ?>
                </td>
                <td class="b-line">
                    <?php echo $row['monthly_income']; ?>
                </td>
                <td class="b-line">
                    <?php echo $row['house_status']; ?>
                </td>
                <td class="b-line t-center">
                    <?php
                        if(stripos($row['extent_of_damage'], 'Partially') !== false) {
                            echo '&#10003;';
                        }
                    ?>
                </td>
                <td class="b-line t-center">
                    <?php 
                    if(stripos($row['extent_of_damage'], 'Totally') !== false) {
                        echo '&#10003;';
                    }
                ?>
                </td>
                <td class="b-line t-center">
                    <?php echo $row['owner_renter_sharer']; ?>
                </td>
            </tr>                                 
        <?php endforeach; ?>
        
        <tr>
            <td colspan="10" style="color:white;">0</td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td valign="top" style="width: 20%;">
                <table>
                    <tr>
                        <td style="font-weight: bold;" class="t-center" colspan="4">SUMMARY</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px;">AGE</td>
                        <td style="font-size: 13px;">MALE</td>
                        <td style="font-size: 13px;">FEMALE</td>
                        <td style="font-size: 13px;">TOTAL</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px;">0-6 yrs old</td>
                        <td style="font-size: 13px;"><?php echo $male_0_6;?></td>
                        <td style="font-size: 13px;"><?php echo $female_0_6;?></td>
                        <td style="font-size: 13px;"><?php echo (int)$female_0_6 + (int)$male_0_6;?></td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px;">7-12 yrs old</td>
                        <td style="font-size: 13px;"><?php echo $male_7_12;?></td>
                        <td style="font-size: 13px;"><?php echo $female_7_12;?></td>
                        <td style="font-size: 13px;"><?php echo (int)$male_7_12 + (int)$female_7_12;?></td>

                    </tr>
                    <tr>
                        <td style="font-size: 13px;">13-19 yrs old</td>
                        <td style="font-size: 13px;"><?php echo $male_13_19;?></td>
                        <td style="font-size: 13px;"><?php echo $female_13_19;?></td>
                        <td style="font-size: 13px;"><?php echo (int)$female_13_19 + (int)$male_13_19;?></td>

                    </tr>
                    <tr>
                        <td style="font-size: 13px;">20-30 yrs old</td>
                        <td style="font-size: 13px;"><?php echo $male_20_30;?></td>
                        <td style="font-size: 13px;"><?php echo $female_20_30;?></td>
                        <td style="font-size: 13px;"><?php echo (int)$female_20_30 + (int)$male_20_30;?></td>

                    </tr>
                    <tr>
                        <td style="font-size: 13px;">31-59 yrs old</td>
                        <td style="font-size: 13px;"><?php echo $male_31_59;?></td>
                        <td style="font-size: 13px;"><?php echo $female_31_59;?></td>
                        <td style="font-size: 13px;"><?php echo (int)$female_31_59 + (int)$male_31_59;?></td>

                    </tr>
                    <tr>
                        <td style="font-size: 13px;">Above 60 yrs old</td>
                        <td style="font-size: 13px;"><?php echo $male_60;?></td>
                        <td style="font-size: 13px;"><?php echo $female_60;?></td>
                        <td style="font-size: 13px;"><?php echo (int)$female_60 + (int)$male_60;?></td>

                    </tr>
                    <tr>
                        <td></td>
                        <td style="border-top:1px solid black;"><?php echo $total_male;?></td>
                        <td style="border-top:1px solid black;"><?php echo $total_female;?></td>
                        <td style="border-top:1px solid black;"><?php echo $overall_total;?></td>
                    </tr>
                </table>
            </td>
            <td valign="top" style="width: 20%;">        
                <!-- House status -->
                <table>
                    <tr>
                        <td style="font-weight: bold;" class="t-center" colspan="4">STATUS</td>
                    </tr>
                    <?php foreach($resdafacstatus AS $rstatus) : ?>
                    <tr>
                        <td>
                            <?php echo $rstatus['name'] ?>
                        </td>
                        <td>
                            <?php echo $rstatus['total_count'] ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </td>
            <td valign="top" style="width: 20%;">
                <!-- House status -->
                <table>
                    <tr>
                        <td style="font-weight: bold;" class="t-center" colspan="4">EXTENT OF DAMAGE</td>
                    </tr>
                    <?php foreach($resextendofdamage AS $rsdamage) : ?>
                    <tr>
                        <td>
                            <?php echo $rsdamage['name'] ?>
                        </td>
                        <td>
                            <?php echo $rsdamage['total_count'] ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>