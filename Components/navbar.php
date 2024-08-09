<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="index.php" class="logo d-flex align-items-center">
      <img src="./assets/img/Sehet.pk-Logo-00.50924e11ffd6fed66494.png" alt="">
      <span class="d-none d-lg-block">Sehet Panel</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <li class="nav-item mx-2 d-md-block d-none">
        <i class="ri-nurse-line"></i> 
        <a href="patient_management.php" class="fs-6 mini-nav <?php if($page == "patients"){echo "active";} ?>">Patients</a>
      </li>

      <li class="nav-item mx-2 d-md-block d-none"><i class="ri-exchange-dollar-line"></i>
        <a href="transaction_management.php" class="fs-6 mini-nav <?php if($page == "transaction"){echo "active";} ?>">Transaction</a>
      </li>

      <li class="nav-item dropdown ms-md-3">

        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-bell"></i>
          <span class="badge bg-primary badge-number">4</span>
        </a><!-- End Notification Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          <li class="dropdown-header">
            You have 4 new notifications
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-exclamation-circle text-warning"></i>
            <div>
              <h4>Lorem Ipsum</h4>
              <p>Quae dolorem earum veritatis oditseno</p>
              <p>30 min. ago</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-x-circle text-danger"></i>
            <div>
              <h4>Atque rerum nesciunt</h4>
              <p>Quae dolorem earum veritatis oditseno</p>
              <p>1 hr. ago</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-check-circle text-success"></i>
            <div>
              <h4>Sit rerum fuga</h4>
              <p>Quae dolorem earum veritatis oditseno</p>
              <p>2 hrs. ago</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-info-circle text-primary"></i>
            <div>
              <h4>Dicta reprehenderit</h4>
              <p>Quae dolorem earum veritatis oditseno</p>
              <p>4 hrs. ago</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>
          <li class="dropdown-footer">
            <a href="#">Show all notifications</a>
          </li>

        </ul><!-- End Notification Dropdown Items -->

      </li><!-- End Notification Nav -->

      <li class="nav-item dropdown pe-3">
        <?php
        if (isset($_SESSION['admin'])) {
          $image = $_SESSION['admin']['admin_image'];
          echo "<a class='nav-link nav-profile d-flex align-items-center pe-0' href='#' data-bs-toggle='dropdown'>
                <img src='$image' alt='Profile' class='rounded-circle'>
                <span class='d-none d-md-block dropdown-toggle ps-2'></span>
              </a>";
        }
        if (isset($_SESSION['employee_user'])) {
          echo "<a class='nav-link nav-profile d-flex align-items-center pe-0' href='#' data-bs-toggle='dropdown'>
                <i class='ri-user-3-line fs-4 rounded'></i>
                <span class='d-none d-md-block dropdown-toggle ps-2'></span>
              </a>";
        }
        ?>
        <!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <?php
          $anchor = '';
          if (isset($_SESSION['admin'])) {
            $anchor = "admin_profile.php";
          }
          if (isset($_SESSION['employee_user'])) {
            $anchor = "user_profile.php";
          }
          ?>
          <li>
            <a class="dropdown-item d-flex align-items-center d-md-none" href="./patient_management.php">
            <i class="ri-nurse-line"></i> 
              <span>Patients</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center d-md-none" href="./transaction_management.php"><i class="ri-exchange-dollar-line"></i>
              <span>Transactions</span>
            </a>
          </li>
          <hr class="m-0 d-md-none">
          <li>
            <a class="dropdown-item d-flex align-items-center" href="<?php echo $anchor; ?>">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="logout.php">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>

        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header><!-- End Header -->