<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Config.php');
require (DOCUMENT_ROOT . '/models/House_types.php');
require (DOCUMENT_ROOT . '/models/House_locations.php');

$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$config = new Config();
$house_type = new House_types();
$house_location = new House_locations();

$reshouse_type = $house_type->getWhere(" AND status = 'A'");
$reshouse_location = $house_location->getWhere(" AND status = 'A'");

// $resTsag = $tsag->getWhere();
include_once DOCUMENT_ROOT . '/templates/header.php';

// echo json_encode(['brgyID' => '28486', 'provCode' => '0864', 'cityMunCode' => '086403']);
?> 
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Summary of Household Type and Household Location</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Summary of Household Type and Household Location</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Summary of Household Type and Household Location</h5>
                    <form method="post" id="search_name" data-parsley-validate="">
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Household Type</label>
                                                <select id="house_type" name="house_type" class="form-control" style="width: 100%;">
                                                     <option value="">All</option>
                                                         <?php foreach($reshouse_type AS $row_r): ?>
                                                     <option value="<?php echo $row_r['name'] ?>">
                                                         <?php echo $row_r['name'] ?>
                                                     </option>
                                                        <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Household Location</label>
                                                <select id="house_location" name="house_location" class="form-control" style="width: 100%;">
                                                     <option value="">All</option>
                                                         <?php foreach($reshouse_location AS $row_r): ?>
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
                                                <button type="button" id="submit" name="submit" class="form-control" style="width: 80px;"> 
                                                Submit</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label></label>
                                                <a class="btn btn-circle btn-sm btn-primary btn-print" style="width:80px;margin-top:20%;float:right;padding:6px;" id="print" data-href=""><i class="bi bi-printer"></i>Print All</a>
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
                                        <th>Name of Household Head</th>
                                        <th>Age</th>
                                        <th>Sex</th>
                                        <th>Household Size</th>
                                        <th>Household Type</th>
                                        <th>Household Location</th>
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
                url: '<?php echo BASE_URL ?>/api/reports/sumarry-of-household-type-location/get.php',
                type: 'POST',
                data : function ( d ) {
                    return $.extend( {}, d, {
                        "house_type": $('#house_type').val(),
                        "house_location": $('#house_location').val()
                    } );
                },
            },
            "columnDefs": [ {
                "targets": [6],
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
            var house_type = $('#house_type').val();
            var house_location = $('#house_location').val();
            $('#print').data( 'val',house_type);
            var url = 'print.php?house_type='+house_type+'&house_location='+house_location;
            $('#print').data( 'href',url);

            console.log(house_location);
            console.log(house_type);

        })
        $('.dataTables_filter').hide(); 
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