<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/User_roles.php');

$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$tsag = new Userroles();

$resTsag = $tsag->getWhere();
include_once DOCUMENT_ROOT . '/templates/header.php';

?>   
<main id="main" class="main" style="background:whitesmoke;">

<div class="pagetitle">
    <h1>User Roles</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Settings</a></li>
            <li class="breadcrumb-item active">User Roles</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">User Roles</h5>
                <input type="hidden" id="action" value="" />
                <button type="button"  class="btn btn-primary btn-sm float-end" id="btn-add">
                    <span class="fa fa-plus-circle"></span> Add
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

        <!--add Farmer Modal Form-->
        <div class="modal fade" id="form_modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" id="frm-user-roles" data-parsley-validate="">
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="action_type" name="action_type" value="add">
                        <div class="modal-header">
                        <h5 class="modal-title">Add User Role</h5>
                        </div>
                        <div class="modal-body">
                            <div class="error-message">
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" autocomplete = "off" data-parsley-required="" data-parsley-required-message="Name no is required."/>
                                </div>
                                <div class="form-group">
                                <label>Status :</label>
                                            &nbsp;
                                            <input type="radio"  name="status" id ="status_yes" value="Y" data-parsley-required="true" data-parsley-trigger="click" data-parsley-required-message="Status is required.">Active</label>
                                            &nbsp;
                                            <input type="radio" name="status" id ="status_no" value="N" data-parsley-required="true" data-parsley-trigger="click" data-parsley-required-message="Status is required.">Inactive</label>
                                            <br>
                                </div>
                               
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="btn-save">Save changes</button>
            </div>
                            </div>
                        </div>
                    </form>
                </div>
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
                url: '<?php echo BASE_URL ?>/api/get-user-roles.php',
                type: 'POST',
                data:   function ( d ) {
                    return $.extend( {}, d, {
                        'action' : getAction()
                    } );
                },
                "dataSrc": function ( json ) {
                    
                    if($('#action').val() == 'excel') {
                        window.open(json.url, '_blank');
                    }

                    if($('#action').val() == 'print') {
                        // window.open(json.url);
                        createPopupWin(json.url, 'Lots')
                    }
                    return json.data;
                }                    
            },
            "columnDefs": [ {
                "targets": [3],
                "orderable": false
            } ],
            "order": []
        });

        $("#table-data_filter.dataTables_filter").prepend($("#label-category"));

        $("#tsag-filter").change(function (e) {
            table.ajax.reload();
        });

        $('#btn-save').click(function()
        {
            if(!$('form#frm-user-roles').parsley().validate()) {
                return;
            }
            var msg = $('.error-message');
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/user-roles-types.php',
                type : 'post',
                data : $('#frm-user-roles').serialize(),
                success : function(data) {
                    var json = $.parseJSON(data);

                    if(json['code'] == 0) {
                        msg.html('<div class="alert alert-success">'+ json['message'] +'</div>');
                        $('#form_modal').modal('hide');
                        table.ajax.reload();
                    } else {
                        msg.html('<div class="alert alert-danger">'+ json['message'] +'</div>');
                    }
                }
            })
            return false;
        })

        $('#btn-add').click(function(){
            $('.modal-title').html('Add User Roles');
            $('#action_type').val('add');
            $('#id').val('');
            $('#name').val('');
            $('#status_yes').not(this).prop('checked', true);
            $('#status_no').not(this).prop('checked', false);

            

            $('.error-message').html('');
            //Show modal
            $('#form_modal').modal('show');
        })

        $('#export-to-csv').click(function(){
            $('#action').val('excel');
            table.ajax.reload();
        })

        $('#print').click(function(){
            $('#action').val('print');
            table.ajax.reload();
        })

        $('body').click(function(evt){    
            $('#action').val('');
            if(evt.target.id == "export-to-csv")
            {
                $('#action').val('excel');
            }

            if(evt.target.id == "print")
            {
                $('#action').val('print');
            }
        });
    })
    
    //Bind to edit
    $(document).on('click', 'a.btn-edit', function(){
        $('.modal-title').html('Edit User Roles');
        $('#action_type').val('update');
        $('#id').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        $('#status_no').click();
        // $('#status_no').attr('checked', false);
        if($(this).data('status') == 'Y'){
            $('#status_yes').click();
        }else
        {
            $('#status_no').click();

        }
        $('.error-message').html('');

        //Show modal
        $('#form_modal').modal('show');
    });

    $(document).on('click', 'a.btn-delete', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');

        if(confirm('Are you sure you want delete user: ' + name + '?'))
        {
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/user-roles-types.php',
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

    function getAction()
    {
        return $('#action').val();
    }

    function createPopupWin(pageURL, pageTitle) {
        var popupWinWidth   = 800;
        var popupWinHeight  = 650;
        var left = (screen.width - popupWinWidth) / 2;
        var top = (screen.height - popupWinHeight) / 4;
            
        var myWindow = window.open(pageURL, pageTitle,
                'resizable=yes, width=' + popupWinWidth
                + ', height=' + popupWinHeight + ', top='
                + top + ', left=' + left);
    }

</script>