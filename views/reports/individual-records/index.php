<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Config.php');

$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$config = new Config();

// $resTsag = $tsag->getWhere();
include_once DOCUMENT_ROOT . '/templates/header.php';

// echo json_encode(['brgyID' => '28486', 'provCode' => '0864', 'cityMunCode' => '086403']);
?> 
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Individual Records</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Individual Records</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Individual Records</h5>
                    <form method="post" id="search_name" data-parsley-validate="">
                                <div class="form-card">
                                    <div class="row">
                                    <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select id="type" name="type" class="form-control">
                                        <option value="all">All</option>
                                            <option value="individual">Indivual Record</option>
                                            <option value="purok">By Purok</option>
                                        </select>
                                    </div>
                                </div>
                                        <div class="col-md-3 personal" style="display: none;">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" id="first_name" name="first_name" class="form-control" data-parsley-group="block1" data-parsley-required="" data-parsley-required-message="First Name is required"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3 personal" style="display: none;">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" id="last_name" name="last_name" class="form-control" data-parsley-group="block1" data-parsley-required="" data-parsley-required-message="Last Name is required"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3 purok-section" style="display: none;">
                                            <div class="form-group">
                                                <label>Purok</label>
                                                <input type="text" id="purok" name="purok" class="form-control" data-parsley-group="block1" data-parsley-required="" data-parsley-required-message="Purok is required"/>
                                            </div>
                                        </div>
                                        <div class="col-md-2" >
                                            <div class="form-group">
                                                <label></label>
                                                <button type="button" id="submit" name="submit" class="form-control" style="width: 80px;"> 
                                                Submit</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label></label>
                                                <a class="btn btn-circle btn-sm btn-primary btn-print-all" style="margin-top:18%;display:none;" id="print" data-href="consolidated-print.php"><i class="bi bi-printer"></i>Print All</a>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label></label>
                                                <a class="btn btn-circle btn-sm btn-primary btn-print-purok" style="margin-top:18%;display:none;" id="print_purok" data-href="by-purok.php"><i class="bi bi-printer"></i>Print</a>
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
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Middle Name</th>
                                        <th>Date Of Birth</th>
                                        <th>Purok</th>
                                        <th>Action</th>
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
        $('#type').change(function(){
            $('#first_name').removeAttr('data-parsley-required');
            $('#last_name').removeAttr('data-parsley-required');
            $('#purok').removeAttr('data-parsley-required');
            $('#purok').val('');
            $("#last_name").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
            $("#first_name").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
            $("#purok").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
            $('#print').show();  
            $('#print_purok').hide();  
            $('.purok-section').hide();
            $('.personal').hide();
            if($(this).val() == 'purok') {
                $('#first_name').val('');
                $('#last_name').val('');
                $("#last_name").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
                $("#first_name").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
                $("#purok").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
                $('#first_name').removeAttr('data-parsley-required');
                $('#last_name').removeAttr('data-parsley-required');
                $('#purok').attr('data-parsley-required', true);
                $('.personal').hide();
                $('.purok-section').show();
                $('#print').hide();   
                $('#print_purok').show();   
 
            } 
            if($(this).val() == 'individual'){
                $('#purok').val('');
                $("#last_name").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
                $("#first_name").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
                $("#purok").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
                $('#purok').removeAttr('data-parsley-required');   
                $('#first_name').attr('data-parsley-required', true);
                $('#last_name').attr('data-parsley-required', true);
                $('.personal').show();
                $('.purok-section').hide();
                $('#print').hide();   
                $('#print_purok').hide();   

            }
        })

        $('#type').trigger('change');
    })
    $(document).ready(function(){
        var table = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo BASE_URL ?>/api/reports/individual-records/get.php',
                type: 'POST',
                data : function ( d ) {
                    return $.extend( {}, d, {
                        "first_name": $('#first_name').val(),
                        "last_name": $('#last_name').val(),
                        "purok": $('#purok').val()
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
           
            var purok = $('#purok').val();
             var url = 'by-purok.php?purok='+purok;
            $('#print_purok').data( 'val', purok);
            $('#print_purok').data( 'href',url);
           
            
        })
    })

   
    $(document).on('click', 'a.btn-print-all', function(){
        const myWindow = window.open("consolidated-print.php", "", "width=600,height=600");
        myWindow.opener.document.getElementById("demo").innerHTML = "";
  
    })
    $(document).on('click', 'a.btn-print-in', function(){
        var url = $(this).data('href');
        var id = $(this).data('id');
        const myWindow = window.open(url, "","width=600,height=600");
        myWindow.opener.document.getElementById("demo").innerHTML = id;
  
    })

    $(document).on('click', 'a.btn-print-purok', function(){
      
      var id = $(this).data('id');
      var url = $(this).data('href');
      const myWindow = window.open(url, "", "width=600,height=600");
      myWindow.opener.document.getElementById("demo").innerHTML = id;

  })
</script>