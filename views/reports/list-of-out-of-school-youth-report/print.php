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
$config = new Config();
$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];

$resRecords = $records->getAllInfo(" AND p.out_of_school_youth = 'Y'");
$male = $records->getAllInfo(" AND p.out_of_school_youth = 'Y' AND p.gender = 'M'");
$female = $records->getAllInfo(" AND p.out_of_school_youth = 'Y' AND p.gender = 'F'");
$male_count = count($male);
$female_count = count($female);
//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");
$brgysecretary = $brgysec['value'];
?> 

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report for List of Out of School Youth | PRINT</title>
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
            <td colspan="10" style="text-align: center;border:none;"><h3>REPORT FOR LIST OF OUT OF SCHOOL YOUTH</h3></td>
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
            <td style="border:1px solid black;text-align:center;"><?php echo $row['gender'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['age'];?></td>
        </tr>                                  
        <?php endforeach; ?>
        
        <tr>
            <td colspan="10" style="color:white;">0</td>
        </tr>
                                            
    </table>
    <table style="width:20%">
        <tr>
            <td valign="top">
                <h5>COUNT OF SEX</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">  
                        <tr>
                            <th>Sex</th>
                            <th>Count</th>           
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                            <tr>
                                <td>Male</td>
                                <td class="t-center"><?php echo $male_count;?></td>
                            </tr>
                            <tr>
                                <td>Female</td>
                                <td class="t-center"><?php echo $female_count;?></td>
                            </tr>
                       
                            <tr>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600">
                                <?php echo (int)$male_count + (int)$female_count;?>
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