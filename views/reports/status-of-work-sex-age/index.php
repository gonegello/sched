<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Config.php');
require (DOCUMENT_ROOT . '/models/Status_Work_Business.php');

 
$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$status_of_work = new Status_Work_Business();
$config = new Config();

$res_workstatus = $status_of_work->getWhere(" AND status = 'A'");

// $resTsag = $tsag->getWhere();
include_once DOCUMENT_ROOT . '/templates/header.php';

// echo json_encode(['brgyID' => '28486', 'provCode' => '0864', 'cityMunCode' => '086403']);
?> 
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Status of Work and Business (15 years old and above) By Age and Sex Records</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Status of Work and Business (15 years old and above) By Age and Sex Records</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Status of Work and Business (15 years old and above) By Age and Sex Records</h5>
                    <form method="post" id="search_name" data-parsley-validate="">
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Status of Work</label>
                                                <select id="status_work" name="status_work" class="form-control" style="width: 100%;">
                                                    <option value="">All</option>
                                                         <?php foreach($res_workstatus AS $row_r): ?>
                                                    <option value="<?php echo $row_r['name'] ?>">
                                                        <?php echo $row_r['name'] ?>
                                                    </option>
                                                        <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                  
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label></label>
                                                <button type="button" id="submit"  name="submit" class="form-control" style="width: 80px;"> 
                                                Submit</button>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label></label>
                                                <a class="btn btn-circle btn-sm btn-primary btn-print" style="width:80px;margin-top:20%;float:right;padding:7px;" id="print" data-val="" data-href=""><i class="bi bi-printer"></i> Print</a>
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
                     
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Middle Name</th>
                                        <th>Status of Work Business</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                       
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
                url: '<?php echo BASE_URL ?>/api/reports/status-of-work-sex-age/get.php',
                type: 'POST',
                data : function ( d ) {
                    return $.extend( {}, d, {
                        "status_work": $('#status_work').val(),
                        
                        
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
        $(document).on('click', '#submit', function(){
            if(!$('form#search_name').parsley().validate()) {
                return;
            }
            table.ajax.reload();
            var type_val = $('#status_work').val();
            $('#print').data( 'val',type_val);
            var url = 'print.php?status_work='+type_val;
            $('#print').data( 'href',url);

            console.log(type_val);
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