<?php
$resMale = $records->getJoinWhere( " AND p.gender = 'M'");
$All_male = count($resMale);
$resFemale = $records->getJoinWhere( " AND p.gender = 'F'");
$All_female = count($resFemale);
$resTotal = $records->getOccupationInfo();
$total_emp = count($resTotal);

$resVoters = $records->getJoinWhere( " AND p.registered_voter = 'Y'");
$count_voters = count($resVoters);
$per_voters = round(((int)$count_voters / (int)$total_population) * 100,1);
$resNonvoters = $records->getJoinWhere( " AND p.registered_voter = 'N'");
$count_nonv = count($resNonvoters);
$per_nonvoters = round(((int)$count_nonv / (int)$total_population) * 100,1);

$res_0_6_male = $records->getJoinWhere(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$male_0_6 = count($res_0_6_male);
$res_0_6_female = $records->getJoinWhere(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 0 AND 6 )");
$female_0_6 = count($res_0_6_female);

$res_7_12_male = $records->getJoinWhere(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$male_7_12 = count($res_7_12_male);
$res_7_12_female = $records->getJoinWhere(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 7 AND 12 )");
$female_7_12 = count($res_7_12_female);

$res_13_19_male = $records->getJoinWhere(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$male_13_19 = count($res_13_19_male);
$res_13_19_female = $records->getJoinWhere(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 13 AND 19 )");
$female_13_19 = count($res_13_19_female);

$res_20_30_male = $records->getJoinWhere(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$male_20_30 = count($res_20_30_male);
$res_20_30_female = $records->getJoinWhere(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 20 AND 30 )");
$female_20_30 = count($res_20_30_female);

$res_31_59_male = $records->getJoinWhere(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$male_31_59 = count($res_31_59_male);
$res_31_59_female = $records->getJoinWhere(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 31 AND 59 )");
$female_31_59 = count($res_31_59_female);

$res_male_60 = $records->getJoinWhere(" AND p.gender = 'M' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 60 AND 100 )");
$male_a_60 = count($res_male_60);
$res_female_60 = $records->getJoinWhere(" AND p.gender = 'F' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 60 AND 100 )");
$female_a_60 = count($res_female_60);


#single

$sing = $records->getJoinWhere(" AND cs.name = 'SINGLE'");
$single = count($sing);
$per_single = round(((int)$single / (int)$total_population) * 100);
#married
$mar = $records->getJoinWhere(" AND cs.name = 'MARRIED'");
$married = count($mar);
$per_married = round(((int)$married / (int)$total_population) * 100);
#widower
$wid = $records->getJoinWhere(" AND cs.name = 'WIDOWER'");
$widower = count($wid);
$per_widow = round(((int)$widower / (int)$total_population) * 100);

#separated
$sep = $records->getJoinWhere(" AND cs.name = 'SEPARATED'");
$separated = count($sep);
$per_separated = round(((int)$separated / (int)$total_population) * 100);


#employed
$emp = $records->getOccupationInfo(" AND es.name = 'Employed' OR es.name = 'EMPLOYED'");
$employed = count($emp);
$per_employed = round(((int)$employed / (int)$total_emp) * 100);

#self-employed
$self = $records->getOccupationInfo(" AND es.name = 'Self-employed' OR es.name = 'SELF-EMPLOYED'");
$self_employed = count($self);
$per_self_emp = round(((int)$self_employed / (int)$total_emp) * 100);

#un-employed
$un = $records->getOccupationInfo(" AND es.name = 'Unemployed' OR es.name = 'UNEMPLOYED'");
$unemployed = count($un);
$per_unemployed = round(((int)$unemployed / (int)$total_emp) * 100);

#underemployed
$under = $records->getOccupationInfo(" AND es.name = 'Underemployed' OR es.name = 'UNDEREMPLOYED'");
$under_employed = count($under);
$per_underemployed = round(((int)$under_employed / (int)$total_emp) * 100);

#J. TOTAL NO. OF FULLY VACCINATED INDIVIDUALS AGED 18 YEARS AND ABOVE
$fullvac_18_above_sd = $records->getFullyVaccinated( " AND vi.dose_type = 'S' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 18 AND 100 )");
$fullvac_18_above_jensen = $records->getFullyVaccinated( " AND cv.name = 'J&J' AND (  DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
+ 0 BETWEEN 18 AND 100 )");
$s_d_18 = count($fullvac_18_above_sd);
$jensen_18_above = count($fullvac_18_above_jensen);
$fully_vacc = (int)$s_d_18 + (int)$jensen_18_above;
$per_fullyvacs = round(((int)$fully_vacc / (int)$total_population) * 100);

$still = $records->getEducationInfo(" AND ed.still_schooling = 'Y'");
$still_schooling = count($still);
$per_schooling = round(((int)$still_schooling / (int)$total_population) * 100);

#primary
$pri = $records->getJoinSchool(" AND educ.grade_year_level = 'Primary'");
$count_pri = count($pri);
$primary = round(((int)$count_pri / (int)$total_population) * 100);

#elementary
$ele = $records->getJoinSchool(" AND educ.grade_year_level = 'Elementary'");
$count_ele = count($ele);
$elementary = round(((int)$count_ele / (int)$total_population) * 100);

#high school
$hs = $records->getJoinSchool(" AND educ.grade_year_level = 'High School'");
$count_hs = count($hs);
$high_school = round(((int)$count_hs / (int)$total_population) * 100);

#senior high school
$shs = $records->getJoinSchool(" AND educ.grade_year_level = 'Senior High School'");
$count_shs = count($shs);
$senior_hs = round(((int)$count_shs / (int)$total_population) * 100);

#college
$col = $records->getJoinSchool(" AND educ.grade_year_level = 'College'");
$count_col = count($col);
$college = round(((int)$count_col / (int)$total_population) * 100);

#masterss
$mas = $records->getJoinSchool(" AND educ.grade_year_level = 'Masters'");
$count_mas = count($mas);
$masters = round(((int)$count_mas / (int)$total_population) * 100);

#doctoral
$doc = $records->getJoinSchool(" AND educ.grade_year_level = 'Doctoral'");
$count_doc = count($doc);
$doctoral = round(((int)$count_doc / (int)$total_population) * 100);

#post-doc
$pdoc = $records->getJoinSchool(" AND educ.grade_year_level = 'Post-doc'");
$count_pdoc = count($pdoc);
$post_doc = round(((int)$count_pdoc / (int)$total_population) * 100);
if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

# house type
#light material
$light_m = $records->getindexHtypelocation(" AND ht.name = 'Light Material'");
$ligh_material = count($light_m);

$semi = $records->getindexHtypelocation(" AND ht.name = 'Semi-concrete'");
$semi_concrete = count($semi);

$concr = $records->getindexHtypelocation(" AND ht.name = 'Concreted'");
$concreted = count($concr);

$coast_a = $records->getindexHtypelocation(" AND hl.name = 'Coastal area'");
$coastal_area = count($coast_a);

$tsun = $records->getindexHtypelocation(" AND hl.name = 'Tsunami prone area'");
$tsunami = count($tsun);

$dis = $records->getindexHtypelocation(" AND hl.name = 'Disaster Prone Area'");
$disas = count($dis);

$flood = $records->getindexHtypelocation(" AND hl.name = 'Flood-prone area'");
$flood_prone = count($flood);

$not_r = $records->getindexHtypelocation(" AND hl.name = 'Not-risky areas'");
$not_risky = count($not_r);

#resident types
$non_mig = $records->getResidenttypeCount(" AND r.name = 'Non-Migrants'");
$non_migrants = count($non_mig);

$mig = $records->getResidenttypeCount(" AND r.name = 'Migrants'");
$migrants = count($mig);

$dom = $records->getResidenttypeCount(" AND r.name = 'Domiciles'");
$domiciles = count($dom);

$trans = $records->getResidenttypeCount(" AND r.name = 'Transient'");
$transient = count($trans);

$board = $records->getResidenttypeCount(" AND r.name = 'Boarders'");
$boarders = count($board);

$transfer = $records->getResidenttypeCount(" AND r.name = 'Transferred'");
$transferred = count($transfer);