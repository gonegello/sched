<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Config.php');
require (DOCUMENT_ROOT . '/models/Province.php');

$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$province = new Province();
$config = new Config();
$resProvince = $province->getWhere();
// $resTsag = $tsag->getWhere();
include_once DOCUMENT_ROOT . '/templates/header.php';

// echo json_encode(['brgyID' => '28486', 'provCode' => '0864', 'cityMunCode' => '086403']);
?> 
<main id="main" class="main" style="background:whitesmoke;">

    <div class="pagetitle">
        <h1>App Settings</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">App Settings</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">App Settings</h5>
                    <button type="button" class="btn btn-primary btn-sm float-end" id="btn-add">
                        <span class="fa fa-plus-circle"></span> Add
                    </button>
                    <button type="button" class="btn btn-primary btn-sm float-end" id="btn-generate" style="margin-right:2px;">
                        <span class="fa fa-plus-circle"></span> Generate
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
                                        <th>Value</th>
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
                <h5 class="modal-title">Add</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="error-message"></div>
                <form method="post" id="frm-app-setting" data-parsley-validate="">
                    <input type="hidden" id="action_type" name="action_type" />
                    <input type="hidden" id="id" name="id" />
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" data-parsley-required="" data-parsley-required-message="Name is required">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="value" class="col-sm-2 col-form-label">Value</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="value" name="value" rows="10" data-parsley-required="" data-parsley-required-message="Value is required.">
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
<!-- Generate -->
<div class="modal fade" id="modal-generate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="error-message"></div>
                <form method="post" id="frm-generate" data-parsley-validate="">
                    <div class="col">
                    <input type="hidden" id="address" name="address">
                    <input type="hidden" id="action_type_gen" name="action_type_gen" />
                    <input type="hidden" id="id_gen" name="id_gen" />
                    <input type="hidden" class="form-control" id="name_gen" name="name_gen" value="address">
                        <label for="prov_id">Province</label>
                                <select id="prov_id" name="prov_id" class="form-control" data-parsley-required="" data-parsley-required-message="Province is required"   >
                                    <option value="">Select</option>
                                    <?php foreach($resProvince AS $row_hl): ?>
                                        <option value="<?php echo $row_hl['provCode'] ?>">
                                            <?php echo $row_hl['provDesc'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                        </div>
                        <div class="col">
                            <label for="city_id" class="">Municipality</label>
                            <select id="city_id" name="city_id" class="form-control" data-parsley-required="" data-parsley-required-message="Municipality is required"  >
                                    <option value="">Select Province First</option>
                                </select>   
                        </div>
                        <div class="col">
                            <label for="brgy_id" class="">Barangay</label>
                            <select id="brgy_id" name="brgy_id" class="form-control" data-parsley-required="" data-parsley-required-message="Barangay is required"   >
                                    <option value="">Select Municipality First</option>
                                </select> 
                               
                            </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save_add">Save changes</button>
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
                url: '<?php echo BASE_URL ?>/api/app-settings/get.php',
                type: 'POST'
            },
            "columnDefs": [ {
                "targets": [3],
                "orderable": false
            } ],
            "order": []
        });

        $('#btn-save').click(function(){
            if(!$('form#frm-app-setting').parsley().validate()) {
                return;
            }
            var msg = $('.error-message');
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/app-settings/dml.php',
                type : 'post',
                data : $('#frm-app-setting').serialize(),
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
        
        $('#btn-save_add').click(function(){
            if(!$('form#frm-generate').parsley().validate()) {
                return;
            }
            var msg = $('.error-message');
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/app-settings/generate.php',
                type : 'post',
                data : $('#frm-generate').serialize(),
                success : function(data) {
                    var json = $.parseJSON(data);

                    if(json['code'] == 0) {
                        msg.html('<div class="alert alert-success">'+ json['message'] +'</div>');
                        $('#modal-generate').modal('hide');
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
            $('#name').val('');
            $('#value').val('');
            $('#modal-add').modal('show');
        $('.error-message').text('');
        $('.modal-title').text('Add');


            
        })
        $('#btn-generate').click(function(){
            $('#action_type_gen').val('add');
            $('#prov_id').val('');
            $('#city').val('');
            $('#brgy').val('');
            $('#frm-generate')[0].reset();
            $('#modal-generate').modal('show');
            $('#frm-generate').parsley().reset();
        $('.error-message').text('');
        $('.modal-title').text('Generate Address');
        $('#city_id').html('<option value="'+ 'Select' +'" selected>' + 'Select' + '</option>');
        $('#brgy_id').html('<option value="'+ 'Select' +'" selected>' + 'Select' + '</option>');




            
        })
    });

    //for edit
$(document).on('click', '.btn-edit' ,function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var value = $(this).data('value');
        
        $('#address').removeAttr('data-city-mun-code');
        $('#address').removeAttr('data-brgy-id');
        
        $('.error-message').text('');
        $('.modal-title').text('Edit');
        $('#frm-app-setting').parsley().reset();
        $('#id').val(id);
        $('#action_type').val('update');
        $('#name').val(name); 
        $('#value').val(value);
        if(name == 'address') {
            $('#address').attr('data-city-mun-code', value.cityMunCode);
            $('#address').attr('data-brgy-id', value.brgyID);
        $('#action_type_gen').val('update');
            $('#id_gen').val(id);
            $('#name_gen').val(name); 
            $('#prov_id').val(value.provCode);
            $('#prov_id').trigger('change');
            $('#city_id').val(value.cityMunCode);
            setTimeout(() => {
                        $('#city_id').trigger('change');
                        }, "100");
            $('#brgy_id').val(value.brgyID);
            $('#modal-generate').modal('show');

        } else {
            $('#modal-add').modal('show');
        }
    })
            //delete
   $(document).on('click', 'a.btn-delete', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');

        if(confirm('Are you sure you want delete name: ' + name + '?'))
        {
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/app-settings/dml.php',
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
    $('#prov_id').change(function(){
            if($(this).val() == '')
                return;
            var code = $(this).val();

            $.ajax({
                url : '<?php echo BASE_URL ?>/api/address.php',
                method : 'post',
                data : {code : code, type: 'municipality' },
                success : function(data) {
                    var json = $.parseJSON(data);
                    var option = '<option value="">Select Municipality</option>';
                    // console.log($('#address').data('city-mun-code'));
                    $.each(json, function(){
                        var select = '';

                        if(this['code'] == $('#address').data('city-mun-code')) {
                            select = 'selected';
                        }

                        option += '<option value="'+ this['code'] +'" '+ select +'>';
                        option += this['name'];
                        option += '</option>';
                    })

                    $('#city_id').html(option);
                }
            })            
        })

        $('#city_id').change(function(){

            if($(this).val() == '')
                return;

            var code = $(this).val();

            $.ajax({
                url : '<?php echo BASE_URL ?>/api/address.php',
                method : 'post',
                data : {code : code, type: 'barangay' },
                success : function(data) {
                    var json = $.parseJSON(data);
                    var option = '<option value="">Select Barangay </option>';

                    $.each(json, function(){
                        var select = '';

                        if(this['code'] == $('#address').data('brgy-id')) {
                            select = 'selected';
                        }

                        option += '<option value="'+ this['code'] +'" '+ select +'>';
                        option += this['name'];
                        option += '</option>';
                    })

                    $('#brgy_id').html(option);
                }
            })
        })
        
</script>