<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Personal_info.php');
require (DOCUMENT_ROOT . '../models/House_holds.php');
require (DOCUMENT_ROOT . '../models/Household_head_relationship.php');
require (DOCUMENT_ROOT . '../models/Civil_status.php');
require (DOCUMENT_ROOT . '../models/Occupations.php');
require (DOCUMENT_ROOT . '../models/Citizenships.php');
require (DOCUMENT_ROOT . '../models/Barangay.php');
require (DOCUMENT_ROOT . '../models/Municipality.php');
require (DOCUMENT_ROOT . '../models/Province.php');

$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$sess = $_SESSION['SESS_REG_CODE'];

$config = new Config();

// $resTsag = $tsag->getWhere();
$personal_info = new Personal_info();
$households = new House_holds();
$head_relationship = new Household_head_relationship();
$civil_status = new Civil_status();
$occupations = new Occupations();
$citizenships = new Citizenships();
$barangay = new Barangay();
$municipality = new Municipality();
$province = new Province();

// echo json_encode(['brgyID' => '28486', 'provCode' => '0864', 'cityMunCode' => '086403']);
$individual_id = $_GET['id'];
$decrypted_Id = $helpers->encryptDecrypt($individual_id, $action = 'decrypt'); 
$value = $config->getSettings("AND name = 'Barangay Secretary'");
$barangay_sec = $value['value'];
$respersonal_info = $personal_info->getIndividual(" AND id = $decrypted_Id");
$last_name = $respersonal_info['last_name'];
$first_name = $respersonal_info['first_name'];
$middle_name = $respersonal_info['middle_name'];
$address = $respersonal_info['no_street_sitio_purok'];
$is_family_head = $respersonal_info['family_head'];
$birthdate = $respersonal_info['birthdate'];
$dd = date_create($birthdate);
$bday = date_format($dd,"m-d-Y");
$birth_place = $respersonal_info['birth_place'];
$household_id = $respersonal_info['house_hold_id'];
$gender = $respersonal_info['gender'];
$civil_id = $respersonal_info['civil_status_id'];
$citizen_id = $respersonal_info['citizenship_id'];

$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];

$relation_id = $respersonal_info['household_head_relationship_id'];

if(!empty($relation_id)){
    $resRelate = $head_relationship->getRelationship(" AND id = $relation_id");
    $rel_name = $resRelate['name'];
}

$qualifier = $respersonal_info['qualifier'];



$occ_id = $respersonal_info['occupation'];
$resHousehold = $households->getHousehold(" AND id = $household_id");
$hn = $resHousehold['household_no'];
$resCivil = $civil_status->getCivilStatus(" AND id = $civil_id");
$civil_status_name = $resCivil['name'];

// $resHouseRelation = $head_relationship->getRelationship(" AND id = $hr_id");
// $relationship_name = $resHouseRelation['name'];
if(!empty($occ_id)){
    $occ_res = $occupations->getoccupationname("AND id IN ($occ_id)");
    $occupation_name = $occ_res['name'];
}
if(!empty($citizen_id)){
    $citi_res = $citizenships->getcitizenshipname("AND id IN ($citizen_id)");
    $citizenships_name = $citi_res['name'];
}



?> 


<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Records | Print</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/print.css">
    <link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css”/>
</head>
<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
        border:2px solid black;
        margin:0;
    }
    table, th, td {

  padding:0px;
  
}
table {
  border-spacing: 0px;
  margin:0;
  
}
td{
    width: 3%;
    font-size: 13px;

    
}
     
</style>
<body>
   
