<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(DOCUMENT_ROOT . '/inc/helpers.php');
require (DOCUMENT_ROOT . '/models/Config.php');
require (DOCUMENT_ROOT . '/models/Users.php');
require (DOCUMENT_ROOT . '/models/User_roles.php');


$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
$user_role = new Userroles();
$user_id = $_SESSION['SESS_ID'];
$user = new Users();
$resUser = $user->getUser(" AND id = $user_id ");
$first_name = $resUser['first_name'];
$last_name = $resUser['last_name'];
$user_role_id = $resUser['user_role_id'];
$password = $resUser['password'];


$resRole = $user_role->getRole(" AND id = $user_role_id");
$user_role_name = $resRole['name'];

$config = new Config();



// $resTsag = $tsag->getWhere();
include_once DOCUMENT_ROOT . '/templates/header.php';

// echo json_encode(['brgyID' => '2846', 'provCode' => '0864', 'cityMunCode' => '086403']);
?> 
<main id="main" class="main">
<div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>

            </ol>
        </nav>
    </div><!-- End Page Title -->
<section class="section profile">
<div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="" alt="Profile" class="rounded-circle">
              <h2><?php echo $first_name; echo " "; echo $last_name;?></h2>
              <h5><?php echo $user_role_name;?></h5>
            </div>
          </div>

        </div>
        <div class="col-xl-8">

        <div class="card">
        <div class="card-body pt-3">
                
              <div class="" id="profile-change-password">
                  <!-- Change Password Form -->
                  <div class="error-message" id="error-message" ></div>
                  <div class="alert alert-danger" id="danger-message" role="alert" style="display: none;"></div>
                  <div class="alert alert-success" id="success-message" role="alert" style="display: none;"></div>
                  <form method="post" id="frm-update-pass" data-parsley-validate="">
                    <input type="hidden" name="action_type" id="action_type" value="update">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>">
                    <input type="hidden" name="currentPassword" id="currentPassword" value="<?php echo $password;?>">
                  <div class="row mb-3">
                    <h5>Change Password</h5>
                  </div>
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="currentPassword_entered" type="password" class="form-control" id="currentPassword_entered"  data-parsley-required="" data-parsley-required-message="Current Password is required">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newPassword" type="password" class="form-control" id="newPassword"  data-parsley-required="" data-parsley-required-message="New Password is required">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="confirmPassword" type="password" class="form-control" id="confirmPassword" data-parsley-equalto="#newPassword" data-parsley-required="" data-parsley-required-message="Confirm Password is required">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="button" id="btn-save" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->
        </div>
        </div>
        </div>

</section>
</main>

<?php include_once DOCUMENT_ROOT . '/templates/footer.php' ?> 
<script>

$('#btn-save').click(function(){
            if(!$('form#frm-update-pass').parsley().validate()) {
                return;
            }
            var msg = $('.error-message');
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/account-settings/update-password.php',
                type : 'post',
                data : $('#frm-update-pass').serialize(),
                success : function(data) {
                    var json = $.parseJSON(data);

                    if(json['code'] == 0) {
                      msg.html('<div class="alert alert-success">'+ json['message'] +'</div>');
                      // $("#success-message").html("You successfully changed your password");
                      // $("#success-message").show();
                      // $("#currentPassword_entered").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
                      // $("#confirmPassword").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
                      // $("#newPassword").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
                      // $('#currentPassword_entered').val('');
                      // $('#confirmPassword').val('');
                      // $('#newPassword').val('');
                      location.href="/views/account-settings/";
                      
                        
                    } else {
                        msg.html('<div class="alert alert-danger">'+ json['message'] +'</div>');
                        $("#currentPassword_entered").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
                      $("#confirmPassword").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
                      $("#newPassword").css({ 'background-color' : 'white', 'border-color' : '', 'color' : 'black' });
                      $('#currentPassword_entered').val('');
                      $('#confirmPassword').val('');
                      $('#newPassword').val('');
                      
                    }
                }
            })
            return false;
        })
</script>