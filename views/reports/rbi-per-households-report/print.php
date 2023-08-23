<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Reports.php');
 
$helpers = new Helpers();
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$records = new Reports();
$config = new Config();
$resRecords = $records->getrbiPerHousehold();

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
    <title>Updates for Report on Barangay Inhabitant (RBI) per Households | PRINT</title>
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
            <td colspan="4" style="text-align: center;border:none;"><h3>UPDATES FOR REPORT ON BARANGAY <br>INHABITANTS (RBI) PER HOUSEHOLDS</h3></td>
        </tr>
    </table>

   
    <table>
 
        <tr>
            <td colspan="4" style="color:white;border:none;">0</td>
        </tr>
       
        <tr>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">Name of Purok</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">Name of Households Heads</td>
            <td style="text-align:center;border:1px solid black;font-weight:bold;">Number of Member</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">Number of Families</td>
        </tr>
       
        <?php 
        $i = 0;
        foreach($resRecords AS $row): $i++;
        $house_hold_id = $row['house_hold_id'];
        $member = $records->getRBIcount(" AND p.house_hold_id = $house_hold_id ");
        $count_members = count($member) - 1;
        $fam = $records->getRBIcount(" AND p.family_head = 'Y' AND p.house_hold_id = $house_hold_id");
        $count_fam = count($fam);

        ?>
         <tr>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['no_street_sitio_purok'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['first_name']; echo " "; echo $row['last_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $count_members; ?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $count_fam; ?></td>
        </tr>                                  
        <?php endforeach; ?>
        <tr>
            <td colspan="4" style="color:white;border:none;">0</td>
        </tr>
      
                                            
    </table>

    <br>
 <br>
    <?php echo $helpers->getsignage($brgysecretary) ?>


    
  
</body>
</html>