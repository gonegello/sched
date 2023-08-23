<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Reports.php');
require (DOCUMENT_ROOT . '../models/Educational_info.php');


$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$education = isset($_GET['highest_name']) ? $_GET['highest_name'] : '';
$sex = isset($_GET['sex']) ? $_GET['sex'] : '';
$age = isset($_GET['age']) ? $_GET['age'] : '';

$config = new Config();
$records = new Reports();
$educationalinfo = new Educational_info();


if(!empty($education)){
    if(!empty($sex)) #if not empty type - not empty sex - not empty age
    {
        if($age == '0-6')
        {

        $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND hloe.name = '$education'
        AND educ.highest_level_of_education_id IS NOT NULL
        AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");

            if($sex == 'M')
            {
                $mm = $records->getJoinWhere(" AND gender = 'M' AND hloe.name = '$education'
                AND educ.highest_level_of_education_id IS NOT NULL
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
                $male = count($mm);
            }
            if($sex == 'F')
            {
                $ff = $records->getJoinWhere(" AND gender = 'F' AND hloe.name = '$education'
                AND educ.highest_level_of_education_id IS NOT NULL
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
                $female = count($ff);
            }
        }
        if($age == '7-12')
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND hloe.name = '$education'
            AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 7 AND 12 )");
            $count = count($resRecords);

            if($sex == 'M')
            {
                $mm = $records->getJoinWhere(" AND gender = 'M' AND hloe.name = '$education'
                AND educ.highest_level_of_education_id IS NOT NULL
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 7 AND 12 )");
                $male = count($mm);
            }
            if($sex == 'F')
            {
                $ff = $records->getJoinWhere(" AND gender = 'F' AND hloe.name = '$education'
                AND educ.highest_level_of_education_id IS NOT NULL
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 7 AND 12 )");
                $female = count($ff);
            }
        }
        if($age == '13-19')
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND hloe.name = '$education'
            AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 13 AND 19 )");
            $count = count($resRecords);

            if($sex == 'M')
            {
                $mm = $records->getJoinWhere(" AND gender = 'M' AND hloe.name = '$education'
                AND educ.highest_level_of_education_id IS NOT NULL
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 13 AND 19 )");
                $male = count($mm);
            }
            if($sex == 'F')
            {
                $ff = $records->getJoinWhere(" AND gender = 'F' AND hloe.name = '$education'
                AND educ.highest_level_of_education_id IS NOT NULL
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 13 AND 19 )");
                $female = count($ff);
            }

        }
        if($age == '20-30')
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND hloe.name = '$education'
            AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 20 AND 30 )");
            $count = count($resRecords);

            if($sex == 'M')
            {
                $mm = $records->getJoinWhere(" AND gender = 'M' AND hloe.name = '$education'
                AND educ.highest_level_of_education_id IS NOT NULL
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 20 AND 30 )");
                $male = count($mm);
            }
            if($sex == 'F')
            {
                $ff = $records->getJoinWhere(" AND gender = 'F' AND hloe.name = '$education'
                AND educ.highest_level_of_education_id IS NOT NULL
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 20 AND 30 )");
                $female = count($ff);
            }
        }
        if($age == '31-59')
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND hloe.name = '$education'
            AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 31 AND 59 )");
            $count = count($resRecords);

            if($sex == 'M')
            {
                $mm = $records->getJoinWhere(" AND gender = 'M' AND hloe.name = '$education'
                AND educ.highest_level_of_education_id IS NOT NULL
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 31 AND 59 )");
                $male = count($mm);
            }
            if($sex == 'F')
            {
                $ff = $records->getJoinWhere(" AND gender = 'F' AND hloe.name = '$education'
                AND educ.highest_level_of_education_id IS NOT NULL
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 31 AND 59 )");
                $female = count($ff);
            }
        }
        if($age == '60')
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND hloe.name = '$education'
            AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 60 AND 100 )");
            $count = count($resRecords);

            if($sex == 'M')
            {
                $mm = $records->getJoinWhere(" AND gender = 'M' AND hloe.name = '$education'
                AND educ.highest_level_of_education_id IS NOT NULL
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 60 AND 100 )");
                $male = count($mm);
            }
            if($sex == 'F')
            {
                $ff = $records->getJoinWhere(" AND gender = 'F' AND hloe.name = '$education'
                AND educ.highest_level_of_education_id IS NOT NULL
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 60 AND 100 )");
                $female = count($ff);
            }
        }
        if(empty($age)) #if not empty type - not empty sex - but empty age
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND hloe.name = '$education' 
            AND educ.highest_level_of_education_id IS NOT NULL");
            $count = count($resRecords);
        }
    }

    if(empty($sex)) # empty sex - not empty age
    {
        if($age == '0-6')
        {

        $resRecords = $records->getJoinWhere(" AND hloe.name = '$education'
        AND educ.highest_level_of_education_id IS NOT NULL
        AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
        $count = count($resRecords);
 
        $mm = $records->getJoinWhere(" AND gender = 'M' AND hloe.name = '$education'
        AND educ.highest_level_of_education_id IS NOT NULL
        AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
        $male = count($mm);

        $ff = $records->getJoinWhere(" AND gender = 'F' AND hloe.name = '$education'
        AND educ.highest_level_of_education_id IS NOT NULL
        AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
        $female = count($ff);
        

        }
        if($age == '7-12')
        {
            $resRecords = $records->getJoinWhere(" AND hloe.name = '$education'
            AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 7 AND 12 )");
            $count = count($resRecords);
        }
        if($age == '12-13')
        {
            $resRecords = $records->getJoinWhere("  AND hloe.name = '$education'
            AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 12 AND 13 )");
            $count = count($resRecords);
        }
        if($age == '13-19')
        {
            $resRecords = $records->getJoinWhere("  AND hloe.name = '$education'
            AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 13 AND 19 )");
            $count = count($resRecords);

        }
        if($age == '20-30')
        {
            $resRecords = $records->getJoinWhere("  AND hloe.name = '$education'
            AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 20 AND 30 )");
            $count = count($resRecords);
        }
        if($age == '31-59')
        {
            $resRecords = $records->getJoinWhere(" AND hloe.name = '$education'
            AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 31 AND 59 )");
            $count = count($resRecords);
        }
        if($age == '60')
        {
            $resRecords = $records->getJoinWhere(" AND hloe.name = '$education'
            AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 60 AND 100 )");
            $count = count($resRecords);
        }
        if(empty($age)) #if not empty type - not empty sex - but empty age
        {
            $resRecords = $records->getJoinWhere(" AND hloe.name = '$education'");
            $count = count($resRecords);
        }
    }
}

#if empty education

if(empty($education)){
    if(!empty($sex)) #if not empty type - not empty sex - not empty age
    {
        if($age == '0-6')
        {

        $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND educ.highest_level_of_education_id IS NOT NULL
        AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
        $count = count($resRecords);

        }
        if($age == '7-12')
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 7 AND 12 )");
            $count = count($resRecords);
        }
        if($age == '12-13')
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 12 AND 13 )");
            $count = count($resRecords);
        }
        if($age == '13-19')
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 13 AND 19 )");
            $count = count($resRecords);

        }
        if($age == '20-30')
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 20 AND 30 )");
            $count = count($resRecords);
        }
        if($age == '31-59')
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 31 AND 59 )");
            $count = count($resRecords);
        }
        if($age == '60')
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 60 AND 100 )");
            $count = count($resRecords);
        }
        if(empty($age)) #if not empty type - not empty sex - but empty age
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' AND educ.highest_level_of_education_id IS NOT NULL");
            $count = count($resRecords);
        }
    }

    if(empty($sex)) # empty sex - not empty age
    {
        if($age == '0-6')
        {

        $resRecords = $records->getJoinWhere(" AND educ.highest_level_of_education_id IS NOT NULL
        AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
        $count = count($resRecords);

        }
        if($age == '7-12')
        {
            $resRecords = $records->getJoinWhere(" AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 7 AND 12 )");
            $count = count($resRecords);
        }
        if($age == '12-13')
        {
            $resRecords = $records->getJoinWhere(" AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 12 AND 13 )");
            $count = count($resRecords);
        }
        if($age == '13-19')
        {
            $resRecords = $records->getJoinWhere(" AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 13 AND 19 )");
            $count = count($resRecords);

        }
        if($age == '20-30')
        {
            $resRecords = $records->getJoinWhere(" AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 20 AND 30 )");
            $count = count($resRecords);
        }
        if($age == '31-59')
        {
            $resRecords = $records->getJoinWhere(" AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 31 AND 59 )");
            $count = count($resRecords);
        }
        if($age == '60')
        {
            $resRecords = $records->getJoinWhere(" AND educ.highest_level_of_education_id IS NOT NULL
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 60 AND 100 )");
            $count = count($resRecords);
        }
        if(empty($age)) #all empty
        {
            $resRecords = $records->getJoinWhere(" AND educ.highest_level_of_education_id IS NOT NULL");
            $count = count($resRecords);
        }
    }
}

