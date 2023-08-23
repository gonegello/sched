<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Individual_records.php');
require (DOCUMENT_ROOT . '../models/Occupations.php');
require (DOCUMENT_ROOT . '../models/Civil_status.php');
require (DOCUMENT_ROOT . '../models/Reports.php');
 
$helpers = new Helpers();
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$records = new Reports();
$occupations = new Occupations();
$config = new Config();
$civil_status = new Civil_status();

$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];

$resRecords = $records->getsumarryhousehold();
$rescivil_status = $civil_status->getWhere();

//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");

$brgysecretary = $brgysec['value'];
#with summary on age and sex, and common cause of death


?> 

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSOLIDATED HOUSEHOLD REPORT | PRINT</title>
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
    <table width="100%">
        <tr>
            <td colspan="11" style="text-align: center;border:none;"><h3>CONSOLIDATED REPORT BY HOUSEHOLD</h3></td>
        </tr>

        <tr>
            <td colspan="8" style="text-align: center;border:none;"><h3>       
            </h3></td>
        </tr>

        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
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
            <td rowspan="2" style="text-align:center;width:1%;border:1px solid black;font-weight:bold;">HOUSEHOLD NO.</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" colspan="4" >HOUSEHOLD HEAD FULL NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">PUROK</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">SEX</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">CIVIL STATUS</td>
           


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
            <td style="border:1px solid black;text-align:center;"><?php echo $row['household_no'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['last_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['first_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['middle_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['qualifier'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['no_street_sitio_purok'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['gender'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['civil_name'];?></td>
           
      
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
                <h5>SUMMARY BY SEX AND CIVIL STATUS</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Civil Status</th>
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
                    foreach ($rescivil_status as $row): 
                    
                    $name = $row['name'];
                    $re_male = $records->getsumarryhousehold(" AND civ.name = '$name' AND p.gender = 'M' ");
                    $remale_total = count($re_male);    
                    $re_female = $records->getsumarryhousehold(" AND civ.name = '$name' AND p.gender = 'F' ");
                    $refemale_total = count($re_female);
                    $line_total = (int)$remale_total + (int)$refemale_total;

                    $overall_male += $remale_total;
                    $overall_female += $refemale_total;
                    $overall_line += $line_total;
                
                ?>
                            <tr>
                                <td class="t-center">
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
                            <?php endforeach; ?>
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
                <h5>LIST OF PUROK</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Partially</th>                           
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                    <?php foreach ($resRecords as $row):  ?>
                            <tr>
                                <td class="t-center">
                                <?php echo $row['no_street_sitio_purok'];?>
                                </td>
                            </tr>
                     <?php endforeach;?>
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