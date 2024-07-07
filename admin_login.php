<?php ob_start();
session_start(); ?>
<?php include("connection.php") ?>
<?php include("./Components/top.php") ?>
<?php
$page = "login";
?>
<div class="container p-md-5">
    <div class="login_content">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card mb-3">

                    <div class="card-body">

                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                            <p class="text-center small">Enter your username & password to login</p>
                        </div>
                        <?php
                        if (isset($_POST['btn-login'])) {

                            // Capture username and password from form
                            $username = $_POST['txtusername'];
                            $password = $_POST['txtpassword'];
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            // Prepare and execute query
                            $stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE admin_username = ?");
                            $stmt->bind_param("s", $username);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $fetch = $result->fetch_assoc();
                                // Verify password
                                if (password_verify($password, $fetch['admin_password'])) {
                                    $_SESSION['admin'] = $fetch['id'];
                                    $_SESSION['original_password'] = $password;
                                    // Handle remember me
                                    if (isset($_POST['remember_me'])) {
                                        setcookie('cook_username', $username, time() + (86400 * 30));
                                        setcookie('cook_password', $hashed_password, time() + (86400 * 30));
                                    } else {
                                        setcookie('cook_username', "", time() - 3600, "/");
                                        setcookie('cook_password', "", time() - 3600, "/");
                                    }

                                    echo "<script>alert('Admin Login Successfully');";
                                } else {
                                    echo "<script>alert('Invalid Username Or Password');</script>";
                                }
                            } else {
                                echo "<script>alert('Invalid Username Or Password');</script>";
                            }

                            // Close statement and connection
                            $stmt->close();
                            $connection->close();
                        }
                        ?>
                        <form class="row g-3 needs-validation" novalidate method="POST">

                            <div class="col-12">
                                <label for="yourUsername" class="form-label">Username</label>
                                <div class="input-group has-validation">
                                    <input type="text" name="txtusername" value="<?php if (isset($_COOKIE['cook_username'])) {echo $_COOKIE['cook_username'];} ?>" class="form-control" id="yourUsername" required value="">
                                    <div class="invalid-feedback">Please enter your username.</div>
                                </div>
                            </div>

                            <div class="col-12 mb-3 password-wrapper">
                                <label for="password" class="form-label">Admin Password</label>
                                <input type="password" name="txtpassword" value="<?php if (isset($_COOKIE['cook_password'])) {echo $_SESSION['original_password'];} ?>" class="form-control" id="password" required value="">
                                <i class="bi bi-eye-slash" id="togglePassword"></i>
                                <div class="invalid-feedback">Please, Enter password!</div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" name="btn-login" type="submit">Login</button>
                            </div>
                            <div class="col-12">
                                <p class="small mb-0">Don't have account? <a href="admin_register.php">Create an account</a></p>
                            </div>
                        </form>



                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
<?php include("./Components/bottom.php");
ob_end_flush(); ?>

<!-- Continue on login page -->