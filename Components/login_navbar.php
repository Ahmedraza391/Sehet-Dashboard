<nav class="navbar navbar-expand-lg bg-light-own fixed-top">
  <div class="container-fluid px-md-5 py-2">
    <a class="navbar-brand" href="./admin_login.php">
        <img src="./assets/img/Sehet.pk-Logo-00.50924e11ffd6fed66494.png" alt="Sehet" width="60" height="48">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link mini-nav <?php if($file == 'admin_login'){echo 'active';} ?>" title="Admin Login" href="./admin_login.php">Admin Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mini-nav <?php if($file == 'emp_login'){echo 'active';} ?>" title="Employee Login" href="./user_login.php">Employee User Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
