<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Reports.php');
require (DOCUMENT_ROOT . '../models/Personal_info.php');
 
$helpers = new Helpers();
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$records = new Reports();
$personal_info = new Personal_info();
$config = new Config();
$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];

$resRecords = $records->getVaccinationInfo();


$date_today = date("F d, Y");

#A. TOTAL NO. OF BARANGAY INHABITANTS AGED 12 -17 YEARS OLD, ELIGIBLE FOR VACCINATION:
$eligible_12_17 = $personal_info->getJoinWhere( "  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 12 AND 17 )");
$a = count($eligible_12_17);

#B. TOTAL NO. OF BARANGAY INHABITANTS AGED 18 YEARS AND ABOVE, ELIGIBLE FOR VACCINATION:
$eligible_18_above = $personal_info->getJoinWhere( "  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 18 AND 100 )");
$b = count($eligible_18_above);

#C. TOTAL NO. OF BARANGAY INHABITANTS AGED 12 YEARS AND ABOVE, ELIGIBLE FOR VACCINATION:
$eligible_12_above = $personal_info->getJoinWhere( "  AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 12 AND 100 )");
$c = count($eligible_12_above);

#F. TOTAL NO. OF PARTIALLY VACCINATED INDIVIDUALS AGED 12 YEARS AND ABOVE:
#step 1: get vacc info having first_dose and vacc name is not J&J
$partially_12_above = $records->getFullyVaccinated( "  AND vi.dose_type = 'F' AND cv.name != 'J&J' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 12 AND 100 )");
$part_1 = count($partially_12_above); #step 2:count all vacc info with first_dose and J&J
$part_2 = 0;
foreach($partially_12_above AS $row):
        #step 3: loop vacc info and get their personal_info_id
       $p_id = $row['per_id'];
       #step 4: using personal_info_id, get if they also have second dose info
       $no_second_dose = $records->getFullyVaccinated("  AND vi.dose_type = 'S' AND vi.personal_info_id = $p_id AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
       + 0 BETWEEN 12 AND 100 )");
       $cc = count($no_second_dose);
       #step 5: total count of vacc info having first (but not J&J brand) and second dose
       $part_2 +=$cc;
endforeach;  
#step 6: to get the total no. of partially vacc individuals aged 12 years and above                              
$f = (int)$part_1 - (int)$part_2;

#H. TOTAL NO. OF FULLY VACCINATED INDIVIDUALS AGED 12-17 YEARS:
$fullvac_12_17_secondose = $records->getFullyVaccinated( " AND vi.dose_type = 'S' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 12 AND 17 )");
$fullvac_12_17_jensen = $records->getFullyVaccinated( " AND cv.name = 'J&J' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 12 AND 17 )");
$s_d_12_17 = count($fullvac_12_17_secondose);
$jensen_12_17 = count($fullvac_12_17_jensen);
 
$h = (int)$s_d_12_17 + (int)$jensen_12_17;

#J. TOTAL NO. OF FULLY VACCINATED INDIVIDUALS AGED 18 YEARS AND ABOVE
$fullvac_18_above_sd = $records->getFullyVaccinated( " AND vi.dose_type = 'S' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 18 AND 100 )");
$fullvac_18_above_jensen = $records->getFullyVaccinated( " AND cv.name = 'J&J' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 18 AND 100 )");
$s_d_18 = count($fullvac_18_above_sd);
$jensen_18_above = count($fullvac_18_above_jensen);
$j = (int)$s_d_18 + (int)$jensen_18_above;

#N. TOTAL NO. OF INDIVIDUALS AGED 18 YEARS AND ABOVE WITH BOOSTER SHOT:
$fullvac_booster_18_above = $records->getFullyVaccinated( " AND vi.dose_type = 'B' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 18 AND 100 )");
$n = count($fullvac_booster_18_above);
#abcdfhjln
#Formula: L = H + J
$l = (int)$h + (int)$j;

#Formula: D = C - (F + L)
$d = (int)$c - ((int)$f + (int)$l);

#Formula: E = D/C x 100

$e = round((int)$d / (int)$c * 100);

#	Formula: G = F/C x 100
$g = round((int)$f / (int)$c * 100);

#	Formula: I= H/A x 100
$i = !empty($a) ? ((int)$h / (int)$a) * 100 : 0.00;

#	Formula: K= J/B x 100
$k = round((int)$j / (int)$b * 100);

#	Formula: M = L/C x 100
$m = round((int)$l / (int)$c * 100);

#Formula: O = N/J x 100
$o = round((int)$n / (int)$j * 100);
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccination Report (Consolidated) | PRINT</title>
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
  
