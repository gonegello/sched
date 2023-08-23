<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Individual_records.php');
require (DOCUMENT_ROOT . '../models/Personal_info.php');
require (DOCUMENT_ROOT . '../models/House_types.php');
require (DOCUMENT_ROOT . '../models/House_locations.php');
require (DOCUMENT_ROOT . '../models/House_holds.php');
 
$helpers = new Helpers();
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$households = new House_holds();

$house_type = $_GET['house_type'];
$house_location = $_GET['house_location'];
$records = new Individual_records();
$config = new Config();
$personal_info = new Personal_info();
$house_t = new House_types();
$resHousetype = $house_t->getWhere();
$house_l = new House_locations();
$resHouselocation = $house_l->getWhere();
$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];

if(empty($house_location) && empty($house_type)) {
    $resRecords = $records->getsumarryhousehold(" GROUP BY hh.household_no");
}

if(!empty($house_location) && !empty($house_type)) {
    $resRecords = $records->getsumarryhousehold( " AND ht.name = '$house_type' AND hl.name = '$house_location' GROUP BY hh.household_no ");
    
}
if(!empty($house_location) && empty($house_type)) {
    $resRecords = $records->getsumarryhousehold( " AND hl.name = '$house_location'  GROUP BY hh.household_no");
    
}

if(empty($house_location) && !empty($house_type)) {
    $resRecords = $records->getsumarryhousehold( " AND ht.name = '$house_type'  GROUP BY hh.household_no");
    
}

//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");

$brgysecretary = $brgysec['value'];

$reshouseholdcount = $households->gethouseholdcount();
$reshouseholdlocationcount = $households->gethouseholdlocationcount();

?> 

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUMMARY OF HOUSEHOLD TYPE AND HOUSE LOCATION | PRINT</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/print.css">
    <link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css”/>
</head>
<style>
    body{
        font-family: Arial, Helvetica, sans-serif;        
        margin:0;
        font-size: 13px;
    }

    table, th, td {       
        padding:3px;
    }
    table {
        border-spacing: 0px;
        margin:0;
        border-collapse: collapse;
    }

    .border-bottom{
        border-bottom:1px solid black;
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
    <table style="width: 100%;">
        <tr>
            <td colspan="7" style="text-align: center;border:none;"><h3>SUMMARY OF HOUSEHOLD TYPE AND HOUSE LOCATION</h3></td>
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
    <table style="width: 100%;">
        <tr>
            <td colspan="8" style="color:white;border:none;">0</td>
        </tr>
        <tr>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">HOUSE NO.</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">NAME OF HOUSEHOLD HEAD</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">AGE</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">SEX</td>
            <td style="text-align:center;border:1px solid black;font-weight:bold;">HOUSEHOLD SIZE</td>
            <td style="text-align:center;border:1px solid black;font-weight:bold;">NO. HOUSEHOLD HEAD</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">HOUSEHOLD TYPE</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">HOUSEHOLD LOCATION</td>
        </tr>
        
        <?php 
       
        foreach($resRecords AS $row):
        $house_no = $row['house_hold_id'];
        $fam_head = $row['family_head'];
        ?>
        <tr>
            <td style="text-align: center;border:1px solid black;">
                <?php echo $row['household_no'];?>
            </td>
            <td style="text-align: center;border:1px solid black;">
                <?php 
                    echo $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
                ?>
            </td>
            <td style="text-align: center;border:1px solid black;">
                <?php echo $row['age'];?>
            </td>
            <td style="text-align: center;border:1px solid black;">
                <?php echo $row['gender'];?>
            </td>
            <td style="text-align: center;border:1px solid black;">
                <?php
                    $resHouseSize = $personal_info->getJoinWhere(" AND p.house_hold_id = '$house_no' ");
                    $countSize = count($resHouseSize);
                    echo $countSize;
                ?>
            </td>
            <td style="text-align: center;border:1px solid black;">
                <?php
                    $resFamhead = $personal_info->getJoinWhere(" AND p.family_head = '$fam_head' AND p.house_hold_id = '$house_no' ");
                    $countfamHead = count($resFamhead);
                    echo $countfamHead;
                ?>
            </td>
            <td style="text-align: center;border:1px solid black;">
                <?php echo $row['house_type'];?>
            </td>
            <td style="text-align: center;border:1px solid black;">
                <?php echo $row['house_location'];?>
            </td>
        </tr>         
        <?php endforeach; ?>
        
        <tr>
            <td colspan="10" style="color:white;">0</td>
        </tr>
    </table>
    <?php if(empty($house_location) && empty($house_type)) : ?>
    <table style="width:50%">
        <tr>
            <td valign="top">
                <h5>SUMMARY OF HOUSEHOLD TYPES</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Name</th>
                            <th>Count</th>                
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                        <?php 
                            $totalhouseholdcount = 0;
                            foreach($reshouseholdcount as $rowc): 
                                $totalhouseholdcount += $rowc['house_hold_count'];                            
                            ?>
                            <tr>
                                <td>
                                    <?php echo $rowc['name'] ?>
                                </td>
                                <td class="t-center">
                                    <?php echo $rowc['house_hold_count'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600">
                                <?php echo $totalhouseholdcount ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td valign="top">
                <h5>SUMMARY OF HOUSEHOLD LOCATIONS</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Name</th>
                            <th>Count</th>                
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                        <?php 
                            $totalhouseholdlocationcount = 0;
                            foreach($reshouseholdlocationcount as $rowl): 
                                $totalhouseholdlocationcount += $rowl['house_hold_count'];                            
                            ?>
                            <tr>
                                <td>
                                    <?php echo $rowl['name'] ?>
                                </td>
                                <td class="t-center">
                                    <?php echo $rowl['house_hold_count'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600">
                                <?php echo $totalhouseholdlocationcount ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <?php endif; ?>
    <!-- reshouseholdcount -->
    <br>
    <br>
    <?php echo $helpers->getsignage($brgysecretary) ?>
</body>
</html>