<table>
    <tr>
        <td colspan="32" style="text-align: center;padding-top:0px;padding-bottom:0px;"> <h2 style="background:black;color:white;padding:0;margin:0;">INDIVIDUAL RECORD OF BARANGAY INHABITANTS</h2></td>   
    </tr>
    <tr>
        <td colspan="32" style="color:white;">space</td>  
    </tr>
    <tr>
        <td colspan="16"></td>
        <td colspan="9" style="background-color: black; color:white;width:19%;">HOUSEHOLD NUMBER</td>
        <td colspan="3" style="border-bottom: 1px solid black;"><?php echo $hn;?></td>
        <td colspan="4"></td>      
    </tr>

    <tr>
        <td  style="background-color: black;color:white;font-weight:bold;">Region</td>
        <td><?php echo $sess;?></td>
        <td colspan="30"></td>
    </tr>
    <tr>
        <td colspan="32" style="color:white;">Space</td>
        
    </tr>
    <tr>
        <td style="background-color: black;color:white;font-weight:bold;">Barangay</td>
        <td colspan="24" style="border-bottom: 1px solid black;text-transform:uppercase;letter-spacing:1px solid black;">
        <?php
        if(!empty($brgy_name))
        {
            echo $brgy_name;
        }
       ?>
        </td>
        <td colspan="7"></td>
    </tr>

    <tr>
        <td colspan="32" style="color:white;">Space</td>
        
    </tr>

    <tr>
        <td colspan="25" style="background-color: black;color:white;font-weight:bold;">PERSONAL INFORMATION</td>
        <td colspan="7"></td>
    </tr>

    <tr>
        <td colspan="32" style="color:white;">Space</td>
        
    </tr>

    <tr>
        <td style="background-color: black;color:white;font-weight:bold;">Last Name</td>
        <td colspan="17" style="border-bottom: 1px solid black;letter-spacing:1px;text-transform:uppercase;"><?php echo $last_name;?></td>
        <td colspan="4">Qualifier</td>
        <td colspan="3" style="border-bottom:1px solid black;letter-spacing:1px;text-transform:uppercase;"><?php echo $qualifier;?></td>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td colspan="32" style="color:white;">Space</td>
        
    </tr>

    <tr>
        <td style="background-color: black;color:white;font-weight:bold;">First Name</td>
        <td colspan="24" style="border-bottom: 1px solid black;letter-spacing:1px;text-transform:uppercase;"><?php echo $first_name;?></td>
        <td colspan="7"></td>
       
    </tr>
    <tr>
        <td colspan="32" style="color:white;">Space</td>
        
    </tr>

    <tr>
        <td style="background-color: black;color:white;font-weight:bold;">Middle Name</td>
        <td colspan="24" style="border-bottom: 1px solid black;letter-spacing:1px;text-transform:uppercase;"><?php echo $middle_name;?></td>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td colspan="32" style="color:white;">Space</td>
        
    </tr>

    <tr>
        <td style="background-color: black;color:white;font-weight:bold;">Address</td>
        <td colspan="8" style="border-bottom: 1px solid black;letter-spacing:1px;text-transform:uppercase;"><?php echo $address;?></td>
        <td colspan="12" style="border-bottom: 1px solid black;"></td>
        <td colspan="11" style="border-bottom: 1px solid black;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="8">No.</td>
        <td colspan="12">Street</td>
        <td colspan="11">Name of Subd./Zone/Sitio/Purok</td>
    </tr>
    <tr>
        <td colspan="32" style="color:white;">space</td>
        
    </tr>
    <tr>
        <td></td>
        <td colspan="15" style="letter-spacing:1px;text-transform:uppercase;" >
        <?php
            if(!empty($municipal_name))
            {
                echo $municipal_name;
            }
        ?>
        </td>
     
        <td colspan="16" style="letter-spacing:1px;text-transform:uppercase;">
        <?php
            if(!empty($prov_name))
            {
                echo $prov_name;
            }
        ?></td>
    </tr>

    <tr>
        <td></td>
        <td colspan="15" style="border-top: 1px solid black;">Municipality</td>
     
        <td colspan="16" style="border-top: 1px solid black;">Province</td>
    </tr>

    <tr>
        <td colspan="32" style="color:white;">space</td>  
    </tr>

    <tr>
        <td style="background-color: black;color:white;font-weight:bold;">Date of Birth</td>
        <td colspan="10" style="border-bottom: 1px solid black;"><?php echo $bday;?></td>
        <td colspan="21"></td>
    </tr>
    <tr>
        <td colspan="32" style="color:white;">space</td>
        
    </tr>

    <tr>
        <td style="background-color: black;color:white;font-weight:bold;">Place of Birth</td>
        <td colspan="24" style="border-bottom: 1px solid black;letter-spacing:1px;text-transform:uppercase;"><?php echo $birth_place;?></td>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td colspan="32" style="color:white;">space</td>
        
    </tr>
  
    <tr>
        <td colspan="32" style="color:white;">space</td>
        
    </tr>
    <tr>
        <td style="background-color: black;color:white;font-weight:bold;">Sex</td>
        <td colspan="2" >Male</td>
        <td style="border:1px solid black;text-align:center;">
        <?php
        if($gender == 'M'){
            echo '<b>/</b>';
        }
        ?>
        </td>
        <td></td>
        <td colspan="3">Female</td>
        <td style="border:1px solid black;text-align:center;">
        <?php
        if($gender == 'F'){
            echo '<b>/</b>';
        }
        ?>
        </td>
        <td colspan="23"></td>
    </tr>
    <tr>
        <td colspan="32" style="color:white;">space</td>
        
    </tr>
    <tr>
        <td style="background-color: black;color:white;font-weight:bold;">Civil Status</td>
        <td colspan="2">Single</td>
        <td style="border:1px solid black;text-align:center;">
        <?php
        if($civil_status_name == 'Single'){
            echo '<b>/</b>';
        }
        ?>
        </td>
        <td></td>
        <td colspan="3">Married</td>
        <td style="border:1px solid black;text-align:center;">
        <?php
        if($civil_status_name == 'Married'){
            echo '<b>/</b>';
        }
        ?>
        </td>
        <td></td>
        <td colspan="4">Widower</td>
        <td style="border:1px solid black;text-align:center;">
        <?php
        if($civil_status_name == 'Widower'){
            echo '<b>/</b>';
        }
        ?>
        </td>
        <td></td>
        <td colspan="4">Separated</td>
        <td style="border:1px solid black;text-align:center;">
        <?php
        if($civil_status_name == 'Separated'){
            echo '<b>/</b>';
        }
        ?>
        </td>
        <td colspan="14"></td>
    </tr>
    <tr>
        <td colspan="32" style="color:white;">space</td>
        
    </tr>
    <tr>
        <td style="background-color: black;color:white;font-weight:bold;">Occupation</td>
        <td colspan="24" style="border-bottom:1px solid black;letter-spacing:1px;text-transform:uppercase;">
        <?php
        if(!empty($occupation_name)) {
            echo ucwords($occupation_name);
        }
        
        ?>
        </td>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td colspan="32" style="color:white;">space</td>
        
    </tr>
    <tr>
        <td style="background-color: black;color:white;font-weight:bold;">Citizenship</td>
        <td colspan="24" style="border-bottom:1px solid black;letter-spacing:1px;text-transform:uppercase;">
        <?php 
        if(!empty($citizenships_name)){
            echo $citizenships_name;
        }
        ?>
        </td>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td colspan="32" style="color:white;">space</td>
        
    </tr>
    <tr>
        <td style="background-color: black;color:white;width:16%;font-weight:bold;">Relationship to<br> Household Head</td>
        <td colspan="24" style="border-bottom:1px solid black;letter-spacing:1px;text-transform:uppercase;">
        <?php
        if(!empty($rel_name))
        {
            echo $rel_name;
        }
        else{
            echo 'Family Head';
        }
        
       ?>
        </td>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td colspan="32" style="color:white;">space</td>
        
    </tr>
    <tr>
        <td colspan="32" >I hereby certify that the above information are true and correct to the best of my knowledge.</td>
        
    </tr>
    <tr>
        <td colspan="32" style="color:white;">space</td>
        
    </tr>
    <tr>
        <td colspan="32" style="color:white;">space</td>
        
    </tr>
    <tr>
        <td colspan="32" style="color:white;">space</td>
        
    </tr>

    <tr>
        <td colspan="14"></td>
        <td colspan="15" style="text-align:center;text-transform:uppercase;font-weight:bold;"><?php echo $first_name; echo " "; echo $middle_name; echo " "; echo $last_name;?></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="14"></td>
        <td colspan="15" style="border-top:1px solid black;text-align:center;font-size:11px;">Name/Signature of Person Accomplishing this form</td>
        <td colspan="3"></td>
    </tr>

    <tr>
    <td></td>
        <td colspan="17"></td>
        <td colspan="10" style="color:white;">space</td>
        <td colspan="5"></td>
    </tr>
    
    <tr>
    <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="10" style="border-top:1px solid black;text-align:center;">Date Accomplished</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2" style="color:white;"></td>
        <td></td>
        <td colspan="3" style="color:white;">Space</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;"></td>
        <td></td>
        <td colspan="5" style="border-top:1px solid black;border-right:1px solid black;border-left:1px solid black;"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        
    </tr>
    <tr>
        <td></td>
        <td colspan="2" style="color:white;"></td>
        <td></td>
        <td colspan="3" style="color:white;">Space</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4" style="border-right:1px solid black;border-left:1px solid black;"></td>
        <td></td>
        <td colspan="5" style="border-right:1px solid black;border-left:1px solid black;"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        
    </tr>
    <tr>
        <td></td>
        <td colspan="2" style="color:white;"></td>
        <td></td>
        <td colspan="3" style="color:white;">Space</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4" style="border-right:1px solid black;border-left:1px solid black;"></td>
        <td></td>
        <td colspan="5" style="border-right:1px solid black;border-left:1px solid black;"></td5
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        
    </tr>
    <tr>
        <td></td>
        <td colspan="2" style="color:white;"></td>
        <td></td>
        <td colspan="3" style="color:white;">Space</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4" style="border-right:1px solid black;border-left:1px solid black;"></td>
        <td></td>
        <td colspan="5" style="border-right:1px solid black;border-left:1px solid black;"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        
    </tr>
    <tr>
        <td>Attested By:</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4" style="border-right:1px solid black;border-left:1px solid black;"></td>
        <td></td>
        <td colspan="5" style="border-right:1px solid black;border-left:1px solid black;"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        
    </tr>
     <tr>
        <td></td>
        <td colspan="2" style="color:white;"></td>
        <td></td>
        <td colspan="3" style="color:white;">Space</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4" style="border-right:1px solid black;border-left:1px solid black;"></td>
        <td></td>
        <td colspan="5" style="border-right:1px solid black;border-left:1px solid black;"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        
    </tr> <tr>
        <td></td>
        <td colspan="2" style="color:white;"></td>
        <td></td>
        <td colspan="3" style="color:white;">Space</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4" style="border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;"></td>
        <td></td>
        <td colspan="5" style="border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
         
    </tr>
    <tr>
        <td colspan="6" style="text-align: center;text-transform:uppercase;font-weight:bold;"><?php echo $barangay_sec;?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4" >Left</td>
        <td></td>
        <td colspan="4">Right</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        
    </tr>
    <tr>
        <td colspan="6" style="border-top:1px solid black;text-align:center;">Barangay Secretary</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4">Thumbmark</td>
        <td></td>
        <td colspan="4">Thumbmark</td>
        <td colspan="5"></td>
        
    </tr>
    <tr>
        <td colspan="6"></td>
        <td colspan="12"></td>
        <td colspan="14" style="font-size:11px;">(In case inhabitant is unable to read and write)</td>  
    </tr>

    <tr>
        <td colspan="32" style="color:white;">Georg</td>
        
    </tr>
    <tr>
        <td colspan="32" style="font-style: italic;">Note: The HN shall be filled by the Barangay Secretary.</td>    
    </tr> 
</table>
    
  
</body>
</html>