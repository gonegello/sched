<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Reports.php');
require (DOCUMENT_ROOT . '../models/Religion.php');
  
$helpers = new Helpers();

$sex = $_GET['sex'];
$religion = $_GET['religion'];
//$type_val = $_GET['bracket'];
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$records = new Reports();
$config = new Config();
$rel = new Religion();
$res_religion = $rel->getWhere(" AND status = 'Y'");
$groupByReligion = $records->getReligion();
$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];

//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");
$brgysecretary = $brgysec['value'];
if(!empty($religion))
{
    if($sex == 'M'){
        $resRecords = $records->getJoinWhere(" AND re.name = '$religion' AND gender = 'M'");
        $male = count($resRecords);
        $total = (int)$male;
    }
    if($sex == 'F'){
        $resRecords = $records->getJoinWhere(" AND re.name = '$religion' AND gender = 'F'");
        $female = count($resRecords);
        $total = (int)$female;

    }
    if(empty($sex)){
        $resRecords = $records->getJoinWhere(" AND re.name = '$religion'");
        #male
        $mm = $records->getJoinWhere(" AND re.name = '$religion' AND gender = 'M'");
        $male = count($mm);
        #female
        $ff = $records->getJoinWhere(" AND re.name = '$religion' AND gender = 'F'");
        $female = count($ff);

        $total = (int)$male + (int)$female;
    }
}
if(empty($religion) && empty($sex)){
    $resRecords = $records->getJoinWhere();
    $mm = $records->getJoinWhere("  AND gender = 'M'");
        $male = count($mm);
        #female
        $ff = $records->getJoinWhere("  AND gender = 'F'");
        $female = count($ff);
        $total = (int)$male + (int)$female;
}

if(empty($religion))
{
    
    if($sex == 'M'){
        $resRecords = $records->getJoinWhere(" AND gender = 'M'");
        $mm = $records->getJoinWhere(" AND gender = 'M'");
        $male = count($mm);
        $total = (int)$male;
        
    }
    if($sex == 'F'){
        $resRecords = $records->getJoinWhere(" AND gender = 'F'");
        $ff = $records->getJoinWhere(" AND gender = 'F'");
        $female = count($ff);

        $total = (int)$female;
    }
}

if(!empty($religion))
{
    $ss = $records->getJoinWhere( "AND re.name = '$religion'");
    $notemptyReligon = count($ss);
}
?> 



<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Religious Affiliation by Sex | PRINT</title>
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
            <td colspan="8" style="text-align: center;border:none;"><h3>RELIGIOUS AFFILIATION OF THE TOTAL POPULATION BY SEX</h3></td>
        </tr>

        <tr>
            <td colspan="8" style="text-align: center;border:none;"><h3>
            <?php 
            if(!empty($religion)){
                if($sex == 'M'){
                    echo $religion; echo' (Male)';
                }
                if($sex == 'F'){
                    echo $religion; echo '(Female)';
                }
                if(empty($sex)){
                    echo $religion; echo' (All Sex)';
                }
            }
            if(empty($religion) && empty($sex))
            {
                echo 'ALL SEX : ALL RELIGION';
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
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">RELIGIOUS AFFILIATION</td>
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
            <td style="border:1px solid black;text-align:center;"><?php echo $i;?>.</td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['last_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['first_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['middle_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['qualifier'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['religion_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['gender'];?></td>
        </tr>
                                        
        <?php endforeach; ?>

       
        <tr>
            <td colspan="8" style="color:white;"> space</td>
        </tr>

       
        
        
    </table>
   

    
    <table style="width:50%">
        <tr>
            <td valign="top">
                <h5>SUMMARY BY SEX</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Sex</th>
                            <th>Count</th>
                                  
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                       
                    <?php 
                    if (empty($sex) || $sex == 'M')
                    {
                        echo 
                        '
                        <tr>
                                <td>
                               Male
                                </td>
                                <td class="t-center">
                                '.$male.'
                                </td>
              
                            </tr>
                        '
                        ;
                    }
                    if (empty($sex) || $sex == 'F')
                    {
                        echo 
                        '
                        <tr>
                                <td>
                               Female
                                </td>
                                <td class="t-center">
                                '.$female.'
                                </td>
              
                            </tr>
                        '
                        ;
                    }
                    ?>
                            
                            <tr>
                            <td class="b-600">TOTAL</td>
                                <td class="t-center">
                                <?php echo $total;?>    
                                </td>
                            </tr>
                           
                    </tbody>
                </table>
            </td>
            <td valign="top">
                <h5>RELIGION SUMMARY</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Religion</th>
                            <th>Count</th>                                                                                  
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                  
                        <?php
                            if(empty($religion) && empty($sex))
                            {
                                $total_r = 0;
                                foreach($groupByReligion AS $rows): 
                                $r_name = $rows['religion_name'];
                                $get = $records->getJoinWhere("AND re.name = '$r_name'");
                                $fin_r = count($get);
                                $total_r += (int)$fin_r;
                                echo 
                                    '
                                    <tr>
                                    <td>
                                    '.$r_name.'
                                    </td>
                                    <td class="t-center">
                                    '.$fin_r.'
                                    </td>
                                    </tr>
                                    '
                                    ;            
                        ?>

                            <?php endforeach; } ?>

                            <?php
                            if(empty($religion) && !empty($sex))
                            {
                                $total_r = 0;
                                foreach($groupByReligion AS $rows): 
                                $r_name = $rows['religion_name'];
                                $get = $records->getJoinWhere("AND re.name = '$r_name' AND p.gender = '$sex'");
                                $fin_r = count($get);
                                $total_r += (int)$fin_r;
                                echo 
                                    '
                                    <tr>
                                    <td>
                                    '.$r_name.'
                                    </td>
                                    <td class="t-center">
                                    '.$fin_r.'
                                    </td>
                                    </tr>
                                    '
                                    ;          
                        ?>

                            <?php endforeach; } ?>

                            <?php
                            if(!empty($religion) && empty($sex))
                            {
                                echo 
                                '
                                <tr>
                                <td>
                                '.$religion.'
                                </td>
                                <td class="t-center">
                                '.$notemptyReligon.'
                                </td>
                                </tr>
                                '
                                ;
                            }

                            ?>
                        
                        <tr>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600">
                            <?php 
                            if (empty($religion) && empty($sex))
                            {
                                echo $total_r;
                            }
                            if(!empty($religion))
                            {
                                if(empty($sex))
                                {
                                    echo $notemptyReligon;
                                }
                                if($sex == 'M')
                                {
                                    echo $total;
                                }
                                if($sex == 'F')
                                {
                                    echo $total;
                                }
                                
                            }
                            ?>
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