<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Classrooms.php');

$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$classrooms = new Classrooms();

// $resTsag = $tsag->getWhere();
include_once DOCUMENT_ROOT . '/templates/header.php';
$department_id = $_SESSION['SESS_DEPARTMENT_ID'];
// echo json_encode(['brgyID' => '28486', 'provCode' => '0864', 'cityMunCode' => '086403']);
?> 
<main id="main" class="main" style="background:whitesmoke;">

    <div class="pagetitle">
        <h1>Classrooms</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Classrooms</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Classrooms</h5>
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
                                        <th>Name</th>
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
                <form method="post" id="frm-classrooms" data-parsley-validate="">
                    <input type="hidden" id="action_type" name="action_type" />
                    <input type="hidden" id="id" name="id" />
                    <input type="hidden" id="department_id" name="department_id" value="<?php echo $department_id;?>" />
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name"  data-parsley-required="" data-parsley-required-message="Name is required" >
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
                url: '<?php echo BASE_URL ?>/api/classrooms/get.php',
                type: 'POST',
                data : {
                    'id' : '<?php echo $department_id ?>'
                }
            },
            "columnDefs": [ {
                "targets": [3],
                "orderable": false
            } ],
            "order": []
        });

        $('#btn-save').click(function(){
            if(!$('form#frm-classrooms').parsley().validate()) {
                return;
            }
            var msg = $('.error-message');
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/classrooms/dml.php',
                type : 'post',
                data : $('#frm-classrooms').serialize(),
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
            $('#modal-title').text('Add Classroom');
            $('.error-message').text('');
            $('#frm-classrooms')[0].reset();
            $('#frm-classrooms').parsley().reset();
           
  
        })

//for edit
$(document).on('click', '.btn-edit' ,function() {
        var id = $(this).data('id');
        var dept_id = $(this).data('department_id');
        var name = $(this).data('name');
        var status = $(this).data('status');

        
        $('#id').val(id);
        $('#department_id').val(dept_id);
        $('#action_type').val('update');
        $('#name').val(name);

      
        
      

        if(status == 'Y'){        
                $('#active').not(this).prop('checked', true);      
        }
        else{
                $('#inactive').not(this).prop('checked', true);  
        }

        console.log(id);
        $('#frm-classrooms').parsley().reset();
        $('.error-message').text('');
        $('#modal-title').text('Edit Classroom');
        $('#modal-add').modal('show');
    })


           //delete
   $(document).on('click', 'a.btn-delete', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');

        if(confirm('Are you sure you want delete name: ' + name + '?'))
        {
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/classrooms/dml.php',
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