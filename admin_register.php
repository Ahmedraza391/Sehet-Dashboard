<?php include("connection.php") ?>
<?php include("./Components/top.php") ?>
<?php
$page = "register";
?>
<div class="container p-md-5">
  <div class="register_content">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="card mb-3">
            <div class="card-body">
              <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                <p class="text-center small">Enter your personal details to create account</p>
              </div>
  
              <form id="registerForm" class="row g-3 needs-validation" novalidate method="POST" enctype="multipart/form-data">
                <div class="col-12 mb-3">
                  <label for="yourName" class="form-label">Admin Name</label>
                  <input type="text" name="admin_name" class="form-control" id="yourName" required>
                  <div class="invalid-feedback">Please, enter your name!</div>
                  <div id="nameFeedback"></div>
                </div>
  
                <div class="col-12 mb-3">
                  <label for="username" class="form-label">Admin Username</label>
                  <input type="text" name="admin_username" class="form-control" id="username" required>
                  <div class="invalid-feedback">Please, enter Username!</div>
                  <div id="usernameFeedback"></div>
                </div>
  
                <div class="col-12 mb-3 password-wrapper">
                  <label for="password" class="form-label">Admin Password</label>
                  <input type="password" name="admin_password" class="form-control" id="password" required>
                  <i class="bi bi-eye-slash" id="togglePassword"></i>
                  <div class="invalid-feedback">Please your password!</div>
                  <div id="passwordFeedback"></div>
                </div>
  
                <div class="col-12">
                  <div class="mb-3">
                    <label for="formFile" class="form-label">Admin Image</label>
                    <input class="form-control" type="file" name="admin_image" id="formFile" required>
                    <div id="imageFeedback"></div>
                  </div>
                </div>
  
                <div class="col-12 mb-3">
                  <button class="btn btn-primary w-100" name="btn-register" type="submit">Create Account</button>
                </div>
                <div class="col-12">
                  <p class="small mb-0">Already have an account? <a href="admin_login.php">Log in</a></p>
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