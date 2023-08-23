<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Reports.php');
 
$helpers = new Helpers();

$sex = $_GET['sex'];
$marital_status = $_GET['marital'];
//$type_val = $_GET['bracket'];
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


//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");
$brgysecretary = $brgysec['value'];

if(empty($sex) && empty($marital_status))
{
    $resRecords = $records->getJoinWhere();

    #SINGLE
    #MALE
    $sing_m = $records->getJoinWhere(" AND cs.name = 'Single' AND gender = 'M'");
    $male_single = count($sing_m);
    #FEMALE
    $sing_f = $records->getJoinWhere(" AND cs.name = 'Single' AND gender = 'F'");
    $female_single = count($sing_f);

    $single_total = (int)$male_single + (int)$female_single;
    
    #MARRIED
    #MALE
    $mar_m = $records->getJoinWhere(" AND cs.name = 'Married' AND gender = 'M'");
    $male_married = count($mar_m);
    #FEMALE
    $mar_f = $records->getJoinWhere(" AND cs.name = 'Married' AND gender = 'F'");
    $female_married = count($mar_f);

    $married_total = (int)$male_married + (int)$female_married;

    #SEPARATED
    #MALE
    $sep_m = $records->getJoinWhere(" AND cs.name = 'Separated' AND gender = 'M'");
    $male_separated = count($sep_m);
    #FEMALE
    $sep_f = $records->getJoinWhere(" AND cs.name = 'Separated' AND gender = 'F'");
    $female_separated = count($sep_f);

    $separated_total = (int)$male_separated + (int)$female_separated;

    #WIDOWER
    #MALE
    $wid_m = $records->getJoinWhere(" AND cs.name = 'Separated' AND gender = 'M'");
    $male_widower = count($wid_m);
    #FEMALE
    $wid_f = $records->getJoinWhere(" AND cs.name = 'Separated' AND gender = 'F'");
    $female_widower = count($wid_f);

    $widower_total = (int)$male_widower + (int)$female_widower;


}
if(!empty($marital_status))
{
    if($sex == 'F'){
        $resRecords = $records->getJoinWhere(" AND cs.name = '$marital_status' AND gender = 'F'");

        $reSult = count($resRecords);

    }
    if($sex == 'M'){
        $resRecords = $records->getJoinWhere(" AND cs.name = '$marital_status' AND gender = 'M'");

        $reSult = count($resRecords);
    }
    if(empty($sex))
    {
        $resRecords = $records->getJoinWhere(" AND cs.name = '$marital_status'");

        #MALE
        $status_1 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND gender = 'M'");
        $male_status = count($status_1);
        #FEMALE

        $status_2 = $records->getJoinWhere(" AND cs.name = '$marital_status' AND gender = 'F'");
        $female_status = count($status_2);

        $total_status = (int)$male_status + (int)$female_status;

        
    }
}

