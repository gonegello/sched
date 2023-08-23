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

$menu_id = $_GET['id'];
$menu_name = $_GET['menu_name'];
$decryptedmenu_Id = $helpers->encryptDecrypt($menu_id, $action = 'decrypt'); 

// echo json_encode(['brgyID' => '28486', 'provCode' => '0864', 'cityMunCode' => '086403']);
?> 
<main id="main" class="main" style="background:whitesmoke;">

    <div class="pagetitle">
        <h1>Sub Menu</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Settings</a></li>
                <li class="breadcrumb-item"><a href="/views/settings/menu/">Menu</a></li>
                <li class="breadcrumb-item active">Sub Menu</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sub-Menu</h5>
                    <span><?php echo $menu_name;?></span>
                    <button type="button" class="btn btn-primary btn-sm float-end" id="btn-add">
                        <span class="fa fa-plus-circle"></span> Add Sub Menu
                    </button>
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                         <!--MANAGE ITEMS TABLE--> <!--TABLE NAME : items -->
                        <div class="table-responsive table-custom">
                            <!-- Create the drop down filter -->
                            <table class="table table-striped" id="table-data">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Url</th>
                                        <th>Icon</th>
                                        <th>Sort</th>
                                        <th>Status</th>
                                        <th>Created </th>
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

<!-- Modal for Adding Menu-->
<div class="modal fade" id="modal-add" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Add Sub-Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="error-message" id="error-message"></div>
                <form method="post" id="frm-sub-menu" data-parsley-validate="">
                    <input type="hidden" id="action_type" name="action_type" />
                    <input type="hidden" id="id" name="id" />
                    <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $decryptedmenu_Id;?>" />

                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" data-parsley-required="" data-parsley-required-message="Name is required">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="value" class="col-sm-2 col-form-label">URL</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="url" name="url" data-parsley-required="" data-parsley-required-message="URL is required.">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="value" class="col-sm-2 col-form-label">Icon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="icon" name="icon" data-parsley-required="" data-parsley-required-message="Icon is required.">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="value" class="col-sm-2 col-form-label">Sort</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="sort" name="sort" min="1" data-parsley-required="" data-parsley-required-message="Sort is required.">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="value" class="col-sm-2 col-form-label">Active Keyword</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="active_keyword" name="active_keyword" data-parsley-required="" data-parsley-required-message="Active keyword is required for the menu active.">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="value" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <span style="margin-right:1%;">  <input type="radio" id="active" name="status"  checked value="Y" data-parsley-required="true" data-parsley-trigger="click" data-parsley-required-message="Status is required." data-parsley-errors-container="#status-validation-error-block"> Active</span>
                            <span>  <input type="radio" id="inactive" name="status" value="N" data-parsley-required="true" data-parsley-trigger="click" data-parsley-required-message="Status is required." data-parsley-errors-container="#status-validation-error-block"> Inactive</span>
                            <div id="status-validation-error-block"></div>
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save">Save changes</button>
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
                url: '<?php echo BASE_URL ?>/api/menu/sub-menu/get.php',
                type: 'POST',
                data : {
                    'id' : '<?php echo $menu_id ?>'
                }
            },
            "columnDefs": [ {
                "targets": [6],
                "orderable": false
            } ],
            "order": []
        });

        $('#btn-save').click(function(){
            if(!$('form#frm-sub-menu').parsley().validate()) {
                return;
            }
            var msg = $('.error-message');
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/menu/sub-menu/dml.php',
                type : 'post',
                data : $('#frm-sub-menu').serialize(),
                success : function(data) {
                    var json = $.parseJSON(data);

                    if(json['code'] == 0) {
                        msg.html('<div class="alert alert-success">'+ json['message'] +'</div>');
                        $('#modal-add').modal('hide');
                        table.ajax.reload();
                    } else {
                        msg.html('<div class="alert alert-danger">'+ json['message'] +'</div>');
                    }
                }
            })
            return false;
        })

        $('#btn-add').click(function(){
            $('#action_type').val('add');
            $('#id').val('');
            $('#frm-sub-menu')[0].reset();
            $('#modal-add').modal('show');
            $('#modal-title').text('Add Sub-Menu');
        })
    });


    


//for edit
$(document).on('click', '.btn-edit' ,function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var url = $(this).data('url');
        var icon = $(this).data('icon');
        var sort = $(this).data('sort');
        var status = $(this).data('status');
        var activekeyword = $(this).data('active-keyword');

        $('#id').val(id);
        $('#action_type').val('update');
        $('#name').val(name);
        $('#url').val(url);
        $('#icon').val(icon);
        $('#sort').val(sort);
        $('#status').val(status);
        $('#active_keyword').val(activekeyword);

        if(status == 'Y'){ //if status is active
            $('#active').prop('checked', true);
            // $('#inactive').prop('checked', false);
        }
        else { //if status is inactive

            // $('#inactive').prop('checked', true);
            $('#active').prop('checked', false);

        }

        $('#modal-add').modal('show');
        $('#modal-title').text('Edit Sub-Menu');
    })

    //for delete

    $(document).on('click', 'a.btn-delete', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');

        if(confirm('Are you sure you want delete name: ' + name + '?'))
        {
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/menu/sub-menu/dml.php',
                type : 'post',
                data : { action_type : 'delete', 'id' : id },
                success : function(data) {
                    var json = $.parseJSON(data);
                    if(json['code'] == 0) {
                        alert(json['message']);
                        $('#table-data').DataTable().ajax.reload();
                    } else {
                        alert(json['message']);
                    }
                }
            })
        }
    })

    //clearing modal styles
    $('body').on('hidden.bs.modal', '.modal', function () {
        console.log("modal closed");
       
        $("#error-message").html("");
        $("#name").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
        $('#frm-sub-menu').parsley().reset();
            
    });
   
</script>