<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Individual_records.php');
require (DOCUMENT_ROOT . '../models/Resident_types.php');
  


$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$resident_type = $_GET['resident_type'];
$config = new Config();
$records = new Individual_records();
$resident_types = new Resident_types();
$result = $resident_types->getWhere(" AND status = 'A'");



$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];

if(empty($resident_type)){
    $resRecords = $records->getResidentSummary();
}
if(!empty($resident_type)){
    $resRecords = $records->getResidentSummary(" AND rt.name = '$resident_type'");
    $count = count($resRecords);
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary of Residence Report | Print</title>
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

.border-bottom{
    font-size: 12px;
}
     
</style>
<body>
    <table>
        <tr>
            <td colspan="8" style="text-align: center;border:none;"><h3>
                 SUMMARY OF RESIDENCE REPORT
            </h3></td>
        </tr>

        <tr>
            <td colspan="8" style="text-align: center;border:none;"><h5>
            <?php
            if(empty($resident_type)){
                echo '(All Resident Types)';
            }
            if(!empty($resident_type)){
                echo '( List of '; echo $resident_type; echo ' Residents)';
            }

            ?>
            </h5></td>
        </tr>

        <tr>
            <td colspan="7" style="color:white;border:none;">space</td>
        </tr>
        <tr>
            <td class="border-bottom">A. REGION</td>
            <td class="border-bottom" colspan="2"><?php echo $region;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td class="border-bottom">PROVINCE</td>
            <td class="border-bottom" colspan="2"><?php echo $prov_name;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
 
        </tr>
        <tr>
            <td class="border-bottom">MUNICIPALITY</td>
            <td class="border-bottom" colspan="2"><?php echo $municipal_name;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td class="border-bottom">BARANGAY</td>
            <td class="border-bottom" colspan="2"><?php echo $brgy_name;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td colspan="7" style="color:white;border:none;">space</td>
        </tr>

         <tr>
            <td colspan="7" style="color:white;border:none;">
            space
            
            </td>
        </tr>

        <tr>
            <td rowspan="2" style="text-align:center;width:1%;border:1px solid black;font-weight:bold;">NO.</td>
            <td rowspan="2" style="text-align:center;width:1%;border:1px solid black;font-weight:bold;">HOUSEHOLD NO.</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" colspan="4" >FULL NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">RESIDENT TYPE</td>
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
            <td style="border:1px solid black;text-align:center;"><?php echo $i; echo ".";?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['household_no'];?></td>
            <td style="border:1px solid black;"><?php echo $row['last_name'];?></td>
            <td style="border:1px solid black;"><?php echo $row['first_name'];?></td>
            <td style="border:1px solid black;"><?php echo $row['middle_name'];?></td>
            <td style="border:1px solid black;"><?php echo $row['qualifier'];?></td>
            <td style="border:1px solid black;"><?php echo $row['resident_type'];?></td>
            </tr>                                 
        <?php endforeach; ?>
        <tr>
            <td colspan="7" style="color:white;border:none;">space</td>
        </tr>
    
            <?php
           
            if(empty($resident_type) || !empty($resident_type)){
                echo
                '
                <tr>
                <td></td>
                <td style="font-size:12px;">TOTAL</td>
                <td style="font-size:12px;"></td>
                <td style="font-size:12px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
                '
                ;
            }
            ?>
        <?php 
        $i = 0; 
        if(empty($resident_type)){
        foreach($result AS $row):
            $name = $row['name'];
            $re = $records->getResidentSummary(" AND rt.name = '$name'");
            $re_total = count($re); 
            $overall += (int)$re_total;
        ?>
            <tr>
            <td style="font-size:12px;"><?php echo $row['name'];?></td>
            <td><?php echo $re_total;?></td>
            </tr>                                 
        <?php endforeach; }?>
        <tr>
            

            <?php 
            if(empty($resident_type))
            {
                echo 
                '
                <td></td>
                <td style="border-top:1px solid black;">'.$overall.'</td>
                '
                ;
            }

            
            ?>
        
           
        </tr>
        <tr>
        <?php
            if(!empty($resident_type)){
                echo
                '
                <tr>
                <td style="font-size:12px;">'.$resident_type.'</td>
                <td>'.$count.'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
                '
                ;
            }
    
            ?>

        </tr>
 
 
        
    </table>
   

    
  
</body>
</html>