if(empty($marital_status)){
    if($sex == 'F'){
        $resRecords = $records->getJoinWhere(" AND gender = 'F'");

        #FEMALE
        $sing_f = $records->getJoinWhere(" AND cs.name = 'Single' AND gender = 'F'");
        $female_single = count($sing_f);

        $mar_f = $records->getJoinWhere(" AND cs.name = 'Married' AND gender = 'F'");
        $female_married = count($mar_f);

        $sep_f = $records->getJoinWhere(" AND cs.name = 'Separated' AND gender = 'F'");
        $female_separated = count($sep_f);

        $wid_f = $records->getJoinWhere(" AND cs.name = 'Separated' AND gender = 'F'");
        $female_widower = count($wid_f);

    }
    if($sex == 'M'){
        $resRecords = $records->getJoinWhere(" AND gender = 'M'");

        #SINGLE
        #MALE
        $sing_m = $records->getJoinWhere(" AND cs.name = 'Single' AND gender = 'M'");
        $male_single = count($sing_m);

        #MARRIED
        #MALE
        $mar_m = $records->getJoinWhere(" AND cs.name = 'Married' AND gender = 'M'");
        $male_married = count($mar_m);

        #SEPARATED
        #MALE
        $sep_m = $records->getJoinWhere(" AND cs.name = 'Separated' AND gender = 'M'");
        $male_separated = count($sep_m);

        #WIDOWER
        #MALE
        $wid_m = $records->getJoinWhere(" AND cs.name = 'Separated' AND gender = 'M'");
        $male_widower = count($wid_m);
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
    <title>Marital Status By Sex | PRINT</title>
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
            <td colspan="8" style="text-align: center;border:none;"><h3>MARITAL STATUS OF THE TOTAL POPULATION BY SEX</h3></td>
        </tr>

        <tr>
            <td colspan="8" style="text-align: center;border:none;"><h3>
            <?php 
            if(empty($marital_status) && empty($sex)){
                echo 'All Records';
            }
            if(empty($marital_status)){
                if($sex == 'M'){
                    echo 'All Status (Male)';
                }
                if($sex == 'F'){
                    echo 'All Status (Female)';
                }
            }
            if(!empty($marital_status)){
                if($sex == 'M'){
                    echo $marital_status; echo' (Male)';
                }
                if($sex == 'F'){
                    echo $marital_status; echo' (Female)';
                }
                if(empty($sex)){
                    echo $marital_status; echo' (All Sex)';
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
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
        <tr>
            <td rowspan="2" style="text-align:center;width:1%;border:1px solid black;font-weight:bold;">NO.</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" colspan="4" >FULL NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">MARITAL STATUS</td>
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
            <td style="border:1px solid black;text-align:center;"><?php echo $row['civil_name'];?></td>
            <td style="border:1px solid black;text-align:center;"><?php echo $row['gender'];?></td>
        </tr>
                                        
        <?php endforeach; ?>
        <tr>
            <td colspan="8" style="color:white;"> space</td>
        </tr>
    </table>

    <table style="width:10%;">
        <tr>
            <td valign = "top"></td>
            <h5>MARITAL STATUS SUMMARY BY AGE</h5>
            <table class="households-type" style="width:50%;">
                <thead class="thead-households-type">
                <?php
                    if(empty($marital_status)){
                        echo
                        '
                        <th></th>
                        <th>Single</th>
                        <th>Married</th>
                        <th>Separated</th>
                        <th>Widower</th>
                        '
                        ;
                    }

                    if(!empty($marital_status)){
                        echo
                        '
                        <th></th>
                        <th>'.$marital_status.'</th>
                        '
                        ;
                    }

            ?>
                </thead>

                <tbody class="tbody-households-type">
                
                <?php

                if(empty($marital_status) && empty($sex)){
                    echo
                    '
                    <tr>
                    <td>Male</td>
                    <td class="t-center">'.$male_single.'</td>
                    <td class="t-center">'.$male_married.'</td>
                    <td class="t-center">'.$male_separated.'</td>
                    <td class="t-center">'.$male_widower.'</td>
                    </tr>
                    '
                    ;
                }
                if(!empty($marital_status)){
                        if($sex == 'M'){
                            echo
                            '
                            <tr>
                            <td>Male</td>
                            <td class="t-center">'.$reSult.'</td>
                            </tr>
                            '
                            ;
                        }
                        if(empty($sex)){
                            echo
                            '
                            <tr>
                            <td>Male</td>
                            <td class="t-center">'.$male_status.'</td>
                            </tr>
                            '
                            ;
                        }
                }

                if(empty($marital_status)){
                    if($sex == 'M'){
                        echo
                        '
                        <tr>
                        <td>Male</td>
                        <td class="t-center">'.$male_single.'</td>
                        <td class="t-center">'.$male_married.'</td>
                        <td class="t-center">'.$male_separated.'</td>
                        <td class="t-center">'.$male_widower.'</td>
                        </tr>
                        '
                        ;
                    }      
                }

                ?>  

                <?php

                if(empty($marital_status) && empty($sex)){
                    echo
                    '
                    <tr>
                    <td>Female</td>
                    <td class="t-center">'.$female_single.'</td>
                    <td class="t-center">'.$female_married.'</td>
                    <td class="t-center">'.$female_separated.'</td>
                    <td class="t-center">'.$female_widower.'</td>
                    </tr>
                    '
                    ;
                }
                    
                    if(!empty($marital_status)){
                        if($sex == 'F'){
                            echo
                            '
                            <tr>
                            <td>Female</td>
                            <td class="t-center">'.$reSult.'</td>
                            </tr>
                            '
                            ;
                        }

                        if(empty($sex)){
                            echo
                            '
                            <tr>
                            <td>Female</td>
                            <td class="t-center">'.$female_status.'</td>
                            </tr>
                            '
                            ;
                        }
                    }

                    if(empty($marital_status)){
                        if($sex == 'F'){
                            echo
                            '
                            <tr>
                            <td>Female</td>
                            <td class="t-center">'.$female_single.'</td>
                            <td class="t-center">'.$female_married.'</td>
                            <td class="t-center">'.$female_separated.'</td>
                            <td class="t-center">'.$female_widower.'</td>
                            </tr>
                            '
                            ;
                        }      
                    }
                    ?>

                        <tr>
                        
                        <?php
                        if(empty($marital_status) && empty($sex)){

                            echo
                            '<td class="b-600">TOTAL</td>
                            <td class="t-center">'.$single_total.'</td>
                            <td class="t-center">'.$married_total.'</td>
                            <td class="t-center">'.$separated_total.'</td>
                            <td class="t-center">'.$widower_total.'</td>
                            '
                            ;
                        }
                        if(!empty($marital_status) && !empty($sex))
                        {
                            echo
                            '<td class="b-600">TOTAL</td>
                            <td class="t-center">'.$reSult.'</td>
                            '
                            ;

                        }
                        if(!empty($marital_status) && empty($sex)){
                            echo
                            '<td class="b-600">TOTAL</td>
                            <td class="t-center">'.$total_status.'</td>
                            '
                            ;
                        }
                        ?>
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