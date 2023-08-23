<?php
include('inc/app_settings.php');
require_once('inc/helpers.php');
$helpers = new Helpers();



// include('models/Dashboard.php');
include_once 'templates/header.php';
?>    
<style>
  table{
    padding:3px;

  }
  td{
    width: 1%;
    padding:3px;
    border:1px solid grey;
    
    
  }
  thead td{
    background-color:  #012970;
    text-align: center;
    color:white;
  }
</style>
  <main id="main" class="main" style="background:white;">

<div class="pagetitle">
  <h1><?php echo $_SESSION['SESS_DEPARTMENT_NAME'] ?></h1><h6>Academic Year <?php echo $_SESSION['SESS_ACADEMIC_YEAR'] ?>
  </h6>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard" style="background:white;">
  <table>
    <thead>
      <tr>
        <td>Monday</td>
        <td>Tuesday</td>
        <td>Wednesday</td>
        <td>Thursday</td>
        <td>Friday</td>
      </tr>
    </thead>
  </table>
</section>

</main><!-- End #main -->

<?php include_once 'templates/footer.php' ?> 