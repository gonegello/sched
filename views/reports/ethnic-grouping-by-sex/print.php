<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Personal_info.php');
require (DOCUMENT_ROOT . '../models/Ethnicities.php');
  
$helpers = new Helpers();

$sex = $_GET['sex'];
$ethnicity = $_GET['ethnicity'];
//$type_val = $_GET['bracket'];
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$records = new Personal_info();
$config = new Config();
$ethnicities = new Ethnicities();
$res_ethnicities = $ethnicities->getWhere(" AND status = 'A'");
$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];
//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");
$brgysecretary = $brgysec['value'];

if(empty($ethnicity))
{
    if(empty($sex))
    {
        $resRecords = $records->getEthnicGrouping();

        $mm = $records->getEthnicGrouping(" AND gender = 'M'");
        $male = count($mm);
        $ff = $records->getEthnicGrouping(" AND gender = 'F'");
        $female = count($ff);
        $total = count($resRecords);
    }
    if(!empty($sex))
    {
        $resRecords = $records->getEthnicGrouping(" AND gender = '$sex'");
        $mm = $records->getEthnicGrouping(" AND gender = 'M'");
        $male = count($mm);
        $ff = $records->getEthnicGrouping(" AND gender = 'F'");
        $female = count($ff);
        $total = count($resRecords);

    } 
}
if(!empty($ethnicity))
{
    if(empty($sex)){
        $resRecords = $records->getEthnicGrouping(" AND e.name = '$ethnicity'");
        $emptyorNot = count($resRecords);
        $mm = $records->getEthnicGrouping(" AND e.name = '$ethnicity' AND gender = 'M'");
        $male = count($mm);
        $ff = $records->getEthnicGrouping(" AND e.name = '$ethnicity' AND gender = 'F'");
        $female = count($ff);
        $total = count($resRecords);

    }
    if(!empty($sex)){
        $resRecords = $records->getEthnicGrouping(" AND e.name = '$ethnicity' AND gender = '$sex'");
        $emptyorNot = count($resRecords);
        $mm = $records->getEthnicGrouping(" AND e.name = '$ethnicity' AND gender = 'M'");
        $male = count($mm);
        $ff = $records->getEthnicGrouping(" AND e.name = '$ethnicity' AND gender = 'F'");
        $female = count($ff);
        $total = count($resRecords);

    }
}



?> 



<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethnic Grouping By Sex | PRINT</title>
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
            <td colspan="8" style="text-align: center;border:none;"><h3>ETHNIC GROUPING OF THE TOTAL POPULATION BY SEX</h3></td>
        </tr>

        <tr>
            <td colspan="8" style="text-align: center;border:none;"><h3>
            <?php 
            if(empty($ethnicity) && empty($sex)){
                echo 'All Records';
            }
            if(empty($ethnicity)){
                if($sex == 'M'){
                    echo 'Ethnicities (Male)';
                }
                if($sex == 'F'){
                    echo 'Ethnicities (Female)';
                }
            }
            if(!empty($ethnicity)){
                if($sex == 'M'){
                    echo $ethnicity; echo' (Male)';
                }
                if($sex == 'F'){
                    echo $ethnicity; echo' (Female)';
                }
                if(empty($sex)){
                    echo $ethnicity; echo' (All Sex)';
                }
            }
            ?>
            
            </h3></td>
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
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
        <tr>
            <td rowspan="2" style="text-align:center;width:1%;border:1px solid black;font-weight:bold;">NO.</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" colspan="4" >FULL NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">ETHNICITY</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">SEX</td>

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
            <td style="border:1px solid black;"><?php echo $i;?>.</td>
            <td style="border:1px solid black;"><?php echo $row['last_name'];?></td>
            <td style="border:1px solid black;"><?php echo $row['first_name'];?></td>
            <td style="border:1px solid black;"><?php echo $row['middle_name'];?></td>
            <td style="border:1px solid black;"><?php echo $row['qualifier'];?></td>
            <td style="border:1px solid black;"><?php echo $row['ethnic_name'];?></td>
            <td style="border:1px solid black;"><?php echo $row['gender'];?></td>
        </tr>                                  
        <?php endforeach; ?>
        <tr>
            <td colspan="8" style="color:white;"> space</td>
        </tr>

        

        <tr>
        </tr>

        

        <table style="width:30%">
        <tr>
            <?php if(empty($ethnicity)): ?>
            <td valign="top">
                <h5>SUMMARY BY ETHNICITY</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Name</th>
                            <th>Count</th>   
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                    <?php 
                    #if empty ethnicity and sex is female
                    $over_all = 0;
                    if(empty($ethnicity) && $sex == 'F'){
                        foreach($res_ethnicities AS $row): 
                        $name = $row['name'];
                        $re = $records->getEthnicGrouping(" AND e.name = '$name' AND gender='F'");
                        $re_total = count($re);  
                        $over_all += $re_total;     
                    ?>
                    <tr>
                    <?php if(empty($ethnicity) || $sex == 'F'):?>
                        <td><?php echo $row['name'];?></td>
                        <td class="t-center">
                        <?php echo $re_total;?>
                        </td>
                    <?php endif;?>
                    </tr>
                            
                    <?php endforeach;  }?>

                            <?php 
                        #if empty ethnicity and sex
                        $over_all = 0;
                        if(empty($ethnicity) && empty($sex)){
                            foreach($res_ethnicities AS $row): 
                            $name = $row['name'];
                            $re = $records->getEthnicGrouping(" AND e.name = '$name'");
                            $re_total = count($re);  
                            $over_all += $re_total;     

                        ?>
                        <tr>
                        
                        <td><?php echo $row['name'];?></td>
                        <td class="t-center"><?php echo $re_total;?></td>
                        </tr>                                    
                        <?php endforeach;  }?>

                        <?php 
                            #if empty ethnicity and sex is male
                            $over_all = 0;
                            if(empty($ethnicity) && $sex == 'M'){
                                foreach($res_ethnicities AS $row): 
                                $name = $row['name'];
                                $re = $records->getEthnicGrouping(" AND e.name = '$name' AND gender='M'");
                                $re_total = count($re);   
                                $over_all += $re_total;     
                        ?>
                        <tr>
                        <?php if(empty($ethnicity) || $sex == 'M'):?>
                            <td><?php echo $row['name'];?></td>
                            <td class="t-center"><?php echo $re_total;?></td>
                            <?php endif;?>
                        </tr>                                    
                        <?php endforeach;  }?>
                       
                    </tbody>
                </table>
            </td>
            <?php endif;?>

            <?php if(!empty($ethnicity)):?>
                <td valign="top">
                <h5>SUMMARY BY ETHNICITY</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Name</th>
                            <th>Count</th>   
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                        <tr>
                            <td><?php echo $ethnicity;?></td>
                            <td class="t-center"><?php echo $emptyorNot;?></td>
                        </tr>

                    </tbody>
                </table>
            </td>

            <?php endif;?>
            <td valign="top">
                <h5>COUNT OF SEX</h5>
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
                                    <?php echo $male;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female;?>
                                </td>
                                <td class="t-center">
                                <?php echo (int)$male + (int)$female;?>
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