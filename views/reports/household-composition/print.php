<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Individual_records.php');
require (DOCUMENT_ROOT . '../models/Personal_info.php');
require (DOCUMENT_ROOT . '../models/House_types.php');
require (DOCUMENT_ROOT . '../models/House_locations.php');
 
$helpers = new Helpers();
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
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

if(empty($house_location) && empty($house_type))
{
    $resRecords = $records->getsumarryhousehold();
}
if(!empty($house_location) && !empty($house_type))
{
    $resRecords = $records->getsumarryhousehold( " AND ht.id = '$house_type' AND hl.id = '$house_location' ");
    
}
if(!empty($house_location) && empty($house_type))
{
    $resRecords = $records->getsumarryhousehold( " AND hl.id = '$house_location'");
    
}

if(empty($house_location) && !empty($house_type))
{
    $resRecords = $records->getsumarryhousehold( " AND ht.id = '$house_type'");
    
}





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
}
table, th, td {
  padding:3px;
  
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
            <td colspan="7" style="text-align: center;border:none;"><h3>SUMMARY OF HOUSEHOLD TYPE AND HOUSE LOCATION</h3></td>
        </tr>

        <tr>
            <td colspan="7" style="text-align: center;border:none;">
            <h5>    
            </h5></td>
        </tr>

        <tr>
            <td colspan="7" style="color:white;border:none;">space</td>
        </tr>
        <tr>
            <td style="font-size:12px;">A. REGION</td>
            <td style="font-size:12px;" class="border-bottom"><?php echo $region;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="font-size:12px;">PROVINCE</td>
            <td style="font-size:12px;" class="border-bottom"><?php echo $prov_name;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
 
        </tr>
        <tr>
            <td style="font-size:12px;">MUNICIPALITY</td>
            <td style="font-size:12px;" class="border-bottom"><?php echo $municipal_name;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td style="font-size:12px;">BARANGAY</td>
            <td style="font-size:12px;" class="border-bottom"><?php echo $brgy_name;?></td>
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
            <td style="text-align: center;border:1px solid black;font-weight:bold;">HOUSE NO.</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">NAME OF HOUSEHOLD HEAD</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">AGE</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">SEX</td>
            <td style="text-align:center;border:1px solid black;font-weight:bold;">HOUSEHOLD SIZE</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">HOUSEHOLD TYPE</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;">HOUSEHOLD LOCATION</td>
        </tr>
        
        <?php 
      
        foreach($resRecords AS $row):
        $house_no = $row['house_hold_id'];
        ?>
        <tr>
        <td style="text-align: center;border:1px solid black;"><?php echo $row['household_no'];?></td>
        <td style="text-align: center;border:1px solid black;"><?php echo $row['first_name'];
        echo ' '; echo $row['middle_name']; echo ' '; echo $row['last_name'];?></td>
        <td style="text-align: center;border:1px solid black;"><?php echo $row['age'];?></td>
        <td style="text-align: center;border:1px solid black;"><?php echo $row['gender'];?></td>
        <td style="text-align: center;border:1px solid black;">
    
        <?php
        $resHouseSize = $personal_info->getJoinWhere(" AND p.house_hold_id = '$house_no' ");
        $countSize = count($resHouseSize);
        echo $countSize;
        ?>
        </td>
        <td style="text-align: center;border:1px solid black;"><?php echo $row['house_type'];?></td>
        <td style="text-align: center;border:1px solid black;"><?php echo $row['house_location'];?></td>


        </tr>         
        <?php endforeach; ?>
        
        <tr>
            <td colspan="10" style="color:white;">0</td>
        </tr>
        <tr>
            <td style="font-weight: bold;font-size:13px;">SUMMARY (HOUSE TYPE)</td>
        </tr> 

        <?php 
                $ht_total = 0;
                foreach($resHousetype AS $row): 
                $name = $row['name'];
                $re = $records->getsumarryhousehold(" AND ht.name = '$name'");
                $re_total = count($re);     
                $ht_total+= $re_total;  
        ?>
         <tr>
            <td style="font-size:13px;text-transform:uppercase;"><?php echo $row['name'];?></td>
            <td style="font-size:13px;"><?php echo $re_total;?></td>
        </tr>                                    
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td style="border-top:1px solid black;"><?php echo $ht_total;?></td>
        </tr>

        <tr>
            <td colspan="10" style="color:white;">0</td>
        </tr>
        <tr>
            <td style="font-weight: bold;font-size:13px;">SUMMARY (HOUSE LOCATION)</td>
        </tr> 

        <?php 
                $hl_total = 0;
                foreach($resHouselocation AS $row_1): 
                $name_1 = $row_1['name'];
                $re_1 = $records->getsumarryhousehold(" AND hl.name = '$name_1'");
                $re_total_1= count($re_1);   
                $hl_total += $re_total_1;    
        ?>
         <tr>
            <td style="font-size:13px;text-transform:uppercase;"><?php echo $row_1['name'];?></td>
            <td style="font-size:13px;"><?php echo $re_total_1;?></td>
        </tr>                                    
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td style="border-top:1px solid black;"><?php echo $hl_total;?></td>
        </tr>


        
    </table>
   

    
  
</body>
</html>