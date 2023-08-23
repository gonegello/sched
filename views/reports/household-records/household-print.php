<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Personal_info.php');
require (DOCUMENT_ROOT . '../models/Occupations.php');
require (DOCUMENT_ROOT . '../models/House_holds.php');

$helpers = new Helpers();

if (!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
 
$config         = new Config();
$personalinfo   = new Personal_info();
$occupations    = new Occupations();
$households     = new House_holds();

$householdid = isset($_GET['id']) ? $helpers->encryptDecrypt($_GET['id'], 'decrypt') : '';

if(!is_numeric($householdid)) {
    echo json_encode(['code' => 5, 'message' => 'You are not authorized to access this report.']);
    return;
}

//Validate household id
$reshousehold = $households->getHousehold(" AND id = $householdid");
if(empty($reshousehold)) {
    echo json_encode(['code' => 5, 'message' => 'You are not authorized to access this report.']);
    return;
}

$where = " AND pi.house_hold_id = $householdid AND pi.family_head = 'Y'";
$where .= " AND pi.status != 'D' AND hh.status != 'D' ";
$respersonalinfo = $personalinfo->getpersonalrecord($where);

$wheretotal = "AND house_hold_id = $householdid AND status != 'D'";
$householdsize = $personalinfo->getTotal($wheretotal);

?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Household Records | Print</title>
        <link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/print.css">
        <link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css”/>
    </head>
<style>
    body{
        font-family: Arial, Helvetica, sans-serif;        
        margin:0;
        font-size: 14px;
    }
    table, th, td {       
        padding:3px;  
    }
    table {
        border-spacing: 0px;
        margin:0;
        border-collapse: collapse;
    }
    td {
        width: 2%;
        text-align:center;        
    }

    .td-left {
        text-align: left;
    }

    .tr-border {
        border: 1px solid #000;
    }

    .td-border {
        border-left: 1px solid #000;
    }
    .td-border-bottom {
        border-bottom:1px solid black;
    }

    .report-wrapper {
        margin: 5px 5px 5px 5px; 
    }
     
</style>
<body>
    <div class="report-wrapper">
        <table>
            <tr>
                <td colspan="14" style="text-align: center;">HOUSEHOLD RECORDS OF BARANGAY INHABITANTS</td>
            </tr>

            <tr>
                <td colspan="14" style="color:white">space</td>
            </tr>
            <tr>
                <td class="td-left">A. REGION:</td>
                <td class="td-border-bottom td-left" colspan="3">
                    <?php echo $_SESSION['SESS_REG_CODE'] ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td class="td-left">A.1 PSGC:</td>
                <td colspan="3" class="td-border-bottom"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="td-left">PROVINCE:</td>
                <td class="td-border-bottom td-left" colspan="3">
                    <?php echo $_SESSION['SESS_PROV_DESC'] ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td class="td-left">B.1 PSGC:</td>
                <td colspan="3" class="td-border-bottom"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="td-left">MUNICIPALITY:</td>
                <td class="td-border-bottom td-left" colspan="3">
                    <?php echo $_SESSION['SESS_CITYMUN_DESC'] ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td class="td-left">C.1 PSGC:</td>
                <td colspan="3" class="td-border-bottom"></td> 
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="td-left">BARANGAY:</td>
                <td class="td-border-bottom td-left" colspan="3">
                    <?php echo $_SESSION['SESS_BRGY_DESC'] ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td class="td-left">D.1 PSGC:</td>
                <td colspan="3" class="td-border-bottom"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="td-left">HOUSEHOLD NO:</td>
                <td class="td-border-bottom td-left" colspan="3">
                    <?php echo $reshousehold['household_no'] ?>
                </td>
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
            </tr>
            <tr>
                <td class="td-left">HOUSEHOLD SIZE:</td>
                <td class="td-border-bottom td-left" colspan="3">
                    <?php echo $householdsize ?>
                </td>
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
            </tr>
            <tr>
                <td colspan="14" style="color:white">space</td>
            </tr>
            <tr>
                <td colspan="4" style="border:1px solid black;">NAME</td>
                <td colspan="3" style="border:1px solid black;border-left:none;">ADDRESS</td>
                <td rowspan="2" style="border-top:1px solid black;">PLACE OF BIRTH</td>
                <td rowspan="2" style="border-top:1px solid black;border-left:1px solid black;">DATE OF BIRTH</td>
                <td rowspan="2" style="border-top:1px solid black;border-left:1px solid black;">SEX</td>
                <td rowspan="2" style="border-top:1px solid black;border-left:1px solid black;">CIVIL STATUS</td>
                <td rowspan="2" style="border-top:1px solid black;border-left:1px solid black;">CITIZENSHIP</td>
                <td rowspan="2" style="border-top:1px solid black;border-left:1px solid black;">OCCUPATION</td>
                <td rowspan="2" style="border-top:1px solid black;border-right:1px solid black;border-left:1px solid black;">RELATIONSHIP TO</td>
            </tr>
            <tr>
                <td colspan="4" style="border-left:1px solid black;border-right:1px solid black;">(1)</td>
                <td colspan="3" style="border-right:1px solid black;">(2)</td>
                
            </tr>
            <tr>
                <td style="border:1px solid black;">LAST<br>(1.1)</td>
                <td style="border:1px solid black;border-left:none;">FIRST<br>(1.2)</td>
                <td style="border:1px solid black;border-left:none;">MIDDLE<br>(1.3)</td>
                <td style="border:1px solid black;border-left:none;">QUALIFIER<br>(1.4)</td>
                <td style="border:1px solid black;border-left:none;">NUMBER<br>(2.1)</td>
                <td style="border:1px solid black;border-left:none;">STREET NAME<br>(2.2)</td>
                <td style="border:1px solid black;border-left:none;">NAME OF SUB/ZONE/ SITIO/PUROK (if applicable)<br>(2.3) </td>
                <td style="border-bottom:1px solid black;vertical-align: top;">(3)</td>
                <td style="border-bottom:1px solid black;vertical-align: top;border-left:1px solid black;">(4)</td>
                <td style="border-bottom:1px solid black;vertical-align: top;border-left:1px solid black;">(5)</td>
                <td style="border-bottom:1px solid black;vertical-align: top;border-left:1px solid black;">(6)</td>
                <td style="border-bottom:1px solid black;vertical-align: top;border-left:1px solid black;">(7)</td>
                <td style="border-bottom:1px solid black;vertical-align: top;border-left:1px solid black;">(8)</td>
                <td style="border-bottom:1px solid black;border-right:1px solid black;vertical-align: top;border-left:1px solid black;">HOUSEHOLD HEAD<br>(9)</td>
            </tr>
            <?php foreach ($respersonalinfo as $row) : 
                
                $occupationname = '';
                if (!empty($row['occupation'])) {
                    $resoccupationname = $occupations->getoccupationname(" AND id IN(" . $row['occupation'] . ")");
                    $occupationname = $resoccupationname['name'];
                }

                $where = " AND pi.house_hold_id = $householdid AND pi.family_head_id = " . $row['personal_info_id'];
                $where .= " AND pi.status != 'D' AND hh.status != 'D' ";
                $resgetmembers = $personalinfo->getpersonalrecord($where);

                ?>
                <tr class="tr-border">
                    <td class="td-border">
                        <?php echo $row['last_name'] ?>
                    </td>
                    <td class="td-border">
                        <?php echo $row['first_name'] ?>
                    </td>
                    <td class="td-border">
                        <?php echo $row['middle_name'] ?>
                    </td>
                    <td class="td-border">
                        <?php echo $row['qualifier'] ?>
                    </td>
                    <td class="td-border" colspan="3">
                        <?php echo $row['no_street_sitio_purok'] ?>
                    </td>
                    <td class="td-border">
                        <?php echo $row['birth_place'] ?>
                    </td>
                    <td class="td-border">
                        <?php echo date('M d, Y', strtotime($row['birthdate'])) ?>
                    </td>
                    <td class="td-border">
                        <?php echo $row['gender'] ?>
                    </td>
                    <td class="td-border">
                        <?php echo $row['civil_status_name'] ?>
                    </td>
                    <td class="td-border">
                        <?php echo $row['citizenship_name'] ?>
                    </td>
                    <td class="td-border">
                        <?php echo $occupationname ?>
                    </td>
                    <td class="td-border">
                        <?php echo ($row['family_head'] == 'Y') ? 'Head' : $row['household_head_relationship_name'] ?>
                    </td>
                </tr>
                <?php foreach ($resgetmembers AS $row_m) :

                        $occupationname = '';
                        if (!empty($row_m['occupation'])) {
                            $resoccupationname = $occupations->getoccupationname(" AND id IN(" . $row_m['occupation'] . ")");
                            $occupationname = $resoccupationname['name'];
                        }
                    ?>
                    <tr class="tr-border">
                        <td class="td-border">
                            <?php echo $row_m['last_name'] ?>
                        </td>
                        <td class="td-border">
                            <?php echo $row_m['first_name'] ?>
                        </td>
                        <td class="td-border">
                            <?php echo $row_m['middle_name'] ?>
                        </td>
                        <td class="td-border">
                            <?php echo $row_m['qualifier'] ?>
                        </td>
                        <td class="td-border" colspan="3">
                            <?php echo $row_m['no_street_sitio_purok'] ?>
                        </td>
                        <td class="td-border">
                            <?php echo $row_m['birth_place'] ?>
                        </td>
                        <td class="td-border">
                            <?php echo date('M d, Y', strtotime($row_m['birthdate'])) ?>
                        </td>
                        <td class="td-border">
                            <?php echo $row_m['gender'] ?>
                        </td>
                        <td class="td-border">
                            <?php echo $row_m['civil_status_name'] ?>
                        </td>
                        <td class="td-border">
                            <?php echo $row_m['citizenship_name'] ?>
                        </td>
                        <td class="td-border">
                            <?php echo $occupationname ?>
                        </td>
                        <td class="td-border">
                            <?php echo $row_m['household_head_relationship_name'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <tr>
                <td style="color:white;">space here</td>
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
            </tr>
            <tr>
                <td colspan="14" style="color:white">space</td>
            </tr>
            <tr>
                <td colspan="14" style="text-align:left;" >Legend:</td>
            </tr>
            <tr>
                <td colspan="14" style="text-align:left;"><b>PSGC:</b> Philippine Standard Geographic Code shall be made available by the DILG City/Municipal Offices</td>
            </tr>
            <tr>
                <td colspan="14" style="text-align:left;"><b>HOUSEHOLD</b> is a social unit consisting of a person living alone or a group of persons who<br>
                <span>1) sleep in the same housing unit; and 2) have a common arrangement in the preparation and consumption of food</span>
            </td>
            </tr>
            <tr>
                <td colspan="14" style="text-align:left;"><b>QUALIFIER</b> is the addition and/or inclusion of the word "JR.", "SR.", "II", etc. as the case maybe after the person's surname(s)</td>
            </tr>
            <tr>
                <td style="text-align:left;">Prepared By:</td>
                <td colspan="2" style="border-bottom: 1px solid black;"></td>
                <td></td>
                <td colspan="2" style="text-align:left;">Certified Correct:</td>
                <td></td>
                <td colspan="3" style="border-bottom: 1px solid black;"></td>
                <td></td>
                <td style="text-align:left;">Validated By:</td>
                <td colspan="2" style="border-bottom: 1px solid black;"></td>
            </tr>
        </table>
    </div>  
  
</body>
</html>