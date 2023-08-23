<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Config.php');
require (DOCUMENT_ROOT . '/models/Personal_info.php');

$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$personalinfo = new Personal_info();

// $type           = isset($_GET['type']) ? trim($_GET['type']) : ''; 
// $lastname       = isset($_GET['last_name']) ? trim($_GET['last_name']) : ''; 
// $firstname      = isset($_GET['first_name']) ? trim($_GET['first_name']) : ''; 
// $householdno    = isset($_GET['household_no']) ? trim($_GET['household_no']) : ''; 
// $resrecord = [];
// if($type == 'household') {
//     $where = " AND pi.status != 'D' AND hh.status != 'D'";
//     $where .= " AND pi.first_name = '$firstname' AND pi.last_name = '$lastname'";
//     $resrecord = $personalinfo->getpersonalrecord($where);
// }

include_once DOCUMENT_ROOT . '/templates/header.php';

// echo json_encode(['brgyID' => '28486', 'provCode' => '0864', 'cityMunCode' => '086403']);
?> 
<style>
    .household-section {
        display: none;
    }
</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Total Population By Sex and Age</h1>
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
                    <h5 class="card-title">Total Population By Sex and Age</h5>
                    <form method="post" id="search_name" data-parsley-validate="">
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <select id="type" name="type" class="form-control" style="width: 100%;">
                                                <option value="">All</option>
                                                <option value="0-6">0-6</option>
                                                <option value="7-12">7-12</option>
                                                <option value="13-19">13-19</option>
                                                <option value="20-30">20-30</option>
                                                <option value="31-59">31-59</option>
                                                <option value="60">60 Above</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sex</label>
                                                <select id="sex" name="sex" class="form-control" style="width: 100%;">
                                                <option value="">All</option>
                                                <option value="M">Male</option>                              
                                                <option value="F">Female</option>                              
                                                </select>
                                            </div>
                                        </div>
                                  
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label></label>
                                                <button type="button" id="submit" name="submit" class="form-control" style="width: 80px;"> 
                                                Submit</button>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label></label>
                                                <a class="btn btn-circle btn-sm btn-primary btn-print" style="width: 80px;padding:7px;margin-top:15%;" id="print" data-val="" data-href=""><i class="bi bi-printer"></i> Print</a>    
                                            </div>
                                        </div>
                                     
                                    </div>
                                </div>                             
                            </form>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                            <!--MANAGE ITEMS TABLE--> <!--TABLE NAME : items -->
                            <div class="table-responsive table-custom">
                                <!-- Create the drop down filter -->
                                <table class="table table-striped" id="table-data">
                                    <thead>
                                        <tr> 
                                            <th>Last Name</th>
                                            <th>First Name</th>
                                            <th>Middle Name</th>
                                            <th>Qualifier</th>
                                            <th>Sex</th>
                                            <th>Age</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     
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

var table = $('#table-data').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '<?php echo BASE_URL ?>/api/reports/total-pop-by-sex-age/get.php',
        type: 'POST',
        data : function ( d ) {
            return $.extend( {}, d, {
                "type": $('#type').val(),
                "sex": $('#sex').val(),
                
                
            } );
        },

    },
    "columnDefs": [ {
        "targets": [5],
        "orderable": false
    } ],
    "order": []
});
$('.dataTables_filter').hide(); 
$('#submit').click(function(){
    if(!$('form#search_name').parsley().validate()) {
        return;
    }
    table.ajax.reload();
    var type_val = $('#type').val();
    var sex = $('#sex').val();
            $('#print').data( 'val',type_val);
            var url = 'print.php?bracket='+type_val+'&sex='+sex;
            $('#print').data( 'href',url);

            console.log(type_val);
            console.log(sex);
            console.log(url);
})
 
$(document).on('click', 'a.btn-print', function(){
          
          var type = $(this).data('val');
          var type_url = $(this).data('href');
          console.log(type);
          console.log(type_url);
                  
          const myWindow = window.open(type_url, "", "width=600,height=600");
          myWindow.opener.document.getElementById("demo").innerHTML = type;

})
})

   
</script>