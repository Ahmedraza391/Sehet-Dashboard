<?php
ob_start();
session_start();
include("connection.php");
include("./Components/top.php");
?>
<title>Employee User - Login</title>
<?php
$file = "emp_login";
include("./Components/login_navbar.php");
?>
<div class="container p-md-5 top_header_margin_div">
    <div class="login_content">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card mb-3 p-md-3">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                            <p class="text-center small">Enter your username & password to login</p>
                        </div>
                        <form class="row g-3 needs-validation" novalidate method="POST">
                            <div class="col-12">
                                <label for="user_email" class="form-label">Email</label>
                                <div class="input-group has-validation">
                                    <input type="email" name="txtemail" value="<?php if (isset($_COOKIE['emp_user_email'])) {
                                                                                        echo htmlspecialchars($_COOKIE['emp_user_email']);
                                                                                    } ?>" class="form-control" id="user_email" required>
                                    <div class="invalid-feedback">Please enter your Email!</div>
                                </div>
                            </div>
                            <?php
                            $value = "";
                            if (isset($_COOKIE['emp_user_password'])) {
                                $value = $_COOKIE['emp_user_password'];
                            }
                            ?>
                            <div class="col-12 mb-3 password-wrapper">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="txtpassword" value="<?php echo htmlspecialchars($value); ?>" class="form-control password" required>
                                <i class="bi bi-eye-slash togglePassword" style="transform: translateY(0%)!important;"></i>
                                <div class="invalid-feedback">Please, Enter password!</div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMe"<?php
                                                                                                                        if (
                                                                                                                            isset($_COOKIE['emp_user_email']) && $_COOKIE['emp_user_email'] !== '' &&
                                                                                                                            isset($_COOKIE['emp_user_password']) && $_COOKIE['emp_user_password'] !== ''
                                                                                                                        ) {
                                                                                                                            echo 'checked';
                                                                                                                        }
                                                                                                                        ?>>
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" name="btn-login" type="submit">Login</button>
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['btn-login'])) {
                            $user_email = $_POST['txtemail'];
                            $password = $_POST['txtpassword'];

                            // Fetch user data from database
                            $check_user_have = mysqli_query($connection, "SELECT * FROM tbl_users WHERE user_email='$user_email'");
                            $count = mysqli_num_rows($check_user_have);

                            if ($count > 0) {
                                $fetch_user = mysqli_fetch_assoc($check_user_have);
                                $stored_password = $fetch_user['user_password'];
                                if ($password == $stored_password) {
                                    $_SESSION['employee_user'] = $fetch_user;

                                    if (isset($_POST['remember_me'])) {
                                        setcookie('emp_user_email', $user_email, time() + (86400 * 30), "/", "", true, true);
                                        setcookie('emp_user_password', $stored_password, time() + (86400 * 30), "/", "", true, true);
                                    } else {
                                        setcookie('emp_user_email', "", time() - 3600, "/", "", true, true); // Secure flag and HttpOnly flag
                                        setcookie('emp_user_password', "", time() - 3600, "/", "", true, true); // Secure flag and HttpOnly flag
                                    }

                                    echo "<script>alert('Employee User Login Successfully');window.location.href='index.php'</script>";
                                } else {
                                    echo "<script>alert('Incorrect Email Or Password');window.location.href = 'user_login.php';</script>";
                                }
                            } else {
                                echo "<script>alert('Incorrect Email Or Password');window.location.href = 'user_login.php';</script>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
<?php include("./Components/bottom.php");
ob_end_flush(); ?>