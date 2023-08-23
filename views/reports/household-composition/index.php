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
        <h1>Household Composition By Age and Sex of Household Head and Household Size</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Household Composition By Age and Sex of Household Head and Household Size</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Household Composition By Age and Sex of Household Head and Household Size</h5>
                    <form method="post" id="search_name" data-parsley-validate="">
                                <div class="form-card">
                                    <div class="row">
                                    <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <select id="age" name="age" class="form-control" style="width: 100%;">
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Sex</label>
                                                <select id="gender" name="gender" class="form-control" style="width: 100%;">
                                                    <option value="">All</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Household Size</label>
                                                <input id="house_size" name="house_size" class="form-control" data-parsley="" style="width: 100%;">
                                                  
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label></label>
                                                <button type="button" id="submit" name="submit" class="form-control" style="width: 80px;"> 
                                                Submit</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label></label>
                                                <a class="btn btn-circle btn-sm btn-primary btn-print" style="margin-top:18%;" id="print" data-href=""><i class="bi bi-printer"></i>Print All</a>
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
                url: '<?php echo BASE_URL ?>/api/reports/household-composition/get.php',
                type: 'POST',
                data : function ( d ) {
                    return $.extend( {}, d, {
                        "age": $('#age').val(),
                        "gender": $('#gender').val(),
                        "house_size": $('#house_size').val()
                    } );
                },
            },
            "columnDefs": [ {
                "targets": [4],
                "orderable": false
            } ],
            "order": []
        });
 
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