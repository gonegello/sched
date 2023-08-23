<?php 
$uri = $_SERVER['REQUEST_URI'];
require ($_SERVER['DOCUMENT_ROOT'] . '/models/Menu.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/models/Sub_menu.php');

$menu       = new Menu();
$sub_menu   = new Sub_menu();

$resMenu = $menu->getWhere('', 'sort ASC');
$menu_list = [];
foreach($resMenu AS $row) {
    $resSubMenu = $sub_menu->getWhere(" AND menu_id = " . $row['id'], "name ASC");
    $menu_list[] = [
        'id'    => $row['id'],
        'name'  => $row['name'],
        'url'   => $row['url'],
        'icon'  => $row['icon'],
        'active_keyword'  => $row['active_keyword'],
        'sub_menu' => $resSubMenu
    ];
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>SchedulingSystem</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>

        <!-- Favicons -->
        <link href="<?php echo BASE_URL ?>/assets/img/favicon.png" rel="icon">
        <link href="<?php echo BASE_URL ?>/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="<?php echo BASE_URL ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo BASE_URL ?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="<?php echo BASE_URL ?>/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="<?php echo BASE_URL ?>/assets/vendor/quill/quill.snow.css" rel="stylesheet">
        <link href="<?php echo BASE_URL ?>/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
        <link href="<?php echo BASE_URL ?>/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
        <!-- <link href="<?php echo BASE_URL ?>/assets/vendor/simple-datatables/style.css" rel="stylesheet"> -->
        <link href="<?php echo BASE_URL ?>/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/parsley.css">

        <!-- Select 2 -->
        <link href="<?php echo BASE_URL ?>/assets/vendor/select2/css/select2.min.css" rel="stylesheet">
        <!-- Template Main CSS File -->
        <link href="<?php echo BASE_URL ?>/assets/css/style.css" rel="stylesheet">
        <!-- Datepicker -->
        <!-- <link href="<?php echo BASE_URL ?>/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"> -->
        
        <script src="<?php echo BASE_URL ?>/assets/js/jquery.min.js"></script>
        
        <!-- =======================================================
        * Template Name: NiceAdmin - v2.4.1
        * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
    </head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Scheduling System</span>
      </a>
      <!-- <i class="bi bi-list toggle-sidebar-btn"></i> -->
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->        
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?php echo BASE_URL ?>/assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['SESS_FIRST_NAME'] . ' ' . $_SESSION['SESS_LAST_NAME'] ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $_SESSION['SESS_FIRST_NAME'] . ' ' . $_SESSION['SESS_LAST_NAME'] ?></h6>
              <span><?php echo $_SESSION['SESS_DEPARTMENT_NAME'] ?><br><?php echo $_SESSION['SESS_USER_ROLE_NAME'] ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo BASE_URL . '/views/account-settings' ?>">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo BASE_URL ?>/log-out.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <?php foreach($menu_list AS $row): 

            $checkmenu = $helpers->checkactivemenu($uri, $row['active_keyword']);
            $active = ($checkmenu) ? '' : 'collapsed';
            $areaexpanded = ($checkmenu) ? 'true' : 'false';
            $navcontentshow = ($checkmenu) ? 'show' : '';
        ?>
            <?php if(empty($row['sub_menu'])): ?>
                <li class="nav-item ">
                    <a class="nav-link <?php echo $active ?>" href="<?php echo BASE_URL . '/' . $row['url'] ?>">
                        <i class="<?php echo $row['icon'] ?>"></i>
                        <span><?php echo $row['name'] ?></span>
                    </a>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $active ?>" data-bs-target="#forms-nav<?php echo $row['id'] ?>" 
                  
                    data-bs-toggle="collapse" href="#" aria-expanded="<?php echo $areaexpanded ?>">
                        <i class="<?php echo $row['icon'] ?>"></i>
                            <span><?php echo $row['name'] ?></span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="forms-nav<?php echo $row['id'] ?>" class="nav-content collapse <?php echo $navcontentshow ?>" data-bs-parent="#sidebar-nav">
                        <?php foreach($row['sub_menu'] AS $rows): 
                            $checkmenu = $helpers->checkactivemenu($uri, $rows['active_keyword']); 
                            $active = ($checkmenu) ? 'active' : '';   
                        ?>
                        <li>
                            <a href="<?php echo BASE_URL . '/' . $rows['url'] ?>" class="<?php echo $active ?>"
                           
                            >
                                <i class="<?php echo $rows['icon'] ?>"></i><span><?php echo $rows['name'] ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

  </aside><!-- End Sidebar-->
