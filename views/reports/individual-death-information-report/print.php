<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Individual_records.php');
require (DOCUMENT_ROOT . '../models/Personal_info.php');
 
$helpers = new Helpers();
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$personal_info = new Personal_info();
$individual_death = new Individual_records();
$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];

$individual_id = $_GET['id'];
$decrypted_Id = $helpers->encryptDecrypt($individual_id, $action = 'decrypt'); 

$respersonal_info = $personal_info->getIndividual(" AND id = $decrypted_Id");
$last_name = $respersonal_info['last_name'];
$first_name = $respersonal_info['first_name'];
$middle_name = $respersonal_info['middle_name'];
$resDeath = $individual_death->getIndividualDeath(" AND di.personal_info_id = $decrypted_Id");
$cause_of_death = $resDeath['cause_of_death'];
$date_died = $resDeath['date_of_deceased'];
$burried_at = $resDeath['burried_at'];
$age = $resDeath['age'];
$gender = $resDeath['gender'];

?> 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Death Information Report | PRINT</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/print.css">
    <link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css”/>
</head>
<style>
body{
font-family: Arial, Helvetica, sans-serif;
    margin:0;
}
table, th, td {
  padding:none;
}
table {
  border-spacing: 10px;
  margin:0;
  border-collapse: collapse;

}
td{
    width: 2%;
}
.b-bottom{
    border-bottom: 1px solid black;
}
.space{
    word-spacing: 10px;
}
</style>
<body>
    <table>
        <tr>
                <td colspan="4" style="text-align:center;"><h4>OFFICE OF THE PUNONG BARANGAY</h4></td>
        </tr>
     
        <tr>
            <td colspan="4" style="text-align:center;"><h4>CERTIFICATION OF DEATH</h4></td>
        </tr>
        <tr>
            <td colspan="4" style="color:white;">0</td>
        </tr>
        <tr>
            <td>TO WHOM IT MAY CONCERN:</td>
        </tr>
        <tr>
            <td colspan="4" style="color:white;">0</td>
        </tr>
        <tr>
            <td colspan="4" class="space">This is to certify that <span class="b-bottom"><?php echo $first_name; echo " "; echo $middle_name; echo " "; echo $last_name;?></span>,
            <span class="b-bottom"><?php echo $age; echo " ";
            
            if($gender == 'M'){
                echo "Male";
            }
            if($gender == 'F'){
                echo "Female";
            }
            ?></span>, a resident</td>
        </tr>
        <tr>
            <td colspan="4" class="space">passed away on <span class="b-bottom"><?php echo $date_died;?></span>.</td>
        </tr>
        <tr>
            <td colspan="4" style="color:white;">0</td>
        </tr>
        <tr>
            <td colspan="4" class="space">
            The cause of death: <span class="b-bottom"><?php echo $cause_of_death;?>.</span>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="color:white;">0</td>
        </tr>
        <tr>
            <td colspan="4" class="space">
                This certification is issued to support whatever legal purpose it may serve.
            </td>
        </tr>
        <tr>
            <td colspan="4" style="color:white;">0</td>
        </tr>
        <tr>
        <td colspan="4" class="space">Issued this <span class="b-bottom"><?php echo date("F d, Y");?></span> at <span class="b-bottom"><?php echo $brgy_name; echo ", "; echo $municipal_name; echo " "; echo $prov_name;?></span></td>
        </tr>
        <tr>
            <td colspan="4" style="color:white;">0</td>
        </tr>
        <tr>
            <td colspan="4" style="color:white;">0</td>
        </tr>
        <tr>
            <td colspan="4" style="color:white;">0</td>
        </tr>
        <tr>
            <td class="b-bottom"></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>Punong Barangay</td>
        </tr>
    </table>
  
</body>
</html>