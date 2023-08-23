<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Users.php');
require (DOCUMENT_ROOT . '/models/User_roles.php');
require (DOCUMENT_ROOT . '/models/Departments.php');

$helpers = new Helpers();
$userroles = new Userroles();
$departments = new Departments();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}  

$users = new Users();

$resuserroles = $userroles->getWhere();
$resdepartments = $departments->getWhere();
include_once DOCUMENT_ROOT . '/templates/header.php';
?> 
<main id="main" class="main" style="background:whitesmoke;">

    <div class="pagetitle">
        <h1>Users</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Users</h5>
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
                                        <th>First Name</th>
                                        <th>Middle Initial</th>
                                        <th>Last Name</th>
                                        <th>User Role</th>
                                        <th>Department</th>
                                        <th>Username</th>
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
                <div class="error-message"></div>
                <form method="post" id="frm-users" data-parsley-validate="">
                    <input type="hidden" id="action_type" name="action_type" />
                    <input type="hidden" id="id" name="id" />
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label"> First Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="first_name" name="first_name" data-parsley-required="" data-parsley-required-message="First Name is required">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Middle Initial</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="middle_initial" name="middle_initial" data-parsley-required="" data-parsley-required-message="Last Name is required">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label"> Last Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="last_name" name="last_name" data-parsley-required="" data-parsley-required-message="Last Name is required">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username" data-parsley-required="" data-parsley-required-message="Username is required">
                        </div>
                    </div>                    
                    <div class="row mb-3 change-password">
                        <label for="name" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" data-parsley-required="" data-parsley-required-message="Password is required">
                        </div>
                    </div>
                    <div class="row mb-3 change-password">
                        <label for="name" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" data-parsley-equalto="#password" data-parsley-required="" data-parsley-required-message="Confirm Password is required">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">User Roles</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="user_role_id" name="user_role_id" data-parsley-required="" data-parsley-required-message="User role is required">
                                <option value="">Select</option>
                                <?php foreach($resuserroles AS $row) : ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Department</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="department_id" name="department_id" data-parsley-required="" data-parsley-required-message="Department is required">
                                <option value="">Select</option>
                                <?php foreach($resdepartments AS $row) : ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    resuserroles
                    <div class="row mb-3">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                        <span>  
                            <input type="radio" id="active" name="status" checked value="Y" data-parsley-required="true" data-parsley-trigger="click" data-parsley-required-message="Status is required." data-parsley-errors-container="#status-validation-error-block">
                            Active
                        </span>
                        <span>  
                            <input type="radio" id="inactive" name="status" value="D" data-parsley-required="true" data-parsley-trigger="click" data-parsley-required-message="Status is required." data-parsley-errors-container="#status-validation-error-block">
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
<div class="modal fade" id="modal-change_password" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="error-message"></div>
                <form method="post" id="frm-password" data-parsley-validate="" >
                                   
                    <div class="row mb-3 ">
                        <!-- <label for="name" class=" col-form-label">Current Password</label>
                        <div class="col-sm-10"> -->
                        <input type="hidden" id="action_type_res" name="action_type_res">
                    <input type="hidden" id="pass_id" name="pass_id">                   
                    <input type="hidden" id="username_res" name="username_res">                   
                    <input type="hidden" id="first_name_res" name="first_name_res">                   
                    <input type="hidden" id="last_name_res" name="last_name_res">                   
                    <input type="hidden" id="user_role_id_res" name="user_role_id_res">                   
                    <input type="hidden" id="status_res" name="status_res" />
                        <input type="hidden" id="old_pass" name="old_pass">
                            <!-- <input type="password" class="form-control" id="currentPassword" name="currentPassword" data-parsley-required="" data-parsley-required-message="Current Password is required">
                        </div> -->
                    </div>
                    <div class="row mb-3 ">
                        <label for="name" class=" col-form-label">New Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="newPassword" name="newPassword" data-parsley-required="" data-parsley-required-message="New Password is required">
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <label for="name" class=" col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" data-parsley-equalto="#newPassword" data-parsley-required="" data-parsley-required-message="Confirm Password is required">
                        </div>
                    </div>
                    <div class="row mb-3">
                       
                        <div class="col-sm-10">
                    
                        <div id="status-validation-error-block"></div>
                       </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save_password">Save changes</button>
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
                url: '<?php echo BASE_URL ?>/api/users/get.php',
                type: 'POST'
            },
            "columnDefs": [ {
                "targets": [7],
                "orderable": false
            } ],
            "order": []
        });

        $('#btn-save').click(function(){
            if(!$('form#frm-users').parsley().validate()) {
                return;
            }
            var msg = $('.error-message');
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/users/dml.php',
                type : 'post',
                data : $('#frm-users').serialize(),
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

        $('#btn-save_password').click(function(){
            if(!$('form#frm-password').parsley().validate()) {
                return;
            }
            var new_pass = $('#newPassword').val() 
            console.log(new_pass);
            var msg = $('.error-message');
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/users/reset_password.php',
                type : 'post',
                data : $('#frm-password').serialize(),
                success : function(data) {
                    var json = $.parseJSON(data);

                    if(json['code'] == 0) {
                        msg.html('<div class="alert alert-success">'+ json['message'] +'</div>');
                        $('#modal-change_password').modal('hide');
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
            $('#frm-users')[0].reset();
            $('#modal-add').modal('show');
            $('#modal-title').text('Add Users');
            $('.error-message').text('');
            $('#frm-users')[0].reset();
            $('#frm-users').parsley().reset();
            $('.change-password').show();
            $('#password').attr('data-parsley-required', 'true');
            $('#confirm_password').attr('data-parsley-required', 'true');
        })
   
    //for edit
    $(document).on('click', '.btn-edit' ,function() {
        var id           = $(this).data('id');
        var first_name   = $(this).data('first_name');
        var middle_initial   = $(this).data('middle_initial');
        var last_name    = $(this).data('last_name');
        var user_role_id = $(this).data('user_role_id');
        var department_id = $(this).data('department_id');
        var username     = $(this).data('username');
        var status       = $(this).data('status');      
       
        $('#modal-title').text('Edit Users');
        $('.error-message').text('');
        $('#frm-users')[0].reset();
        $('#frm-users').parsley().reset();
        $('#id').val(id);
        $('#action_type').val('update');
        $('#first_name').val(first_name);
        $('#middle_initial').val(middle_initial);
        $('#last_name').val(last_name);
        $('#user_role_id').val(user_role_id);
        $('#department_id').val(department_id);
        $('#username').val(username);
        $('#password').val('');
        $('#status').val(status);
        $('#password').removeAttr('data-parsley-required');
        $('#confirm_password').removeAttr('data-parsley-required');
        $('.change-password').hide();
      
        
          if(status == 'Y'){ //if status is active
            $('#active').prop('checked', true);
            $('#inactive').prop('checked', false);
        }
        else if(status == 'D'){ //if status is inactive

            $('#inactive').prop('checked', true);
            $('#active').prop('checked', false);

        }
        else{ //if status is deleted
            $('#active').prop('checked', false);
            $('#inactive').prop('checked', false);
        }

        $('#modal-add').modal('show');
    })


    //for reset password
    $(document).on('click', '.btn-reset' ,function() {
        var id           = $(this).data('id');
        var password     = $(this).data('password');
        var first_name     = $(this).data('first_name');
        var middle_initial     = $(this).data('middle_initial');
        var last_name     = $(this).data('last_name');
        var username     = $(this).data('username');
        var user_role_id     = $(this).data('user_role_id');
        var status     = $(this).data('status');  
    
        $('#frm-password')[0].reset();
        $('#frm-password').parsley().reset();
        $('#modal-title').text('Change Password');
        $('.error-message').text('');
        $('#pass_id').val(id);
        $('#old_pass').val(password);
        $('#first_name_res').val(first_name);
        $('#user_role_id_res').val(user_role_id);
        $('#last_name_res').val(last_name);
        $('#username_res').val(username);
        $('#status_res').val(status);
        $('#action_type_res').val('update');
     
        $('#modal-change_password').modal('show');
    })


    //delete
    $(document).on('click', 'a.btn-delete', function(){
        var id = $(this).data('id');
        var first_name = $(this).data('first_name');

        if(confirm('Are you sure you want delete first_name: ' + first_name + '?'))
        {
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/users/dml.php',
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