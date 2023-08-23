<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '../inc/app_settings.php');
require_once(DOCUMENT_ROOT . '../inc/helpers.php');
require (DOCUMENT_ROOT . '../models/Config.php');
require (DOCUMENT_ROOT . '../models/Reports.php');
require (DOCUMENT_ROOT . '../models/School_level.php');


$helpers = new Helpers();
$schoollevel = new School_level();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$grade = $_GET['grade'];
$sex = $_GET['sex'];
$age = $_GET['age'];
$config = new Config();
$records = new Reports();

 
if(!empty($grade)){
    if(!empty($sex)) #if not empty type - not empty sex - not empty age
    {
        if($age == '0-6')
        {

        $resRecords = $records->getJoinSchool(" AND gender = '$sex' AND educ.grade_year_level = '$grade'
        AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");

            if($sex == 'M')
            {
                $mm = $records->getJoinSchool(" AND gender = 'M' AND educ.grade_year_level = '$grade'
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
                $male = count($mm);
            }
            if($sex == 'F')
            {
                $ff = $records->getJoinSchool(" AND gender = 'F' AND educ.grade_year_level = '$grade'
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
                $female = count($ff);
            }
        }
        if($age == '7-12')
        {
            $resRecords = $records->getJoinSchool(" AND gender = '$sex' AND educ.grade_year_level = '$grade'
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 7 AND 12 )");
            $count = count($resRecords);

            if($sex == 'M')
            {
                $mm = $records->getJoinSchool(" AND gender = 'M' AND educ.grade_year_level = '$grade'
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 7 AND 12 )");
                $male = count($mm);
            }
            if($sex == 'F')
            {
                $ff = $records->getJoinSchool(" AND gender = 'F' AND educ.grade_year_level = '$grade'
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 7 AND 12 )");
                $female = count($ff);
            }
        }
        if($age == '13-19')
        {
            $resRecords = $records->getJoinSchool(" AND gender = '$sex' AND educ.grade_year_level = '$grade'
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 13 AND 19 )");
            $count = count($resRecords);

            if($sex == 'M')
            {
                $mm = $records->getJoinSchool(" AND gender = 'M' AND educ.grade_year_level = '$grade'
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 13 AND 19 )");
                $male = count($mm);
            }
            if($sex == 'F')
            {
                $ff = $records->getJoinSchool(" AND gender = 'F' AND educ.grade_year_level = '$grade'
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 13 AND 19 )");
                $female = count($ff);
            }

        }
        if($age == '20-30')
        {
            $resRecords = $records->getJoinSchool(" AND gender = '$sex' AND educ.grade_year_level = '$grade'
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 20 AND 30 )");
            $count = count($resRecords);

            if($sex == 'M')
            {
                $mm = $records->getJoinSchool(" AND gender = 'M' AND educ.grade_year_level = '$grade'
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 20 AND 30 )");
                $male = count($mm);
            }
            if($sex == 'F')
            {
                $ff = $records->getJoinSchool(" AND gender = 'F' AND educ.grade_year_level = '$grade'
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 20 AND 30 )");
                $female = count($ff);
            }
        }
        if($age == '31-59')
        {
            $resRecords = $records->getJoinSchool(" AND gender = '$sex' AND educ.grade_year_level = '$grade'
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 31 AND 59 )");
            $count = count($resRecords);

            if($sex == 'M')
            {
                $mm = $records->getJoinSchool(" AND gender = 'M' AND educ.grade_year_level = '$grade'
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 31 AND 59 )");
                $male = count($mm);
            }
            if($sex == 'F')
            {
                $ff = $records->getJoinSchool(" AND gender = 'F' AND educ.grade_year_level = '$grade'
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 31 AND 59 )");
                $female = count($ff);
            }
        }
        if($age == '60')
        {
            $resRecords = $records->getJoinSchool(" AND gender = '$sex' AND educ.grade_year_level = '$grade'
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 60 AND 100 )");
            $count = count($resRecords);

            if($sex == 'M')
            {
                $mm = $records->getJoinSchool(" AND gender = 'M' AND educ.grade_year_level = '$grade'
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 60 AND 100 )");
                $male = count($mm);
            }
            if($sex == 'F')
            {
                $ff = $records->getJoinSchool(" AND gender = 'F' AND educ.grade_year_level = '$grade'
                AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 60 AND 100 )");
                $female = count($ff);
            }
        }
        if(empty($age)) #if not empty type - not empty sex - but empty age
        {
            $resRecords = $records->getJoinSchool(" AND gender = '$sex' AND educ.grade_year_level = '$grade'");
              #age 0-6
            $mm_0_6 = $records->getJoinSchool(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 0 AND 6 )");
            $male_0_6 = count($mm_0_6);

            $ff_0_6 = $records->getJoinSchool(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 0 AND 6 )");
            $female_0_6 = count($ff_0_6);

            #age 7-12
            $mm_7_12 = $records->getJoinSchool(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 7 AND 12 )");
            $male_7_12 = count($mm_7_12);

            $ff_7_12 = $records->getJoinSchool(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 7 AND 12 )");
            $female_7_12 = count($ff_7_12);

            #age 13-19
            $mm_13_19 = $records->getJoinSchool(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 13 AND 19 )");
            $male_13_19 = count($mm_13_19);

            $ff_13_19 = $records->getJoinSchool(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 13 AND 19 )");
            $female_13_19 = count($ff_13_19);

            #age 20-30
            $mm_20_30 = $records->getJoinSchool(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 20 AND 30 )");
            $male_20_30 = count($mm_20_30);

            $ff_20_30 = $records->getJoinSchool("  AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 20 AND 30 )");
            $female_20_30 = count($ff_20_30);

            #age 20-30
            $mm_31_59 = $records->getJoinSchool("  AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 31 AND 59 )");
            $male_31_59 = count($mm_31_59);

            $ff_31_59 = $records->getJoinSchool(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 31 AND 59 )");
            $female_31_59 = count($ff_31_59);

            #age above 60
            $mm_60 = $records->getJoinSchool(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 60 AND 100 )");
            $male_60 = count($mm_60);

            $ff_60 = $records->getJoinSchool(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 60 AND 100 )");
            $female_60 = count($ff_60);

            $total_female = (int)$female_0_6 + (int)$female_7_12+ (int)$female_13_19 + (int)$female_20_30 + (int)$female_31_59 + (int)$female_60;
            $total_male = (int)$male_0_6 + (int)$male_7_12 + (int)$male_13_19 + (int)$male_20_30 + (int)$male_31_59 + (int)$male_60;

            $overall_total = $total_female + $total_male;
            $count = count($resRecords);
        }
    }

    if(empty($sex)) # empty sex - not empty age
    {
        if($age == '0-6')
        {

        $resRecords = $records->getJoinSchool(" AND educ.grade_year_level = '$grade'
        AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
        $count = count($resRecords);
 
        $mm = $records->getJoinSchool(" AND gender = 'M' AND educ.grade_year_level = '$grade'
        AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
        $male = count($mm);

        $ff = $records->getJoinSchool(" AND gender = 'F' AND educ.grade_year_level = '$grade'
        AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
        $female = count($ff);
        

        }
        if($age == '7-12')
        {
            $resRecords = $records->getJoinSchool(" AND educ.grade_year_level = '$grade'
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 7 AND 12 )");
            $count = count($resRecords);
        }
        if($age == '12-13')
        {
            $resRecords = $records->getJoinSchool("  AND educ.grade_year_level = '$grade'
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 12 AND 13 )");
            $count = count($resRecords);
        }
        if($age == '13-19')
        {
            $resRecords = $records->getJoinSchool("  AND educ.grade_year_level = '$grade'
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 13 AND 19 )");
            $count = count($resRecords);

        }
        if($age == '20-30')
        {
            $resRecords = $records->getJoinSchool("  AND educ.grade_year_level = '$grade'
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 20 AND 30 )");
            $count = count($resRecords);
        }
        if($age == '31-59')
        {
            $resRecords = $records->getJoinSchool(" AND educ.grade_year_level = '$grade'
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 31 AND 59 )");
            $count = count($resRecords);
        }
        if($age == '60')
        {
            $resRecords = $records->getJoinSchool(" AND educ.grade_year_level = '$grade'
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 60 AND 100 )");
            $count = count($resRecords);
        }
        if(empty($age)) #if not empty type - not empty sex - but empty age
        {
            $resRecords = $records->getJoinSchool(" AND educ.grade_year_level = '$grade'");
              #age 0-6
              $mm_0_6 = $records->getJoinSchool(" AND educ.grade_year_level = '$grade' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
              + 0 BETWEEN 0 AND 6 )");
              $male_0_6 = count($mm_0_6);
  
              $ff_0_6 = $records->getJoinSchool(" AND educ.grade_year_level = '$grade' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
              + 0 BETWEEN 0 AND 6 )");
              $female_0_6 = count($ff_0_6);
  
              #age 7-12
              $mm_7_12 = $records->getJoinSchool(" AND educ.grade_year_level = '$grade' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
              + 0 BETWEEN 7 AND 12 )");
              $male_7_12 = count($mm_7_12);
  
              $ff_7_12 = $records->getJoinSchool(" AND educ.grade_year_level = '$grade' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
              + 0 BETWEEN 7 AND 12 )");
              $female_7_12 = count($ff_7_12);
  
              #age 13-19
              $mm_13_19 = $records->getJoinSchool(" AND educ.grade_year_level = '$grade' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
              + 0 BETWEEN 13 AND 19 )");
              $male_13_19 = count($mm_13_19);
  
              $ff_13_19 = $records->getJoinSchool(" AND educ.grade_year_level = '$grade' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
              + 0 BETWEEN 13 AND 19 )");
              $female_13_19 = count($ff_13_19);
  
              #age 20-30
              $mm_20_30 = $records->getJoinSchool(" AND educ.grade_year_level = '$grade' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
              + 0 BETWEEN 20 AND 30 )");
              $male_20_30 = count($mm_20_30);
  
              $ff_20_30 = $records->getJoinSchool("  AND educ.grade_year_level = '$grade' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
              + 0 BETWEEN 20 AND 30 )");
              $female_20_30 = count($ff_20_30);
  
              #age 20-30
              $mm_31_59 = $records->getJoinSchool("  AND educ.grade_year_level = '$grade' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
              + 0 BETWEEN 31 AND 59 )");
              $male_31_59 = count($mm_31_59);
  
              $ff_31_59 = $records->getJoinSchool(" AND educ.grade_year_level = '$grade' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
              + 0 BETWEEN 31 AND 59 )");
              $female_31_59 = count($ff_31_59);
  
              #age above 60
              $mm_60 = $records->getJoinSchool(" AND educ.grade_year_level = '$grade' AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
              + 0 BETWEEN 60 AND 100 )");
              $male_60 = count($mm_60);
  
              $ff_60 = $records->getJoinSchool(" AND educ.grade_year_level = '$grade' AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
              + 0 BETWEEN 60 AND 100 )");
              $female_60 = count($ff_60);
  
              $total_female = (int)$female_0_6 + (int)$female_7_12+ (int)$female_13_19 + (int)$female_20_30 + (int)$female_31_59 + (int)$female_60;
              $total_male = (int)$male_0_6 + (int)$male_7_12 + (int)$male_13_19 + (int)$male_20_30 + (int)$male_31_59 + (int)$male_60;
  
              $overall_total = $total_female + $total_male;
            $count = count($resRecords);
        }
    }
}

#if empty grade

if(empty($grade)){
    if(!empty($sex)) #if not empty type - not empty sex - not empty age
    {
        if($age == '0-6')
        {

        $resRecords = $records->getJoinSchool(" AND gender = '$sex' 
        AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
        $count = count($resRecords);

        }
        if($age == '7-12')
        {
            $resRecords = $records->getJoinSchool(" AND gender = '$sex' 
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 7 AND 12 )");
            $count = count($resRecords);
        }
        if($age == '12-13')
        {
            $resRecords = $records->getJoinSchool(" AND gender = '$sex' 
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 12 AND 13 )");
            $count = count($resRecords);
        }
        if($age == '13-19')
        {
            $resRecords = $records->getJoinWhere(" AND gender = '$sex' 
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 13 AND 19 )");
            $count = count($resRecords);

        }
        if($age == '20-30')
        {
            $resRecords = $records->getJoinSchool(" AND gender = '$sex' 
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 20 AND 30 )");
            $count = count($resRecords);
        }
        if($age == '31-59')
        {
            $resRecords = $records->getJoinSchool(" AND gender = '$sex' 
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 31 AND 59 )");
            $count = count($resRecords);
        }
        if($age == '60')
        {
            $resRecords = $records->getJoinSchool(" AND gender = '$sex'  
            AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 60 AND 100 )");
            $count = count($resRecords);
        }
        if(empty($age)) #if not empty type - not empty sex - but empty age
        {
            $resRecords = $records->getJoinSchool(" AND gender = '$sex'");
            
            $count = count($resRecords);
        }
    }

    if(empty($sex)) # empty sex - not empty age
    {
        if($age == '0-6')
        {

        $resRecords = $records->getJoinSchool(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 0 AND 6 )");
        $count = count($resRecords);

        }
        if($age == '7-12')
        {
            $resRecords = $records->getJoinSchool(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 7 AND 12 )");
            $count = count($resRecords);
        }
        if($age == '12-13')
        {
            $resRecords = $records->getJoinSchool(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 12 AND 13 )");
            $count = count($resRecords);
        }
        if($age == '13-19')
        {
            $resRecords = $records->getJoinSchool(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 13 AND 19 )");
            $count = count($resRecords);

        }
        if($age == '20-30')
        {
            $resRecords = $records->getJoinSchool(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 20 AND 30 )");
            $count = count($resRecords);
        }
        if($age == '31-59')
        {
            $resRecords = $records->getJoinSchool(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 31 AND 59 )");
            $count = count($resRecords);
        }
        if($age == '60')
        {
            $resRecords = $records->getJoinSchool(" AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 BETWEEN 60 AND 100 )");
            $count = count($resRecords);
        }
        if(empty($age)) #all empty
        {
            $resRecords = $records->getJoinSchool();
              #age 0-6
            $mm_0_6 = $records->getJoinSchool(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 0 AND 6 )");
            $male_0_6 = count($mm_0_6);

            $ff_0_6 = $records->getJoinSchool(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 0 AND 6 )");
            $female_0_6 = count($ff_0_6);

            #age 7-12
            $mm_7_12 = $records->getJoinSchool(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 7 AND 12 )");
            $male_7_12 = count($mm_7_12);

            $ff_7_12 = $records->getJoinSchool(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 7 AND 12 )");
            $female_7_12 = count($ff_7_12);

            #age 13-19
            $mm_13_19 = $records->getJoinSchool(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 13 AND 19 )");
            $male_13_19 = count($mm_13_19);

            $ff_13_19 = $records->getJoinSchool(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 13 AND 19 )");
            $female_13_19 = count($ff_13_19);

            #age 20-30
            $mm_20_30 = $records->getJoinSchool(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 20 AND 30 )");
            $male_20_30 = count($mm_20_30);

            $ff_20_30 = $records->getJoinSchool("  AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 20 AND 30 )");
            $female_20_30 = count($ff_20_30);

            #age 20-30
            $mm_31_59 = $records->getJoinSchool("  AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 31 AND 59 )");
            $male_31_59 = count($mm_31_59);

            $ff_31_59 = $records->getJoinSchool(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 31 AND 59 )");
            $female_31_59 = count($ff_31_59);

            #age above 60
            $mm_60 = $records->getJoinSchool(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 60 AND 100 )");
            $male_60 = count($mm_60);

            $ff_60 = $records->getJoinSchool(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
            + 0 BETWEEN 60 AND 100 )");
            $female_60 = count($ff_60);

            $total_female = (int)$female_0_6 + (int)$female_7_12+ (int)$female_13_19 + (int)$female_20_30 + (int)$female_31_59 + (int)$female_60;
            $total_male = (int)$male_0_6 + (int)$male_7_12 + (int)$male_13_19 + (int)$male_20_30 + (int)$male_31_59 + (int)$male_60;

            $overall_total = $total_female + $total_male;
        $count = count($resRecords);

     
        }
    }
}

$brgy_name = $_SESSION['SESS_BRGY_DESC'];
$municipal_name = $_SESSION['SESS_CITYMUN_DESC'];
$prov_name = $_SESSION['SESS_PROV_DESC'];
$region = $_SESSION['SESS_REG_CODE'];

//Get brgy secretary
$brgysec = $config->getSettings("AND name = 'Barangay Secretary'");

$brgysecretary = $brgysec['value'];

$resschoollevel = $schoollevel->getschoollevelcount();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currently Enrolled Report | PRINT </title>
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
            <td colspan="7" style="text-align: center;border:none;"><h3>CURRENTLY ENROLLED REPORT BY AGE AND SEX</h3></td>
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

                if(!empty($grade))
                {
                    if(!empty($sex))
                    {
                        if(!empty($age))
                        {
                            echo '( '; echo $grade; echo ' : '; echo $newSex ; echo ' : '; echo $age; echo ' )';
                        }
                        if(empty($age))
                        {
                            echo '( ';echo $grade; echo ' : '; echo $newSex ; echo ' : '; echo 'All Age )';

                        }
                    }
                    if(empty($sex))
                    {
                        if(!empty($age))
                        {
                            echo '( '; echo $grade; echo ' : '; echo 'All Sex' ; echo ' : '; echo $age; echo ' )';
                        }
                        if(empty($age))
                        {
                           echo '( '; echo $grade; echo ' : '; echo 'All Sex' ; echo ' : '; echo 'All Age )'; 

                        }
                    }

                }

                if(empty($grade))
                {
                    if(!empty($sex))
                    {
                        if(!empty($age))
                        {
                            echo '( All Grade Level'; echo ' : '; echo $newSex ; echo ' : '; echo $age; echo ' )';
                        }
                        if(empty($age))
                        {
                            echo '( All Grade Level'; echo ' : '; echo $newSex ; echo ' : '; echo 'All Age )';

                        }
                    }
                    if(empty($sex))
                    {
                        if(!empty($age))
                        {
                            echo '( All Grade Level'; echo ' : '; echo 'All Sex' ; echo ' : '; echo $age; echo ' )';
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
            <td class="b-600" colspan="7" ><?php echo $region;?></td>
        </tr>
        <tr>
            <td>PROVINCE</td>
            <td class="b-600" colspan="7" ><?php echo $prov_name;?></td>
        </tr>
        <tr>
            <td>MUNICIPALITY</td>
            <td class="b-600" colspan="7" ><?php echo $municipal_name;?></td>
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
            <td style="text-align: center;border:1px solid black;font-weight:bold;" rowspan="2">EDUCATIONAL LEVEL</td>
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
                <td style="border:1px solid black;text-align: center;"><?php echo $row['last_name'];?></td>
                <td style="border:1px solid black;text-align: center;"><?php echo $row['first_name'];?></td>
                <td style="border:1px solid black;text-align: center;"><?php echo $row['middle_name'];?></td>
                <td style="border:1px solid black;text-align: center;"><?php echo $row['qualifier'];?></td>
                <td style="border:1px solid black;text-align: center;"><?php echo $row['school_level_name'];?></td>
                <td style="border:1px solid black;text-align: center;"><?php echo $row['gender'];?></td>
                <td style="border:1px solid black;text-align: center;"><?php echo $row['age'];?></td>
            </tr>                                 
        <?php endforeach; ?>
        <tr>
            <td colspan="8" style="color:white;border:none;">space</td>
        </tr>
    </table>
    <table style="width:50%">
        <tr>
        <?php if(empty($sex) && empty($age)): ?>
        <td valign="top">
                <h5>SUMMARY BY SEX AND AGE</h5>
                <table class="households-type" style="width: 100%;">
                    <thead class="thead-households-type">
                        <tr>
                            <th>Age</th>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Count</th>                
                        </tr>
                    </thead>
                    <tbody class="tbody-households-type">
                       
                            <tr>
                                <td>
                                0-6
                                </td>
                                <td class="t-center">
                                <?php echo $male_0_6;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female_0_6;?>
                                
                                </td>
                                <td class="t-center">
                                <?php echo (int)$female_0_6 + (int)$male_0_6;?>    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                7-12
                                </td>
                                <td class="t-center">
                                <?php echo $male_7_12;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female_7_12;?>
                                </td>
                                <td class="t-center">
                                <?php echo (int)$male_7_12 + (int)$female_7_12;?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                13-19
                                </td>
                                <td class="t-center">
                                <?php echo $male_13_19;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female_13_19;?>
                                </td>
                                <td class="t-center">
                                <?php echo (int)$female_13_19 + (int)$male_13_19;?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                20-30
                                </td>
                                <td class="t-center">
                                <?php echo $male_20_30;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female_20_30;?>
                                </td>
                                <td class="t-center">
                                <?php echo (int)$female_20_30 + (int)$male_20_30;?>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                31-59
                                </td>
                                <td class="t-center">
                                <?php echo $male_31_59;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female_31_59;?>
                                </td>
                                <td class="t-center">
                                <?php echo (int)$female_31_59 + (int)$male_31_59;?>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                60 above
                                </td>
                                <td class="t-center">
                                <?php echo $male_60;?>
                                </td>
                                <td class="t-center">
                                <?php echo $female_60;?>
                                </td>
                                <td class="t-center">
                                <?php echo (int)$female_60 + (int)$male_60;?>
                                </td>
                            </tr>
                    
                        <tr>
                            <td class="b-600">TOTAL</td>
                            <td class="t-center b-600">
                            <?php echo $total_male;?>
                            </td>
                            <td class="t-center b-600">
                            <?php echo $total_female;?>
                             </td>
                             <td class="t-center b-600">
                             <?php echo $overall_total;?>
                             </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <?php endif;?>

          

    <?php if( empty($grade) && empty($sex) && empty($age)) : ?>
        <td valign="top">
    <h5>SUMMARY OF EDUCATIONAL LEVELS</h5>
    <table class="households-type" style="width: 50%;">
        <thead class="thead-households-type">
            <tr>
                <th>Name</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody class="tbody-households-type">
            <?php 
                $totalschoollevel = 0;
                foreach($resschoollevel as $row): 
                    $totalschoollevel += $row['total_count'];
                ?>
                <tr>
                    <td>
                        <?php echo $row['name'] ?>
                    </td>
                    <td class="t-center">
                        <?php echo $row['total_count'] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="b-600">TOTAL</td>
                <td class="t-center b-600">
                    <?php echo $totalschoollevel ?>
                </td>
            </tr>
        </tbody>
    </table>
        </td>
    </tr>
    </table>
    <?php endif; ?>
    <br>
    <br>
    <?php echo $helpers->getsignage($brgysecretary) ?>
</body>
</html>