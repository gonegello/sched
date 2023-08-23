<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Death_information.php');

$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$death_info = new Death_informations();

// $resTsag = $tsag->getWhere();
include_once DOCUMENT_ROOT . '/templates/header.php';

// echo json_encode(['brgyID' => '28486', 'provCode' => '0864', 'cityMunCode' => '086403']);
?> 
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Common Disease That Cause Death</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Common Disease That Cause Death</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Common Disease That Cause Death</h5>
                    
                <div class="card-body">
                    <div class="col-md-1 float-end">
                         <div class="form-group ">
                                <label></label>
                                 <a class="btn btn-circle btn-sm btn-primary btn-print" id="print" data-val="" data-href="" style="width: 80px;"><i class="bi bi-printer"></i> Print</a>
                                </div>
                        </div>
                    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                         <!--MANAGE ITEMS TABLE--> <!--TABLE NAME : items -->
                        <div class="table-responsive table-custom">
                            <!-- Create the drop down filter -->
                            <table class="table table-striped" id="table-data">
                                <thead>
                                    <tr> 
                                        <th>Cause of Death</th>
                                        <th>Number of Death</th>
                                        <!-- <th>Action</th> -->
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
    </section>
</main>
<?php include_once DOCUMENT_ROOT . '/templates/footer.php' ?> 
<script>
    $(document).ready(function(){
        var table = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo BASE_URL ?>/api/reports/common-cause-death/get.php',
                type: 'POST',
            },
            "columnDefs": [ {
                "targets": [1],
                "orderable": false
            } ],
            "order": []
        });
    })

    $(document).on('click', 'a.btn-print', function(){
      
        var id = $(this).data('id');
        // var url = $(this).data('href');
        const myWindow = window.open('print.php', "", "width=600,height=600");
        myWindow.opener.document.getElementById("demo").innerHTML = id;
  
    })
</script>