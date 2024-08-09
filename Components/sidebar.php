
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link <?php if($page=="home"){echo "active";} ?> text-primary" href="index.php">
          <i class="bi bi-grid text-primary"></i>
          <span>Dashboard</span>
        </a>
      </li>
    
      <li class="nav-item">
        <a class="nav-link <?php if($page=="services"){echo "active";} ?> text-primary" href="./services.php">
          <i class="ri-customer-service-line text-primary"></i>
          <span>Services</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php if($page=="address"){echo "active";} ?> text-primary" href="./address_management.php">
          <i class='bx bxs-buildings text-primary'></i>
          <span>Addresses</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php if($page=="reffrals"){echo "active";} ?> text-primary" href="./refferals_management.php">
          <i class='bx bxs-add-to-queue text-primary'></i> 
          <span>Referrals</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php if($page=="panels"){echo "active";} ?> text-primary" href="./panel_management.php">
          <i class='bx bx-buildings text-primary'></i>
          <span>Panels</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php if($page=="emp_register"){echo "active";} ?> text-primary" href="./employee_management.php">
        <i class="ri-group-2-line text-primary"></i>
          <span>Employees</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php if($page=="emp_user_register"){echo "active";} ?> text-primary" href="./user_management.php">
        <i class="ri-account-circle-fill"></i>
          <span>Users</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link <?php if($page=="vendor"){echo "active";} ?> text-primary" href="./vendor_management.php">
        <i class="ri-flask-fill"></i>
          <span>Vendor</span>
        </a>
      </li>
    </ul>

  </aside><!-- End Sidebar-->