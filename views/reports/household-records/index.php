<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Config.php');
require (DOCUMENT_ROOT . '/models/Personal_info.php');
require (DOCUMENT_ROOT . '/models/Occupations.php');

$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$personalinfo   = new Personal_info();
$occupations    = new Occupations();

$type           = isset($_GET['type']) ? trim($_GET['type']) : ''; 
$lastname       = isset($_GET['last_name']) ? trim($_GET['last_name']) : ''; 
$firstname      = isset($_GET['first_name']) ? trim($_GET['first_name']) : ''; 
$householdno    = isset($_GET['household_no']) ? trim($_GET['household_no']) : ''; 
$resrecord = [];
if($type == 'household') {
    $where = " AND pi.status != 'D' AND hh.status != 'D' AND pi.family_head = 'Y'";
    $where .= " AND pi.first_name = '$firstname' AND pi.last_name = '$lastname'";
    if(!empty($householdno)) {
        $where .= " AND hh.household_no = $householdno";
    }
    $resrecord = $personalinfo->getpersonalrecord($where);
} else if ($type == 'all') {
    $where = " AND pi.family_head = 'Y'";
    $where .= " AND pi.status != 'D' AND hh.status != 'D' ";
    $respersonalinfo = $personalinfo->getpersonalrecord($where);
}

include_once DOCUMENT_ROOT . '/templates/header.php';
?> 
<style>
    .household-section {
        display: none;
    }
</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Household Records</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Household Records</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Household Records</h5>
                    <form id="search_name" data-parsley-validate="">
                        <div class="form-card">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select id="type" name="type" class="form-control">
                                            <option value="all" <?php echo ($type == 'all') ? 'selected' : '' ?>>All</option>
                                            <option value="household" <?php echo ($type == 'household') ? 'selected' : '' ?>>By Household</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 household-section">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" id="last_name" name="last_name" value="<?php echo $lastname ?>" class="form-control" data-parsley-group="block1" data-parsley-required-message="Firstname is required"/>
                                    </div>
                                </div>
                                <div class="col-md-3 household-section">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" id="first_name" name="first_name" value="<?php echo $firstname ?>" class="form-control" data-parsley-group="block1" data-parsley-required-message="Lastname is required"/>
                                    </div>
                                </div>
                                <!--
                                <div class="col-md-3 household-section">
                                    <div class="form-group">
                                        <label>Household Number</label>
                                        <input type="text" id="household_no" name="household_no" value="" class="form-control" data-parsley-group="block1" data-parsley-required-message="Household Number is required"/>
                                    </div>
                                </div>-->
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label></label>
                                        <button type="submit" id="submit" name="submit" class="form-control" style="width: 80px;"> 
                                            Submit
                                        </button>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </form>
                    <div class="card-body">
                        <?php if ($type == 'all' && !empty($respersonalinfo)) : ?>
                            <a class="btn btn-primary btn-print-all float-end" data-href="<?php echo BASE_URL ?>/views/reports/household-records/all-print.php?type=all"><i class="bx bxs-printer"></i> Print</a>
                        <?php endif; ?>
                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                            <!--MANAGE ITEMS TABLE--> <!--TABLE NAME : items -->
                            <div class="table-responsive table-custom">
                                <!-- Create the drop down filter -->
                                <table class="table table-striped" id="table-data">
                                    <thead>
                                        <tr> 
                                            <th>Household No.</th>
                                            <th>Last</th>
                                            <th>First</th>
                                            <th>Middle</th>
                                            <th>Qualifier</th>
                                            <?php if($type == 'household'): ?>
                                            <th>Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($type == 'household'): ?>
                                            <?php if(!empty($resrecord)) { ?>
                                                <?php foreach($resrecord as $row): ?>
                                                    <tr>
                                                        <td><?php echo $row['household_no'] ?></td>
                                                        <td><?php echo $row['last_name'] ?></td>
                                                        <td><?php echo $row['first_name'] ?></td>
                                                        <td><?php echo $row['middle_name'] ?></td>
                                                        <td><?php echo $row['qualifier'] ?></td>
                                                        <td>
                                                            <a class="btn btn-print-household" data-id="<?php echo $row['personal_info_id'] ?>" data-href="<?php echo BASE_URL ?>/views/reports/household-records/household-print.php?id=<?php echo $helpers->encryptDecrypt($row['house_hold_id']) ?>">
                                                                <i class="bx bxs-printer"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php } ?>

                                            <?php if(empty($resrecord)) { ?>
                                                <tr>
                                                    <td colspan="6">No record found!</td>
                                                </tr>
                                            <?php } ?>
                                        <?php endif; ?>

                                        <?php if($type == 'all'): ?>
                                            <?php foreach ($respersonalinfo as $row) : 
                
                                                $occupationname = '';
                                                if (!empty($row['occupation'])) {
                                                    $resoccupationname = $occupations->getoccupationname(" AND id IN(" . $row['occupation'] . ")");
                                                    $occupationname = $resoccupationname['name'];
                                                }

                                                $where = " AND pi.family_head_id = " . $row['personal_info_id'];
                                                $where .= " AND pi.status != 'D' AND hh.status != 'D' ";
                                                $resgetmembers = $personalinfo->getpersonalrecord($where);

                                                ?>
                                                <tr class="tr-border">
                                                    <td class="td-border">
                                                        <?php echo $row['household_no'] ?>
                                                    </td>
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
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include_once DOCUMENT_ROOT . '/templates/footer.php' ?> 
<script>
    $(document).ready(function(){
        $('#type').change(function(){
            $('#first_name').removeAttr('data-parsley-required');
            $('#last_name').removeAttr('data-parsley-required');            
            $('#household_no').removeAttr('data-parsley-required');            
            if($(this).val() == 'all') {
                $('#first_name').val('');
                $('#last_name').val('');
                $('.household-section').hide();
            } else {
                // $('#first_name').attr('data-parsley-required', true);
                // $('#last_name').attr('data-parsley-required', true);
                $('.household-section').show();
            }
        })

        $('#type').trigger('change');
    })

    $(document).on('click', 'a.btn-print-household', function(){
      
        var id = $(this).data('id');
        var url = $(this).data('href');
        const myWindow = window.open(url, "", "width=1000,height=600");
        myWindow.opener.document.getElementById("demo").innerHTML = id;
  
    })

    $(document).on('click', 'a.btn-print-all', function(){      
        var url = $(this).data('href');
        const myWindow = window.open(url, "", "width=1000,height=600");
    })
    
</script>