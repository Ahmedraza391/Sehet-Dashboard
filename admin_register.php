<?php include("connection.php") ?>
<?php include("./Components/top.php") ?>
<?php 
    $page = "register";
?>
<?php include("./Components/navbar.php") ?>
<?php include("./Components/sidebar.php") ?>

<div class="main" id="main">
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Services</li>
            </ol>
        </nav>
    </div>
    <div class="register_content container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                  <?php 
                    if(isset($_POST['btn-register'])){
                      // Fetch form data
                      $name = $_POST['name'];
                      $email = $_POST['email'];
                      $username = $_POST['username'];
                      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                      // Perform database insert operation
                      $query = "INSERT INTO users (name, email, username, password) VALUES ('$name', '$email', '$username', '$password')";
                      if (mysqli_query($connection, $query)) {
                          echo "<div class='alert alert-success'>Account created successfully!</div>";
                      } else {
                          echo "<div class='alert alert-danger'>Error: " . mysqli_error($connection) . "</div>";
                      }
                    }
                  ?>

                  <form class="row g-3 needs-validation" novalidate method="POST" action="">
                    <div class="col-12">
                      <label for="yourName" class="form-label">Your Name</label>
                      <input type="text" name="name" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please enter a valid Email address!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please choose a username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control passwords" id="password" required>
                      <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                      <!-- continue on seet password icon and register wala kam dekhna ha  -  -->
                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="btn-register" type="submit">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="pages-login.html">Log in</a></p>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
<?php include("./Components/bottom.php") ?>

<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    var passwordInput = document.getElementById('password');
    var passwordIcon = this;
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('bi-eye-slash');
        passwordIcon.classList.add('bi-eye');
    } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('bi-eye');
        passwordIcon.classList.add('bi-eye-slash');
    }
});
</script>