font-size:10px;
}
.data{
color:blue;
border:1px solid black;
font-style: italic;
}
.footer{
    background-color: peachpuff;
    border:1px solid black;
}
     
</style>
<body>
    <table>
        <tr>
            <td colspan="13" style="text-align: left;border:none;font-size:14px;"><h4>BARANGAY MONTHLY INVENTORY OF VACCINATED POPULATION</h4></td>
        </tr>
        <tr>
            <td colspan="3">REGION: <?php echo $region;?></td>
        </tr>
        <tr>
            <td colspan="3">PROVINCE: <?php echo $prov_name;?></td>
        </tr>
        <tr>
            <td colspan="3">CITY/MUNICIPALITY: <?php echo $municipal_name;?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-transform: uppercase;">BARANGAY: <?php echo $brgy_name;?></td>
        </tr>
        <tr><td colspan="13" style="color:transparent;">0</td></tr>
        <tr>
            <td colspan="3" style="text-align:center;border:1px solid black;background-color:blanchedalmond;font-weight:bold;">SUMMARY</td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">A. TOTAL NO. OF BARANGAY INHABITANTS AGED<br>12 -17 YEARS OLD, ELIGIBLE FOR VACCINATION:</td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $a;?></td>
            <td></td>
            <td rowspan="2" colspan="8" style="font-style: italic;font-size:8px;background-color:papayawhip;">* Note: Input data for items A and B which may be 
            sourced from the Registry of Barangay Inhabitants (RBI) which is updated every six months,<br> 
            or from the 2020 Census of Population and Housing (2020 CPH) of the Philippine Statistics Authority (PSA).</td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">B. TOTAL NO. OF BARANGAY INHABITANTS<br>
            AGED 18 YEARS AND ABOVE, ELIGIBLE FOR<br>VACCINATION: </td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $b;?></td>
            <td></td>
            
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">C. TOTAL NO. OF BARANGAY INHABITANTS<br>
            AGED 12 YEARS AND ABOVE, ELIGIBLE FOR<br> VACCINATION: </td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $c;?></td>
            <td></td>
            <td colspan="2" style="font-style: italic;font-size:8px;">Formula: C = A + B</td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">D. TOTAL NO. OF UNVACCINATED INDIVIDUALS<br>AGED 
            12 YEARS AND ABOVE: </td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $d;?></td>
            <td></td>
            <td colspan="2" style="font-style: italic;font-size:8px;">Formula: D = C - (F + L)</td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">E. PERCENTAGE OF UNVACCINATED INDIVIDUALS<br>AGED 
            12 YEARS AND ABOVE: </td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $e;?>%</td>
            <td></td>
            <td colspan="2" style="font-style: italic;font-size:8px;">Formula: E = D/C x 100</td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">F. TOTAL NO. OF PARTIALLY VACCINATED<br>INDIVIDUALS 
            AGED 12 YEARS AND ABOVE: </td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $f;?></td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">G. PERCENTAGE OF PARTIALLY VACCINATED<br>INDIVIDUALS
            AGED 12 YEARS AND ABOVE:</td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $g;?>%</td>
            <td></td>
            <td colspan="2" style="font-style: italic;font-size:8px;">Formula: G = F/C x 100</td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">H. TOTAL NO. OF FULLY VACCINATED<br>INDIVIDUALS 
            AGED 12-17 YEARS:</td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $h;?></td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">I. PERCENTAGE OF FULLY VACCINATED<br>INDIVIDUALS 
            AGED 12-17 YEARS:</td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $i; ?>%</td>
            <td></td>
            <td colspan="2" style="font-style: italic;font-size:8px;">Formula: I= H/A x 100</td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">J. TOTAL NO. OF FULLY VACCINATED<br>INDIVIDUALS 
            AGED 18 YEARS AND ABOVE</td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $j;?></td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">K. PERCENTAGE OF FULLY VACCINATED<br>INDIVIDUALS 
            AGED 18 YEARS AND ABOVE:</td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $k;?>%</td>
            <td></td>
            <td colspan="2" style="font-style: italic;font-size:8px;">Formula: K= J/B x 100</td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">L. TOTAL NO. OF FULLY VACCINATED<br>INDIVIDUALS 
            AGED 12 YEARS AND ABOVE:</td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $l;?></td>
            <td></td>
            <td colspan="2" style="font-style: italic;font-size:8px;">Formula: L = H + J</td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">M. PERCENTAGE OF FULLY VACCINATED<br>INDIVIDUALS 
            AGED 12 YEARS AND ABOVE:</td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $m;?>%</td>
            <td></td>
            <td colspan="2" style="font-style: italic;font-size:8px;">Formula: M = L/C x 100</td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">N. TOTAL NO. OF INDIVIDUALS AGED 18 YEARS<br>AND ABOVE WITH BOOSTER SHOT:</td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $n;?></td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;">O. PERCENTAGE OF INDIVIDUALS AGED 18 YEARS<br>AND ABOVE WITH BOOSTER SHOT: </td>
            <td style="border:1px solid black;background-color:blanchedalmond;font-weight:bold;text-align:center;"><?php echo $o;?>%</td>
            <td></td>
            <td colspan="2" style="font-style: italic;font-size:8px;">Formula: O = N/J x 100</td>
        </tr>
        <tr><td colspan="13" style="color:transparent;">0</td></tr>
        <tr><td colspan="2" style="font-weight: bold;">AS OF (insert date): <?php echo $date_today;?> </td></tr>
        <tr><td colspan="13" style="color:transparent;">0</td></tr>
        <tr><td colspan="13" style="color:transparent;">0</td></tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">Prepared by</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" style="font-weight: bold;">Approved by</td>
        </tr>
        <tr><td colspan="13" style="color:transparent;">0</td></tr>
        <tr><td colspan="13" style="color:transparent;">0</td></tr>
        <tr>
            <td colspan="3" style="font-weight: bold;">Name and Signature of Barangay Secretary/Health Worker</td>
            <td></td>
            <td></td>
            <td colspan="3" style="font-weight: bold;">Name and Signature of Punong Barangay</td>
        </tr>
        <tr><td colspan="13" style="color:transparent;">0</td></tr>
        <tr><td colspan="13" style="color:transparent;">0</td></tr>
        <tr>
            <td rowspan="3" style="text-align: center;border:1px solid black;">No.</td>
            <td rowspan="3" style="text-align: center;border:1px solid black;">Full Name of Partially or Fully Vaccinated Barangay<br>Inhabitants<br>
            Aged 12 Y/O and Above</td>
            <td rowspan="3" style="text-align: center;border:1px solid black;">Birthday</td>
            <td rowspan="3" style="text-align: center;border:1px solid black;">Age</td>
            <td colspan="3" style="text-align: center;border:1px solid black;">PRIMARY SERIES OF COVID-19 VACCINE<br>
            (Note: 1. If brand is "Janssen, put NA in the column for<br>"2nd Dose"; Put "None" if unvaccinated)</td>
            <td rowspan="3" style="text-align: center;border:1px solid black;">Partially vaccinated?<br>(Type 1 if Yes ;<br>0 if No)</td>
            <td rowspan="3" style="text-align: center;border:1px solid black;">Fully Vaccinated<br>12-17 years old?<br>(Type 1 if Yes ;<br>0 if No)</td>
            <td rowspan="3" style="text-align: center;border:1px solid black;">Fully Vaccinated<br>18 years old and<br>above? (Type 1 if<br>Yes ;<br>
            0 if No)</td>
            <td colspan="3" style="text-align: center;border:1px solid black;">BOOSTER DOSE</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;border:1px solid black;">Date of Vaccination</td>
            <td rowspan="2" style="text-align: center;border:1px solid black;">Brand</td>
            <td rowspan="2" style="text-align:center;border:1px solid black;">Individuals 18 years<br>old and above with<br>Booster Shot?<br>
            (Type 1 if Yes;<br> 
            0 if No; NA if 12-17 Y/O)<br></td>
            <td rowspan="2" style="text-align:center;border:1px solid black;">Date of<br>Vaccination<br>(Booster Shot)</td>
            <td rowspan="2" style="text-align:center;border:1px solid black;">Brand</td>
            
        </tr>
      
        <tr>
            <td style="text-align: center;border:1px solid black;">1st Dose</td>
            <td style="text-align: center;border:1px solid black;">2nd Dose</td>
        </tr>
        <tr>
      

      <?php 
      $i = 0;
      foreach($resRecords AS $row): $i++;
      ?>
            <td class="data"><?php echo $i;?>.</td>
            <td class="data"><?php echo $row['last_name']; echo ','; echo $row['first_name'];?></td>
            <td class="data" style="text-align: right;">
            <?php 
            $birthdate = $row['birthdate'];
            $dd = date_create($birthdate);
            $bday = date_format($dd,"m/d/Y");
            echo $bday;
            ?></td>
            <td class="data" style="text-align: center;"><?php echo $row['age'];?></td>
            <td class="data" style="text-align: center;">
            <?php
            $per_id = $row['per_id'];
            $resData = $records->individualVacInfo("AND vi.dose_type = 'F' AND vi.personal_info_id = $per_id ");
            if(!empty($resData))
            {
                $vacc_date = $resData['vaccination_date'];
                $dose_type = $resData['dose_type'];
                $create_f = date_create($vacc_date);
                $first_dose_date = date_format($create_f,"m/d/Y");
                echo $first_dose_date;
            }
                ?>
            </td>
            <td class="data" style="text-align: center;">
            <?php
            $resData_2 = $records->individualVacInfo("AND vi.dose_type = 'S' AND vi.personal_info_id = $row[per_id] ");
            if(!empty($resData_2))
            {
                $vacc_date_2 = $resData_2['vaccination_date'];
                $dose_type_2 = $resData_2['dose_type'];
                $create_s= date_create($vacc_date_2);
                $second_dose_date = date_format($create_s,"m/d/Y");
                echo $second_dose_date;
            }
            
            ?>
            </td>
            <td class="data" style="text-align: center;"><?php echo $row['brand'];?></td>
            <td class="data" style="text-align: center;">
            <?php
            
            $resData_J = $records->individualVacInfo("AND vi.dose_type = 'S' AND vi.personal_info_id = $row[per_id]");

            if(empty($resData_J) && $row['brand'] == 'J&J' || !empty($resData_J) && $row['brand'] != 'J&J')
            {
                echo '0'; //fully vac
                
            }
            if(empty($resData_J) && $row['brand'] != 'J&J')
            {
                
                echo '1';
               
                
            }
           
            //Partially
           
            ?>
            </td>
            <td class="data" style="text-align: center;">
                <?php
                //fully_vaccinated 12 -17
               $resData_3 = $records->individualVacInfo("AND vi.dose_type = 'S' AND vi.personal_info_id = $row[per_id]");


                if($row['age'] >=12 && $row['age'] <= 17)
                {
                    if($row['dose_type'] == 'F' && $row['brand'] == 'J&J')
                    {
                            echo '1';
                    }
                    if(!empty($resData_3))
                    {
                        echo '1';
                    }
                    
                }
                else{
                    echo '0';
                }
               
                ?>
            </td>
            <td class="data" style="text-align: center;">
            <?php
               $resData_4 = $records->individualVacInfo("AND vi.dose_type = 'S' AND vi.personal_info_id = $row[per_id]");
               if($row['age'] >= 18)
               {
                    if($row['dose_type'] == 'F' && $row['brand'] == 'J&J')
                    {
                        echo '1';
                    }
                    if(!empty($resData_4))
                    {
                        echo '1';
                    }
                    if(empty($resData_4) && $row['brand'] != 'J&J')
                    {
                        echo '0';
                    }  
               }
               else{
                echo '0';
               }
                ?>
            </td>
            <td class="data" style="text-align: center;">
            <?php
                $resData_5 = $records->individualVacInfo("AND vi.dose_type = 'B' AND vi.personal_info_id = $row[per_id]
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
                + 0 BETWEEN 18 AND 100 ) ");

                if($row['age'] >= 18)
                {
                    if(!empty($resData_5))
                    {
                        echo '1';
                    }
                    else{
                        echo '0';
                    }

                }
                if($row['age'] < 18)
                {
                    echo 'NA';
                }
                
                ?>
            </td>
            <td class="data" style="text-align: center;">
            <?php
            $resData_6 = $records->individualVacInfo("AND vi.dose_type = 'B' AND vi.personal_info_id = $row[per_id]
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 18 AND 100 ) ");

            if($row['age'] >= 18)
            {
                if(!empty($resData_6))
                {

                    $booster_date = $resData_6['vaccination_date'];
                    $create_b= date_create($booster_date);
                    $booster_d = date_format($create_b,"m/d/Y");
                echo $booster_d;
                    
                }

            }
            ?>
            </td>
            <td class="data">
            <?php
            $resData_7 = $records->individualVacInfo("AND vi.dose_type = 'B' AND vi.personal_info_id = $row[per_id]
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 18 AND 100 ) ");

            if($row['age'] >= 18)
            {
                if(!empty($resData_7))
                {
                    $brand_7 = $resData_7['brand'];
                echo $brand_7;
                    
                }

            }
            ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td class="footer"></td>
            <td class="footer" style="text-align: right;font-weight:bold;">TOTAL</td>
            <td class="footer"></td>
            <td class="footer"></td>
            <td class="footer"></td>
            <td class="footer"></td>
            <td class="footer"></td>
            <td class="footer" style="text-align: center;"><?php echo $f;?></td>
            <td class="footer" style="text-align: center;"><?php echo $h;?></td>
            <td class="footer" style="text-align: center;"><?php echo $j;?></td>
            <td class="footer" style="text-align:center;"><?php echo $n;?></td>
            <td class="footer"></td>
            <td class="footer"></td>

        </tr>



        
       
    </table>
   

    
  
</body>
</html>