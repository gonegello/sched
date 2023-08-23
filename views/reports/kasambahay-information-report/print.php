<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Kasambahay_info.php');
require (DOCUMENT_ROOT . '../models/Civil_status.php');


$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}


$config = new Config();
$records = new Kasambahay_info();
$civil_status = new Civil_status();
$resRecords = $records->getkasambahayinformation();

$male = $records->getJoinWhere(" AND p_in.gender='M'");
$count_male = count($male);
$female = $records->getJoinWhere(" AND p_in.gender='F'");
$count_female = count($female);
$resCivil = $civil_status->getJoinWhere(" AND status = 'A'");

//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");

$brgysecretary = $brgysec['value'];
#single
#married
#separated
#

$gender_total = (int)$count_female + (int)$count_male;


$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];
?> 
<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasambahay Report | PRINT</title>
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
    <div>
        <table>
        <h3 style="text-align: center; padding-top: 20px;">KASAMBAHAY REPORT</h3>
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
        </table>
    </div>
    <table>
        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
        <tr>
            <td rowspan="2" style="border:1px solid black;text-align:center;">NO.</td>
            <td  colspan="3" style="border:1px solid black;text-align:center;">FULL NAME</td>
            <td rowspan="2" style="border:1px solid black;text-align:center;">HOME ADDRESS</td>
            <td rowspan="2" style="border:1px solid black;text-align:center;">EMPLOYER ADDRESS</td>
            <td  rowspan="2" style="border:1px solid black;text-align:center;">SEX</td>
            <td rowspan="2" style="border:1px solid black;text-align:center;">CIVIL STATUS</td>
            <td  rowspan="2" style="border:1px solid black;text-align:center;">DATE OF BIRTH</td>
            <td  rowspan="2" style="border:1px solid black;text-align:center;">AGE</td>
            <td  rowspan="2" style="border:1px solid black;text-align:center;">CONTACT NO</td>
            <td  rowspan="2" style="border:1px solid black;text-align:center;">SSS NO</td>
            <td rowspan="2" style="border:1px solid black;text-align:center;">PAG-IBIG NO</td>
            <td  rowspan="2" style="border:1px solid black;text-align:center;">PHILHEALTH NO</td>
            <td colspan="4" style="border:1px solid black;text-align:center;">WORK INFORMATION</td>

        </tr>
        <tr>
            <td style="border:1px solid black;text-align:center;" >LAST NAME</td>
            <td style="border:1px solid black;text-align:center;" >FIRST NAME</td>
            <td style="border:1px solid black;text-align:center;">MIDDLE NAME</td>
            <td style="border:1px solid black;text-align:center;">MONTHLY SALARY</td>
            <td style="border:1px solid black;text-align:center;">NATURE OF WORK</td>
            <td style="border:1px solid black;text-align:center;">EMPLOYMENT ARRANGEMENT</td>
            <td style="border:1px solid black;text-align:center;">NAME OF EMPLOYER</td>
        </tr>

        <?php 
        $i = 0;
        foreach($resRecords AS $row): $i++;?>
        
            <tr>
            <td style="border:1px solid black;text-align:center;"><?php echo $i; echo ".";?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['last_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['first_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['middle_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php
            $address = $row['brgy_name'] . ', ' . ucwords(strtolower($row['mun_name'])) . ' ' .ucwords( strtolower($row['province_name']));
            echo $address;?></td>
           <td style="border:1px solid black;text-align:center;"><?php
            $address = $row['brgy_name'] . ', ' . ucwords(strtolower($row['mun_name'])) . ' ' .ucwords( strtolower($row['province_name']));
            echo $address;?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['gender'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['marital_status'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['birthdate'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['age'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['contact_no'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['sss_no'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['pagibig_no'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['philhealth_no'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo number_format($row['monthly_salary'], 2);?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['nature_of_work_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php
            if($row['employment_arrangement'] == 'I')
            { echo "Live-in";}else { echo "Live-out";}
          ?></td>
            <td style="border:1px solid black;"><?php echo $row['first_name'];?></td>
            </tr>                                 
        <?php endforeach; ?>
        

        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
    </table>
    <table style="width:30%">
        <tr>
    <td valign="top">
                <h5>SUMMARY OF SEX</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Male</th>
                            <th>Female</th>                              
                            <th>Total</th>                              
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                   
                            <tr>
                                <td class="t-center">
                                <?php echo $count_male;?>
                                </td>
                                <td class="t-center">
                                <?php echo $count_female;?>
                               
                                </td>
                                <td class="t-center">
                                <?php echo (int)$count_male + (int)$count_female;?>
                             
                                </td>
                            </tr>
                     
                    </tbody>
                </tr>
                </table>
            </td>
            <td valign="top">
                <h5>SUMMARY OF CIVIL STATUS</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        
                    <tr>
                            <th>Status</th>
                            <th>Count</th>                              
                                                     
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                    <?php 
                            foreach($resCivil AS $row): 
                            $name = $row['name'];
                            $re = $records->getJoinWhere(" AND cs.name = '$name'");
                            $re_total = count($re);       
                    ?>
                            <tr>
                                <td>
                                <?php echo $row['name'];?>
                                </td>
                                <td class="t-center">
                                <?php echo $re_total;?>                          
                                </td>
                            </tr>
                        <?php endforeach; ?>
                     
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