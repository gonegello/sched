<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Config.php');
$moduletitle = 'Audit Log';
$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$config = new Config();

// $resTsag = $tsag->getWhere();
include_once DOCUMENT_ROOT . '/templates/header.php';

// echo json_encode(['brgyID' => '28486', 'provCode' => '0864', 'cityMunCode' => '086403']);
$params = [
    'userid'    => $_SESSION['SESS_ID'],
    'page'      => 'audit-log',
    'action'    => 'view',
    'log'       => 'User view audit log page.',
    'created_at'=> date('Y-m-d H:i:s'),
    'updated_at'=> date('Y-m-d H:i:s')
];
$helpers->logdata($params);
?> 
<main id="main" class="main">

    <div class="pagetitle">
        <h1><?php echo $moduletitle ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $moduletitle ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo $moduletitle ?></h5>
                </div>
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
                                        <th>Page</th>
                                        <th>Action</th>
                                        <th>log</th>
                                        <th>Created Date/Time</th>
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
<!-- Modal for Viewing log-->
<div class="modal fade" id="modal-view" tabindex="-1"> 
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Log</h5>
            </div>
            <div class="modal-body">
                <div class="error-message" id="error-message"></div>
                <form method="post" id="frm-kasambahay-information" class="form-inline" data-parsley-validate="">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" readonly="readonly"/>    
                    </div>
                    <div class="form-group">
                        <label for="page">Page</label>
                        <input type="text" id="page" name="page" class="form-control" readonly="readonly"/>    
                    </div>
                    <div class="form-group">
                        <label for="action">Action</label>
                        <input type="text" id="action" name="action" class="form-control" readonly="readonly"/>    
                    </div>
                    <div class="form-group">
                        <label for="log">Log</label>
                        <textarea id="log" name="log" class="form-control" style="height: 200px;" readonly="readonly"></textarea>    
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php include_once DOCUMENT_ROOT . '/templates/footer.php' ?> 
<script>
    $(document).ready(function(){
        var table = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo BASE_URL ?>/api/audit-log/get.php',
                type: 'POST'
            },
            "columnDefs": [ {
                "targets": [5,6],
                "orderable": false
            } ],
            "order": []
        });        
    });

    $(document).on('click', 'a.btn-view', function(){
        var id = $(this).data('id');

        $.ajax({
            url : '<?php echo BASE_URL ?>/api/audit-log/view.php',
            type : 'post',
            data : { 
                action_type : 'view',
                id : id
            },
            success : function(data) {
                var json = $.parseJSON(data);
                $('#name').val(json.first_name + ' ' + json.last_name);
                $('#page').val(json.page);
                $('#action').val(json.action);
                $('#log').html(json.log);
                $('#modal-view').modal('show');
            }
        })
    })
</script>