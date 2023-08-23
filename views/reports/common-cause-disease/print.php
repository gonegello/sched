<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Death_information.php');

$helpers = new Helpers();


if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$records = new Death_informations();
$config = new Config();
$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];

$resRecords = $records->getcausejoin();

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
<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
        
        margin:0;
    }
    table, th, td {     
  padding:5px;
}
table {
  border-spacing: 0px;
  margin:0;
  border-collapse: collapse;
}
td{
    width: 2%;
  
    
} 
</style>

<body>
    <table>
        <tr>
            <td colspan="8" style="text-align: center;border:none;"><h3>COMMON DISEASE THAT CAUSE DEATH</h3></td>
        </tr>
        <tr>
            <td colspan="8" style="text-align:center;text-transform:uppercase;"><h4>
    
            </h4>
            </td>
        </tr>
        <tr>
            <td style="font-size:12px;">A. REGION</td>
            <td style="font-size:12px;" colspan="7" class="border-bottom"><?php echo $region;?></td>
        </tr>
        <tr>
            <td style="font-size:12px;">PROVINCE</td>
            <td style="font-size:12px;" colspan="7" class="border-bottom"><?php echo $prov_name;?></td>
        </tr>
        <tr>
            <td style="font-size:12px;">MUNICIPALITY</td>
            <td style="font-size:12px;" colspan="7" class="border-bottom"><?php echo $municipal_name;?></td>
        </tr>
        <tr>
            <td style="font-size:12px;">BARANGAY</td>
            <td style="font-size:12px;" colspan ="7" class="border-bottom"><?php echo $brgy_name;?></td>
        </tr>
        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
        <tr>
            <td rowspan="2" style="text-align:center;border:0px solid black;font-weight:bold;"></td>
            <td style="text-align: center;border:0px solid black;font-weight:bold;" colspan="4" ></td>
            <td style="text-align: center;border:0px solid black;font-weight:bold;" rowspan="2"></td>
            <td style="text-align: center;border:0px solid black;font-weight:bold;" rowspan="2"></td>
        </tr>
        <tr>
            <td style="text-align: center;border:0px solid black;font-weight:bold;"> </td>
            <td style="text-align: center;border:0px solid black;font-weight:bold;"> </td>
            <td style="text-align:center;border:0px solid black;font-weight:bold;"> </td>
            <td style="text-align: center;border:0px solid black;font-weight:bold;"></td>

        <?php
       echo
       '
       <tr>
       <td style="text-align: center;border:1px solid black;font-weight:bold;">Disease</td>
       <td style="text-align: center;border:1px solid black;font-weight:bold;">No. Of Deaths</td>
       </tr>
       '
       ;
        ?>

        <?php
       foreach($resRecords AS $row) {
        
            echo
            '
            <tr>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">'.$row['name'].'</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">'.$row['duplicates'].'</td>
            <td style="font-size:12px;text-align:center;"></td>
            <td style="font-size:12px;text-align:center;"></td>
            </tr>
            '
            ;
        }

        ?> 

        </tr>
        <tr>
        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>

      

   
        
    </table>
   

    
  
</body>
</html>