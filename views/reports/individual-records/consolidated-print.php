<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Individual_records.php');
require (DOCUMENT_ROOT . '../models/Occupations.php');
require (DOCUMENT_ROOT . '../models/Civil_status.php');

 
$helpers = new Helpers();
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$records = new Individual_records();
$occupations = new Occupations();
$config = new Config();
$civil_status = new Civil_status();
$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];
$rescivilstatus = $civil_status->getWhere();


$resRecords = $records->getJoinWhere();
#count male
$resMale = $records->getJoinWhere(" AND p.gender = 'M'");
$male = count($resMale);

$resFemale = $records->getJoinWhere(" AND p.gender = 'F'");
$female = count($resFemale);

$sex_total = (int)$male + (int)$female;

#with summary on age and sex, and common cause of death

#age 0-6
$mm_0_6 = $records->getJoinWhere(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$male_0_6 = count($mm_0_6);

$ff_0_6 = $records->getJoinWhere(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$female_0_6 = count($ff_0_6);

#age 7-12
$mm_7_12 = $records->getJoinWhere(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$male_7_12 = count($mm_7_12);

$ff_7_12 = $records->getJoinWhere(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$female_7_12 = count($ff_7_12);

#age 13-19
$mm_13_19 = $records->getJoinWhere(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$male_13_19 = count($mm_13_19);

$ff_13_19 = $records->getJoinWhere(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$female_13_19 = count($ff_13_19);

#age 20-30
$mm_20_30 = $records->getJoinWhere(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$male_20_30 = count($mm_20_30);

$ff_20_30 = $records->getJoinWhere(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$female_20_30 = count($ff_20_30);

#age 20-30
$mm_31_59 = $records->getJoinWhere(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$male_31_59 = count($mm_31_59);

$ff_31_59 = $records->getJoinWhere(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$female_31_59 = count($ff_31_59);

#age above 60
$mm_60 = $records->getJoinWhere(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 60 AND 100 )");
$male_60 = count($mm_60);

$ff_60 = $records->getJoinWhere(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 60 AND 100 )");
$female_60 = count($ff_60);

$total_female = (int)$female_0_6 + (int)$female_7_12+ (int)$female_13_19 + (int)$female_20_30 + (int)$female_31_59 + (int)$female_60;
$total_male = (int)$male_0_6 + (int)$male_7_12 + (int)$male_13_19 + (int)$male_20_30 + (int)$male_31_59 + (int)$male_60;

$overall_total = $total_female + $total_male;

//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");
$brgysecretary = $brgysec['value'];

//Civil status
$rescivilstatus = $records->getcivilstatuscount();

?> 

<!DOCTYPE html>
<html lang="en">
<?php include_once DOCUMENT_ROOT . '/templates/header-print.php'; ?>
<body>
    <table>
        <tr>
            <td colspan="11" style="text-align: center;border:none;"><h3>CONSOLIDATED INDIVIDUAL RECORD OF BARANGAY INHABITANT</h3></td>
        </tr>

        <tr>
            <td colspan="8" style="text-align: center;border:none;"><h3>       
            </h3></td>
        </tr>

        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
        <tr>
            <td>A. REGION</td>
            <td class="border-bottom b-600"><?php echo $region;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>PROVINCE</td>
            <td class="border-bottom b-600"><?php echo $prov_name;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
 
        </tr>
        <tr>
            <td>MUNICIPALITY</td>
            <td class="border-bottom b-600"><?php echo $municipal_name;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>BARANGAY</td>
            <td class="border-bottom b-600"><?php echo $brgy_name;?></td>
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
            <td rowspan="2" style="text-align:center;width:1%;border:1px solid black;font-weight:bold;">NO.</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" colspan="4" >FULL NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">PUROK</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">AGE</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">PLACE OF BIRTH</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">SEX</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">CIVIL STATUS</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">OCCUPATION</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">CITIZENSHIP</td>


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
            <td style="border:1px solid black;text-align:center;"><?php echo $row['purok'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['age'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['birth_place'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['gender'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['civil_name'];?></td>
            <td style="border:1px solid black;text-align:center;">
            
            <?php
            if (!empty($row['occ_id'])) {
                $occ_results = $occupations->getoccupationname("AND id IN (". $row['occ_id'] . ")");
                 echo $occ_results['name'];
                   
            }
            else{
                echo 'None';
            }  
            ?>    
        </td>
        <td style="border:1px solid black;text-align:center;"><?php echo $row['citi_name'];?></td>

        </tr>                                  
        <?php endforeach; ?>
        
        <tr>
            <td colspan="10" style="color:white;">0</td>
        </tr>
    </table>
    <table style="width: 50%">
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
            <td valign="top" style="padding-left: 50px;">
                <h5>SUMMARY OF CIVIL STATUS</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Name</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                      
                    <?php 
                        $total_c = 0;
                        foreach($rescivilstatus AS $row): 
                        $name = $row['name'];
                        $c_name = $records->getJoinWhere(" AND cs.name = '$name'");
                        $count_c = count($c_name);
                        $total_c += $count_c;
                        ?>
                      
                            <tr>
                                <td>
                                    <?php echo $row['name'];?>
                                </td>
                                <td class="t-center">
                               <?php echo $count_c;?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        <tr>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600">
                            <?php echo $total_c;?>
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