$reseducationalsummary = $educationalinfo->geteducationalsummary();

$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];

//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");

$brgysecretary = $brgysec['value'];
?> 
<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Highest Educational Attainment | PRINT </title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/print.css">
    <link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css”/>
</head>
<style>
    body{
        font-family: Arial, Helvetica, sans-serif;        
        margin:0;
        font-size: 13px;
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
        border-bottom:1px solid black;
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

    .educational-summary {
        border-collapse: collapse;
        border: 1px solid #ccc;
    }

    thead, th {
        font-size: 13px;
    }

    tbody.tbody-educational > tr > td {
        border: 1px solid #ccc;
    }

    thead.thead-educational > tr > th {
        border: 1px solid #ccc;
    }
</style>
<body>
    <table>
        <tr>
            <td colspan="7" style="text-align: center;border:none;"><h3>HIGHEST EDUCATIONAL ATTAINMENT OF TOTAL POPULATION BY AGE AND SEX</h3></td>
        </tr>

        <tr>
            <td colspan="7" style="text-align: center;border:none;text-transform:uppercase;"><h4>
                <?php
                if($sex == 'M')
                {
                    $newSex = 'Male';
                }
                if($sex == 'F')
                {
                    $newSex = 'Female';
                }

                if(!empty($education))
                {
                    if(!empty($sex))
                    {
                        if(!empty($age))
                        {
                            echo '( '; echo $education; echo ' : '; echo $newSex ; echo ' : '; echo $age; echo ' )';
                        }
                        if(empty($age))
                        {
                            echo '( ';echo $education; echo ' : '; echo $newSex ; echo ' : '; echo 'All Age )';

                        }
                    }
                    if(empty($sex))
                    {
                        if(!empty($age))
                        {
                            echo '( '; echo $education; echo ' : '; echo 'All Sex' ; echo ' : '; echo $age; echo ' )';
                        }
                        if(empty($age))
                        {
                           echo '( '; echo $education; echo ' : '; echo 'All Sex' ; echo ' : '; echo 'All Age )'; 

                        }
                    }

                }

                if(empty($education))
                {
                    if(!empty($sex))
                    {
                        if(!empty($age))
                        {
                            echo '( All Education Level'; echo ' : '; echo $newSex ; echo ' : '; echo $age; echo ' )';
                        }
                        if(empty($age))
                        {
                            echo '( All Education Level'; echo ' : '; echo $newSex ; echo ' : '; echo 'All Age )';

                        }
                    }
                    if(empty($sex))
                    {
                        if(!empty($age))
                        {
                            echo '( All Education Level'; echo ' : '; echo 'All Sex' ; echo ' : '; echo $age; echo ' )';
                        }
                        if(empty($age))
                        {
                            echo '( All Records )';

                        }
                    }

                }
                
                ?>
            </h4></td>
        </tr>

        <tr>
            <td colspan="7" style="color:white;border:none;">space</td>
        </tr>
        <tr>
            <td>A. REGION</td>
            <td colspan="7" class="b-600" ><?php echo $region;?></td>
        </tr>
        <tr>
            <td>PROVINCE</td>
            <td class="b-600" colspan="7" ><?php echo $prov_name;?></td>
        </tr>
        <tr>
            <td>MUNICIPALITY</td>
            <td  class="b-600" colspan="7" ><?php echo $municipal_name;?></td>
        </tr>
        <tr>
            <td>BARANGAY</td>
            <td class="b-600" colspan ="7" ><?php echo $brgy_name;?></td>
        </tr>
        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
        <tr>
            <td rowspan="2" style="text-align:center;width:1%;border:1px solid black;font-weight:bold;">NO.</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" colspan="4" >FULL NAME</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">HIGHEST EDUCATIONAL ATTAINMENT</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">SEX</td>
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">AGE</td>

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
            <td style="border:1px solid black;"><?php echo $row['last_name'];?></td>
            <td style="border:1px solid black;"><?php echo $row['first_name'];?></td>
            <td style="border:1px solid black;"><?php echo $row['middle_name'];?></td>
            <td style="border:1px solid black;"><?php echo $row['qualifier'];?></td>
            <td style="border:1px solid black;"><?php echo $row['highest_name'];?></td>
            <td style="border:1px solid black;"><?php echo $row['gender'];?></td>
            <td style="border:1px solid black;"><?php echo $row['age'];?></td>
            </tr>                                 
        <?php endforeach; ?>
        

        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
    </table>
<?php if(empty($education) && empty($sex) && empty($age)) : ?>
    <h5>SUMMARY</h5>
    <table class="educational-summary">
        <thead class="thead-educational">
            <tr>
                <th>Highest Educational Attainment</th>
                <th>Male</th>
                <th>Female</th>
                <th colspan="6">Age</th>                
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>0 to 6</th>
                <th>7 to 12</th>
                <th>13 to 19</th>
                <th>20 to 30</th>
                <th>31 to 59</th>
                <th>60 above</th>
            </tr>
        </thead>
        <tbody class="tbody-educational">
            <?php 
                $malecount      = 0;
                $femalecount    = 0;
                $zerotosixcount = 0;
                $seventotwelve  = 0;
                $thirteentonineteen     = 0;
                $twentytothirty         = 0;
                $thirtyonetofiftynine   = 0;
                $sixtyabove             = 0;
                foreach($reseducationalsummary as $row): 
                    
                    $malecount      += $row['male_count'];
                    $femalecount    += $row['female_count'];
                    $zerotosixcount += $row['zero_to_six'];
                    $seventotwelve  += $row['seven_to_twelve'];
                    $thirteentonineteen     += $row['thirteen_to_nineteen'];
                    $twentytothirty         += $row['twenty_to_thirty'];
                    $thirtyonetofiftynine   += $row['thirtyone_to_fiftynine'];
                    $sixtyabove             += $row['sixty_above'];
                ?>
                <tr>
                    <td>
                        <?php echo $row['name'] ?>
                    </td>
                    <td class="t-center">
                        <?php echo $row['male_count'] ?>
                    </td>
                    <td class="t-center">
                        <?php echo $row['female_count'] ?>
                    </td>
                    <td class="t-center">
                        <?php echo $row['zero_to_six'] ?>
                    </td>
                    <td class="t-center">
                        <?php echo $row['seven_to_twelve'] ?>
                    </td>
                    <td class="t-center">
                        <?php echo $row['thirteen_to_nineteen'] ?>
                    </td>
                    <td class="t-center">
                        <?php echo $row['twenty_to_thirty'] ?>
                    </td>
                    <td class="t-center">
                        <?php echo $row['thirtyone_to_fiftynine'] ?>
                    </td>
                    <td class="t-center">
                        <?php echo $row['sixty_above'] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="b-600">
                    Total
                </td>
                <td class="b-600 t-center">
                    <?php echo $malecount ?>
                </td>
                <td class="b-600 t-center">
                    <?php echo $femalecount ?>
                </td>
                <td class="b-600 t-center">
                    <?php echo $zerotosixcount ?>
                </td>
                <td class="b-600 t-center">
                    <?php echo $seventotwelve ?>
                </td>
                <td class="b-600 t-center">
                    <?php echo $thirteentonineteen ?>
                </td>
                <td class="b-600 t-center">
                    <?php echo $twentytothirty ?>
                </td>
                <td class="b-600 t-center">
                    <?php echo $thirtyonetofiftynine ?>
                </td>
                <td class="b-600 t-center">
                    <?php echo $sixtyabove ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php endif; ?>
    <br>
    <br>
    <?php echo $helpers->getsignage($brgysecretary) ?>
</body>
</html>