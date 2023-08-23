<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Instructors.php');

$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$instructors = new Instructors();

include_once DOCUMENT_ROOT . '/templates/header.php';
$department_id = $_SESSION['SESS_DEPARTMENT_ID'];
?> 
<main id="main" class="main" style="background:whitesmoke;">

    <div class="pagetitle">
        <h1>Instructors</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Instructors</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Instructors</h5>
                    <button type="button" class="btn btn-primary btn-sm float-end" id="btn-add">
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
                                        <th>Firstname</th>
                                        <th>Middle Initial</th>
                                        <th>Lastname</th>
                                        <th>Status</th>
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
<div class="modal fade" id="modal-add" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Add</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="error-message" ></div>
                <form method="post" id="frm-instructors" data-parsley-validate="">
                    <input type="hidden" id="action_type" name="action_type" />
                    <input type="hidden" id="id" name="id" />
                    <input type="hidden" id="department_id" name="department_id" value="<?php echo $department_id;?>" />
                    <div class="row mb-3">
                        <label for="firstname" class="col-sm-2 col-form-label">Firstname</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="firstname" name="firstname"  data-parsley-required="" data-parsley-required-message="Firstname is required" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="middle_initial" class="col-sm-2 col-form-label">Middle Initial</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="middle_initial" name="middle_initial" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lastname" class="col-sm-2 col-form-label">Lastname</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="lastname" name="lastname"  data-parsley-required="" data-parsley-required-message="Firstname is required" >
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                        <span>  
                            <input type="radio" id="active" name="status" checked value="Y" data-parsley-required="true" data-parsley-trigger="click" data-parsley-required-message="Status is required." data-parsley-errors-container="#status-validation-error-block">
                            Active
                        </span>
                        <span>  
                            <input type="radio" id="inactive" name="status" value="N" data-parsley-required="true" data-parsley-trigger="click" data-parsley-required-message="Status is required." data-parsley-errors-container="#status-validation-error-block">
                            Inactive
                        </span>
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
                url: '<?php echo BASE_URL ?>/api/instructors/get.php',
                type: 'POST',
                data : {
                    'id' : '<?php echo $department_id ?>'
                }
            },
            "columnDefs": [ {
                "targets": [5],
                "orderable": false
            } ],
            "order": []
        });

        $('#btn-save').click(function(){
            if(!$('form#frm-instructors').parsley().validate()) {
                return;
            }
            var msg = $('.error-message');
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/instructors/dml.php',
                type : 'post',
                data : $('#frm-instructors').serialize(),
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
            $('#modal-add').modal('show');
            $('#inactive').not(this).prop('checked', false);
            $('#active').not(this).prop('checked', false);
            $('#modal-title').text('Add Instructor');
            $('.error-message').text('');
            $('#frm-instructors')[0].reset();
            $('#frm-instructors').parsley().reset();
           
  
        })

//for edit
$(document).on('click', '.btn-edit' ,function() {
        var id = $(this).data('id');
        var dept_id = $(this).data('department_id');
        var firstname = $(this).data('firstname');
        var middle_initial = $(this).data('middle_initial');
        var lastname = $(this).data('lastname');
        var status = $(this).data('status');

        
        $('#id').val(id);
        $('#department_id').val(dept_id);
        $('#action_type').val('update');
        $('#firstname').val(firstname);
        $('#middle_initial').val(middle_initial);
        $('#lastname').val(lastname);

        if(status == 'Y'){        
                $('#active').not(this).prop('checked', true);      
        }
        else{
                $('#inactive').not(this).prop('checked', true);  
        }

        console.log(id);
        $('#frm-instructors').parsley().reset();
        $('.error-message').text('');
        $('#modal-title').text('Edit Instructor');
        $('#modal-add').modal('show');
    })


           //delete
   $(document).on('click', 'a.btn-delete', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');

        if(confirm('Are you sure you want delete name: ' + name + '?'))
        {
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/instructors/dml.php',
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


    });






   
</script>