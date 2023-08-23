<?php
require_once('Models.php');
class Reports extends Models {
    protected $db;
    private $table;
    public function __construct() {
		require_once($this->getDocumentRoot() . '/inc/conn.php');
        $this->db = DB::getInstance();
        $this->table = 'house_holds';
    }

    public function getWhere($where = '', $sortBy = 'household_no ASC') {
        $sql = "SELECT * FROM $this->table WHERE 1 ";

        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";

        $rows = $this->db->select($sql);
        return $rows;
    }

    public function insertData($data) {
        $sql = "INSERT INTO $this->table (";
        $sql .= implode(",", array_keys($data)) . ') VALUES ';            
        $sql .= "('" . implode("','", array_values($data)) . "')";
        $this->db->exec($sql);
        return $this->db->lastInsertId($sql);
    }

    public function updateData($data, $where) {
        $set = [];
        foreach($data as $key => $value) {
            $set[] = "$key='$value'";
        }

        $setData = implode(', ', $set);        
        $sql = "UPDATE $this->table SET ". $setData;
        $sql .= " WHERE $where";
		return $this->db->exec($sql);
	}

	public function delete($id) {
		$sql = "DELETE FROM $this->table WHERE id=" . $id;
		return $this->db->exec($sql);
	}

	public function getJoinWhere($where = '', $sortBy = 'p.id DESC') {
		$sql = "SELECT h.*, p.first_name, p.last_name,p.middle_name,p.id AS personal_info_id,p.qualifier,p.no_street_sitio_purok, 
        p.no_street_sitio_purok AS purok, p.occupation, p.occupation AS occ_id,
        ht.name AS house_type_name, p.birthdate, p.birth_place, p.birth_place AS birth_place, p.birthdate AS birthdate,
        p.gender AS gender,cs.name as civil_name,re.name AS religion_name, es.name AS ethnic_name, mi.name AS monthly_income,
        hl.name AS house_location_name,rt.name AS resident_type_name, p.id AS personal_info_id,rb.brgyDesc,rcm.citymunDesc,
        rp.provDesc, occ.name as occ_name, citi.name as citi_name,p.registered_voter,p.pwd,
        hdr.name as relationship ,educ.highest_level_of_education_id, educ.grade_year_level AS grade_year_level,
        hloe.name as highest_name,hloe.id as highest_id,educ.still_schooling,
        p.qualifier,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 AS age
        FROM house_holds h 
        LEFT JOIN personal_info p ON p.house_hold_id = h.id 
        LEFT JOIN house_types ht ON ht.id = h.house_type_id 
        LEFT JOIN house_locations hl ON hl.id = h.house_location_id 
        LEFT JOIN resident_types rt ON rt.id = p.resident_type_id 
        LEFT JOIN refbrgy rb ON rb.id = p.brgy_id 
        LEFT JOIN refcitymun rcm ON rcm.id = p.municipality_id 
        LEFT JOIN refprovince rp ON rp.id = p.province_id 
        LEFT JOIN civil_status cs ON cs.id = p.civil_status_id
        LEFT JOIN religions re ON re.id = p.religion_id
        LEFT JOIN ethnicities es ON es.id = p.ethnicity_id
        LEFT JOIN monthly_income mi ON mi.id = p.monthly_income_id
        LEFT JOIN occupations occ ON occ.id = p.occupation 
        LEFT JOIN citizenships citi ON citi.id = p.citizenship_id 
        LEFT JOIN household_head_relationship hdr ON hdr.id = p.household_head_relationship_id 
        LEFT JOIN educational_informations educ ON educ.personal_info_id = p.id
        LEFT JOIN highest_level_of_educations hloe ON hloe.id = educ.highest_level_of_education_id
        WHERE 1
        AND h.status != 'D'
        AND p.status != 'D'
                ";

        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getAllInfo($where = '', $sortBy = 'p.id DESC') {
		$sql = "SELECT p.*,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 AS age
        FROM personal_info p
        WHERE p.status != 'D'
                ";

        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }
    public function getrbiPerHousehold($where = '', $sortBy = 'p.no_street_sitio_purok ASC') {
		$sql = "SELECT p.no_street_sitio_purok, p.first_name, p.middle_name, p.last_name, p.id, p.house_hold_id, p.family_head
        FROM personal_info p
        WHERE p.family_head = 'Y'
        AND p.status != 'D'
                ";

        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getRBIcount($where = '', $sortBy = 'p.no_street_sitio_purok ASC') {
		$sql = "SELECT p.no_street_sitio_purok, p.first_name, p.middle_name, p.last_name, p.id, p.house_hold_id, p.family_head
        FROM personal_info p
        WHERE p.status != 'D'
                ";

        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getReligion($where = '', $sortBy = 'p.id DESC') {
		$sql = "SELECT h.*, p.first_name, p.last_name,p.middle_name,p.id AS personal_info_id,p.qualifier,p.no_street_sitio_purok, 
        p.no_street_sitio_purok AS purok, p.occupation, p.occupation AS occ_id,
        ht.name AS house_type_name, p.birthdate, p.birth_place, p.birth_place AS birth_place, p.birthdate AS birthdate,
        p.gender AS gender,cs.name as civil_name,re.name AS religion_name, es.name AS ethnic_name, mi.name AS monthly_income,
        hl.name AS house_location_name,rt.name AS resident_type_name, p.id AS personal_info_id,rb.brgyDesc,rcm.citymunDesc,
        rp.provDesc, occ.name as occ_name, citi.name as citi_name,p.registered_voter,
        hdr.name as relationship ,educ.highest_level_of_education_id, educ.grade_year_level AS grade_year_level,
        hloe.name as highest_name,hloe.id as highest_id,educ.still_schooling,
        p.qualifier,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 AS age
        FROM house_holds h 
        LEFT JOIN personal_info p ON p.house_hold_id = h.id 
        LEFT JOIN house_types ht ON ht.id = h.house_type_id 
        LEFT JOIN house_locations hl ON hl.id = h.house_location_id 
        LEFT JOIN resident_types rt ON rt.id = p.resident_type_id 
        LEFT JOIN refbrgy rb ON rb.id = p.brgy_id 
        LEFT JOIN refcitymun rcm ON rcm.id = p.municipality_id 
        LEFT JOIN refprovince rp ON rp.id = p.province_id 
        LEFT JOIN civil_status cs ON cs.id = p.civil_status_id
        LEFT JOIN religions re ON re.id = p.religion_id
        LEFT JOIN ethnicities es ON es.id = p.ethnicity_id
        LEFT JOIN monthly_income mi ON mi.id = p.monthly_income_id
        LEFT JOIN occupations occ ON occ.id = p.occupation 
        LEFT JOIN citizenships citi ON citi.id = p.citizenship_id 
        LEFT JOIN household_head_relationship hdr ON hdr.id = p.household_head_relationship_id 
        LEFT JOIN educational_informations educ ON educ.personal_info_id = p.id
        LEFT JOIN highest_level_of_educations hloe ON hloe.id = educ.highest_level_of_education_id
        WHERE 1
        AND h.status != 'D'
        AND p.status != 'D'
        GROUP BY p.religion_id
                ";

        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }

   

    public function getMonthLy15($where = '', $sortBy = 'p.id DESC') {
		$sql = "SELECT h.*, p.first_name, p.last_name,p.middle_name,p.id AS personal_info_id,p.qualifier,
        p.birthdate,
        p.gender AS gender,mi.name AS monthly_income,emp.name AS employment_status,
        p.id AS personal_info_id,rb.brgyDesc,rcm.citymunDesc,
        rp.provDesc,
        p.qualifier, occu.major_source_of_income,occu.status_of_work_business,
        soi.name AS major_source,sw.name AS status_of_work,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 AS age
        FROM house_holds h 
        LEFT JOIN personal_info p ON p.house_hold_id = h.id 
        LEFT JOIN resident_types rt ON rt.id = p.resident_type_id 
        LEFT JOIN refbrgy rb ON rb.id = p.brgy_id 
        LEFT JOIN refcitymun rcm ON rcm.id = p.municipality_id 
        LEFT JOIN refprovince rp ON rp.id = p.province_id 
        LEFT JOIN monthly_income mi ON mi.id = p.monthly_income_id
        LEFT JOIN occupation_informations occu ON occu.personal_info_id = p.id
        LEFT JOIN source_of_income soi ON soi.id = occu.major_source_of_income
        LEFT JOIN status_of_work_business sw ON sw.id = occu.status_of_work_business
        LEFT JOIN employment_status emp ON emp.id = occu.employment_status_id
        WHERE 1
        AND h.status != 'D'
        AND p.status != 'D'
        AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 BETWEEN 15 AND 100
                ";

        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";

        $rows = $this->db->select($sql);
        return $rows;
    }


    public function getJoinSchool($where = '', $sortBy = 'p.id DESC') {
		$sql = "SELECT h.*, p.first_name, p.last_name,p.middle_name,p.id AS personal_info_id,p.qualifier,
        ht.name AS house_type_name, p.birthdate, p.birth_place,
        p.gender AS gender,cs.name as civil_name,re.name AS religion_name, es.name AS ethnic_name, mi.name AS monthly_income,
        hl.name AS house_location_name,rt.name AS resident_type_name, p.id AS personal_info_id,rb.brgyDesc,rcm.citymunDesc,
        rp.provDesc, occ.name as occ_name, citi.name as citi_name,
        hdr.name as relationship ,educ.highest_level_of_education_id, educ.grade_year_level AS grade_year_level,
        hloe.name as highest_name,hloe.id as highest_id,educ.still_schooling,
        p.qualifier,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
        + 0 AS age, educ.school_id,sch.school_type,
        sl.name AS school_level_name
        FROM house_holds h 
        LEFT JOIN personal_info p ON p.house_hold_id = h.id 
        LEFT JOIN house_types ht ON ht.id = h.house_type_id 
        LEFT JOIN house_locations hl ON hl.id = h.house_location_id 
        LEFT JOIN resident_types rt ON rt.id = p.resident_type_id 
        LEFT JOIN refbrgy rb ON rb.id = p.brgy_id 
        LEFT JOIN refcitymun rcm ON rcm.id = p.municipality_id 
        LEFT JOIN refprovince rp ON rp.id = p.province_id 
        LEFT JOIN civil_status cs ON cs.id = p.civil_status_id
        LEFT JOIN religions re ON re.id = p.religion_id
        LEFT JOIN ethnicities es ON es.id = p.ethnicity_id
        LEFT JOIN monthly_income mi ON mi.id = p.monthly_income_id
        LEFT JOIN occupations occ ON occ.id = p.occupation 
        LEFT JOIN citizenships citi ON citi.id = p.citizenship_id 
        LEFT JOIN household_head_relationship hdr ON hdr.id = p.household_head_relationship_id 
        LEFT JOIN educational_informations educ ON educ.personal_info_id = p.id
        LEFT JOIN highest_level_of_educations hloe ON hloe.id = educ.highest_level_of_education_id
        LEFT JOIN schools sch ON sch.id = educ.school_id
        LEFT JOIN school_level sl ON sl.id = educ.grade_year_level
        WHERE 1
        AND h.status != 'D'
        AND p.status != 'D'
        AND educ.still_schooling = 'Y'
        AND educ.status !='D'
                ";

        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getDeathInfo($where = '', $sortBy = 'p.id DESC') {
		$sql = "SELECT p.last_name, p.middle_name, p.first_name,p.qualifier,p.gender,p.id AS personal_info_id,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 AS age, di.personal_info_id AS id,
        di.date_of_deceased, cd.name, di.burried_at, di.burried_at AS burried_at, cd.name AS cause_of_death
        FROM rbi.personal_info p
        LEFT JOIN death_informations di ON di.personal_info_id = p.id
        LEFT JOIN cause_of_deaths cd ON cd.id = di.cause_of_deaths
        WHERE 1
        AND p.status !='D'
        AND di.status !='D'
        AND cd.status != 'D'
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }
        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }
    public function getsumarryhousehold($where = '', $sortBy = 'p.id ASC', $startFrom = 0, $pageNo = 20, $enableLimit = 'Y') {
		$sql = "SELECT  p.*,hh.household_no ,p.first_name,p.last_name,p.middle_name, DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') 
                + 0 AS age, ht.name as house_type, hl.name as house_location,p.gender,civ.name as civil_name,
                p.qualifier,p.no_street_sitio_purok,p.house_hold_id
                FROM personal_info p
                LEFT JOIN house_holds hh ON hh.id = p.house_hold_id
                LEFT JOIN house_types ht ON ht.id = hh.house_type_id
                LEFT JOIN house_locations hl ON hl.id = hh.house_location_id
                LEFT JOIN civil_status civ ON civ.id = p.civil_status_id
                WHERE p.status != 'D' 
                AND hh.status != 'D'
                AND p.family_head = 'Y'
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }
  
        $sql .= " ORDER BY $sortBy ";

        if($enableLimit == 'Y') {
            $sql .= " LIMIT $startFrom, $pageNo";
        }
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getResidenttypeCount($where = '', $sortBy = 'p.id ASC') {
		$sql = "SELECT p.resident_type_id, r.name
        FROM personal_info p
        LEFT JOIN resident_types r ON r.id = p.resident_type_id
        WHERE 1
        AND p.status != 'D'        
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getindexHtypelocation($where = '', $sortBy = 'h.id ASC') {
		$sql = "SELECT h.house_type_id, h.house_location_id, ht.name,hl.name
        FROM house_holds h
        LEFT JOIN house_types ht ON ht.id = h.house_type_id
        LEFT JOIN house_locations hl ON hl.id =h.house_location_id
        WHERE 1
        AND
        h.status != 'D'        
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";

        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getVaccinationInfo($where = '', $sortBy = 'p.last_name DESC') {
		$sql = "SELECT p.last_name,p.first_name,p.middle_name,cv.name AS brand,vi.dose_type,vi.vaccination_date,p.birthdate,
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 AS age, p.gender AS gender, 
                vi.personal_info_id AS per_id
                FROM rbi.vaccination_informations vi
                LEFT JOIN personal_info p ON p.id = vi.personal_info_id
                LEFT JOIN covid_vaccine_brands cv ON cv.id = vi.covid_vaccine_brand_id
                WHERE 1
                AND p.status !='D'
                AND vi.status !='D'
                AND vi.dose_type = 'F'
                GROUP BY vi.personal_info_id
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getAllVacInfo($where = '', $sortBy = 'p.last_name DESC') {
		$sql = "SELECT p.last_name,p.first_name,p.middle_name,cv.name AS brand,vi.dose_type,vi.vaccination_date,p.birthdate,
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 AS age, p.gender AS gender, 
                vi.personal_info_id AS per_id
                FROM rbi.vaccination_informations vi
                LEFT JOIN personal_info p ON p.id = vi.personal_info_id
                LEFT JOIN covid_vaccine_brands cv ON cv.id = vi.covid_vaccine_brand_id
                WHERE 1
                AND p.status !='D'
                AND vi.status !='D'
                GROUP BY vi.personal_info_id
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }


    public function getFullyVaccinated($where = '', $sortBy = 'p.last_name DESC') {
		$sql = "SELECT p.last_name,p.first_name,p.middle_name,cv.name AS brand,vi.dose_type,vi.vaccination_date,p.birthdate,
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 AS age, p.gender AS gender, 
                vi.personal_info_id AS per_id
                FROM rbi.vaccination_informations vi
                LEFT JOIN personal_info p ON p.id = vi.personal_info_id
                LEFT JOIN covid_vaccine_brands cv ON cv.id = vi.covid_vaccine_brand_id
                WHERE 1
                AND p.status !='D'
                AND vi.status !='D'
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getUnvaccinated($where = '', $sortBy = 'p.last_name DESC') {
		$sql = "SELECT p.last_name,p.first_name,p.middle_name,v.vaccination_date AS vaccination_date,
                v.dose_type AS dose_type,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 AS age
                FROM personal_info p
                LEFT JOIN vaccination_informations v ON v.personal_info_id = p.id
                WHERE 1
                AND p.status != 'D'
                GROUP BY p.id
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function individualVacInfo($where = '', $sortBy = 'p.last_name DESC', $startFrom = 0, $pageNo = 20, $enableLimit = 'Y') {
		$sql = "SELECT p.last_name,p.first_name,p.middle_name,cv.name AS brand,vi.dose_type AS dose_type,
                vi.vaccination_date AS vaccination_date,p.birthdate,
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 AS age, p.gender AS gender
                FROM rbi.vaccination_informations vi
                LEFT JOIN personal_info p ON p.id = vi.personal_info_id
                LEFT JOIN covid_vaccine_brands cv ON cv.id = vi.covid_vaccine_brand_id
                WHERE 1
                AND p.status !='D'
                AND vi.status !='D'
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";

        if($enableLimit == 'Y') {
            $sql .= " LIMIT $startFrom, $pageNo";
        }
        $rows = $this->db->select($sql,'assoc');
        return $rows;
    }


    public function getHealthInfo($where = '', $sortBy = 'p.id DESC') {
		$sql = "SELECT p.last_name, p.middle_name, p.first_name,p.qualifier,p.gender,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 AS age,
        hi.weight, hi.height, hi.bp,hi.illnesses, hi.illnesses AS illnesses
        FROM rbi.health_informations hi
        LEFT JOIN personal_info p ON p.id = hi.personal_info_id
        WHERE 1
        AND p.status != 'D'
        AND hi.status != 'D'
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }
 
        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getEducationInfo($where = '', $sortBy = 'p.id DESC') {
		$sql = "SELECT p.last_name, p.middle_name, p.first_name,p.qualifier,p.gender,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 AS age,
        hloe.name AS highest_level, ed.still_schooling, ed.grade_year_level,
		s.name AS school_name, s.school_type, s.location_type, s.address_for_abroad
        FROM rbi.educational_informations ed
        LEFT JOIN personal_info p ON p.id = ed.personal_info_id
        LEFT JOIN schools s ON s.id = ed.school_id
        LEFT JOIN highest_level_of_educations hloe ON hloe.id = ed.highest_level_of_education_id
        WHERE 1
        AND p.status != 'D'
        AND ed.status != 'D'
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }
        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getOccupationInfo($where = '', $sortBy = 'p.id DESC') {
		$sql = "SELECT p.last_name, p.middle_name, p.first_name,p.qualifier,p.gender,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 AS age,
        o.occupations, o.occupations AS occupations, o.major_source_of_income, o.monthly_income, o.other_source_of_income,
        o.status_of_work_business, o.place_of_work, o.employment_status_id, m.name AS monthly_income, s.name AS major_source_income,
        swb.name AS status_of_work, es.name AS employment_status, o.have_business, o.have_livestock, o.business_name, o.livestocks
        FROM rbi.occupation_informations o
        LEFT JOIN personal_info p ON p.id = o.personal_info_id
        LEFT JOIN monthly_income m ON m.id = o.monthly_income
        LEFT JOIN source_of_income s ON s.id = o.major_source_of_income
        LEFT JOIN status_of_work_business swb ON swb.id = o.status_of_work_business
        LEFT JOIN employment_status es ON es.id = o.employment_status_id
        WHERE 1
        AND p.status != 'D'
        AND o.status != 'D'
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getDafacInfo($where = '', $sortBy = 'h.household_no ASC') {
		$sql = "SELECT p.id AS personal_info_id, p.last_name, p.middle_name, p.first_name,p.qualifier,p.gender, p.birthdate,
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 AS age, h.household_no,
                hhr.name AS relationship, c.name AS calamity_name, ex.name AS extent_of_damage,
                p.family_head AS family_head,hs.name AS house_status, ors.name AS owner_renter_sharer,
                p.occupation AS occupations, m.name AS monthly_income, p.house_hold_id
                FROM dafac daf
                LEFT JOIN personal_info p ON p.id = daf.personal_info_id
                LEFT JOIN house_holds h ON h.id = p.house_hold_id
                LEFT JOIN household_head_relationship hhr ON hhr.id = p.household_head_relationship_id
                LEFT JOIN calamities c ON c.id = daf.calamity_id
                LEFT JOIN extent_of_damage ex ON ex.id = daf.extent_of_damage
                LEFT JOIN house_status hs ON hs.id = daf.house_status
                LEFT JOIN owner_renter_sharer ors ON ors.id = daf.owner_renter_sharer
                LEFT JOIN occupations occ ON occ.id = p.occupation
                LEFT JOIN monthly_income m ON m.id = p.monthly_income_id
                WHERE 1
                AND p.status != 'D'
                AND h.status != 'D'
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy, p.id ASC ";
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getResidentSummary($where = '', $sortBy = 'h.household_no ASC', $startFrom = 0, $pageNo = 20, $enableLimit = 'Y') {
		$sql = "SELECT h.id, h.resident_type_id,rt.name AS resident_type, 
                p.last_name, p.first_name, p.middle_name, p.no_street_sitio_purok,p.qualifier,
                h.household_no
                FROM rbi.house_holds h
                LEFT JOIN personal_info p ON p.house_hold_id = h.id
                LEFT JOIN resident_types rt ON rt.id = p.resident_type_id
                WHERE 1
                AND h.status != 'D'
                AND p.status != 'D'
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";

        if($enableLimit == 'Y') {
            $sql .= " LIMIT $startFrom, $pageNo";
        }
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getIndividualDeath($where = '', $sortBy = 'p.id DESC', $startFrom = 0, $pageNo = 20, $enableLimit = 'Y') {
		$sql = "SELECT p.last_name, p.middle_name, p.first_name,p.qualifier,p.gender,p.id AS personal_info_id,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.birthdate)), '%Y') + 0 AS age, di.personal_info_id AS id,
        di.date_of_deceased, cd.name, di.burried_at, di.burried_at AS burried_at, cd.name AS cause_of_death
        FROM rbi.personal_info p
        LEFT JOIN death_informations di ON di.personal_info_id = p.id
        LEFT JOIN cause_of_deaths cd ON cd.id = di.cause_of_deaths
        WHERE 1
        AND p.status !='D'
        AND di.status !='D'
        AND cd.status != 'D'
                ";
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";

        if($enableLimit == 'Y') {
            $sql .= " LIMIT $startFrom, $pageNo";
        }
        $rows = $this->db->select($sql,'assoc');
        return $rows;
    }


    public function getTotal($where = '', $sortBy = '') {
        
		$sql = "SELECT COUNT(*) AS total_count 
                FROM house_holds h 
                LEFT JOIN personal_info p ON p.house_hold_id = h.id 
                LEFT JOIN house_types ht ON ht.id = h.house_type_id 
                LEFT JOIN house_locations hl ON hl.id = h.house_location_id 
                LEFT JOIN resident_types rt ON rt.id = p.resident_type_id 
                LEFT JOIN refbrgy rb ON rb.id = p.brgy_id 
                LEFT JOIN refcitymun rcm ON rcm.id = p.municipality_id 
                LEFT JOIN refprovince rp ON rp.id = p.province_id 
                LEFT JOIN civil_status cs ON cs.id = p.civil_status_id
                LEFT JOIN religions re ON re.id = p.religion_id
                LEFT JOIN ethnicities es ON es.id = p.ethnicity_id
                LEFT JOIN monthly_income mi ON mi.id = p.monthly_income_id
                LEFT JOIN occupations occ ON occ.id = p.occupation 
                LEFT JOIN citizenships citi ON citi.id = p.citizenship_id 
                LEFT JOIN household_head_relationship hdr ON hdr.id = p.household_head_relationship_id 
                LEFT JOIN educational_informations educ ON educ.personal_info_id = p.id
                LEFT JOIN occupation_informations occu ON occu.personal_info_id = p.id
                LEFT JOIN source_of_income soi ON soi.id = occu.major_source_of_income
                LEFT JOIN status_of_work_business sw ON sw.id = occu.status_of_work_business
                LEFT JOIN highest_level_of_educations hloe ON hloe.id = educ.highest_level_of_education_id
                LEFT JOIN employment_status emp ON emp.id = occu.employment_status_id
                LEFT JOIN schools sch ON sch.id = educ.school_id
                LEFT JOIN dafac daf ON daf.personal_info_id = p.id
                LEFT JOIN calamities c ON c.id = daf.calamity_id
                LEFT JOIN extent_of_damage ex ON ex.id = daf.extent_of_damage
                LEFT JOIN house_status hs ON hs.id = daf.house_status
                LEFT JOIN owner_renter_sharer ors ON ors.id = daf.owner_renter_sharer
                LEFT JOIN civil_status civ ON civ.id = p.civil_status_id
                WHERE 1
                AND h.status != 'D'
                AND p.status != 'D'
                 ";
		
		if(!empty($where)) {
			$sql .= " $where";
		}

		$sql .= " ORDER BY $sortBy ";

		$rows = $this->db->select($sql, 'assoc');
        return $rows['total_count'];
	}

    public function getHouseHoldsJoinWhere($where = '') {
        $sql = "SELECT *, rd.id AS residing_detail_id FROM house_holds h 
                LEFT JOIN residing_details  rd ON rd.house_hold_id = h.id
                LEFT JOIN personal_info p ON p.id = rd.personal_info_id
                WHERE 1 ";

        if(!empty($where)) {
            $sql .= " $where";
        }
        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getcivilstatuscount($where = '', $sortBy = 'name ASC') {
        $sql = "SELECT cs.name,
                (SELECT COUNT(*) FROM personal_info pi 
                WHERE pi.civil_status_id = cs.id 
                AND pi.status != 'D') AS count
                FROM civil_status cs 
                WHERE 1 ";

        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy";
        $rows = $this->db->select($sql);
        return $rows;
    }

}