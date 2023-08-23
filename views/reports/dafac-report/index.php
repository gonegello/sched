<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Config.php');
require (DOCUMENT_ROOT . '/models/Calamities.php');
require (DOCUMENT_ROOT . '/models/Extent_of_damage.php');

  
$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$calamities = new Calamities();
$extent_damage = new Extent_of_damage();
$config = new Config();

$resCalamities = $calamities->getWhere(" AND status = 'A'");
$resExtent = $extent_damage->getWhere(" AND status = 'A'");

// $resTsag = $tsag->getWhere();
include_once DOCUMENT_ROOT . '/templates/header.php';

// echo json_encode(['brgyID' => '28486', 'provCode' => '0864', 'cityMunCode' => '086403']);
?> 
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Residence Records</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">DAFAC Records</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">DAFAC Records</h5>
                    <form method="post" id="search_name" data-parsley-validate="">
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Name of Calamity</label>
                                                <select id="calamity" name="calamity" class="form-control" style="width: 100%;">
                                                <option value="">All</option>
                                                    <?php foreach($resCalamities AS $row_r): ?>
                                                <option value="<?php echo $row_r['name'] ?>">
                                                    <?php echo $row_r['name'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                     
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Extent of Damage</label>
                                                <select id="extent" name="extent" class="form-control" style="width: 100%;">
                                                <option value="">All</option>
                                                    <?php foreach($resExtent AS $row_): ?>
                                                <option value="<?php echo $row_['name'] ?>">
                                                    <?php echo $row_['name'] ?>
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
                                                <a class="btn btn-circle btn-sm btn-primary btn-print" id="print" style="width:80px;margin-top:20%;float:right;padding:7px;" data-val="" data-href=""><i class="bi bi-printer"></i> Print</a>
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
                                    <th>Household No.</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Calamity</th>                           
                                        <th>Extent of Damage</th>                           
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
                url: '<?php echo BASE_URL ?>/api/reports/dafac-report/get.php',
                type: 'POST',
                data : function ( d ) {
                    return $.extend( {}, d, {
                        "calamity": $('#calamity').val(),
                        "extent": $('#extent').val(), 
                    } );
                },

            },
            "columnDefs": [ {
                "targets": [4],
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
            var type_val = $('#calamity').val();
            var extent = $('#extent').val();
            $('#print').data( 'val',type_val);
            var url = 'print.php?calamity='+type_val+'&extent='+extent;
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