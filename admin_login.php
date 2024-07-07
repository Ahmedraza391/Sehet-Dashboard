<?php ob_start();
session_start(); ?>
<?php include("connection.php") ?>
<?php include("./Components/top.php") ?>
<title>Admin - Login</title>
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
                        
                        <form class="row g-3 needs-validation" novalidate method="POST">

                            <div class="col-12">
                                <label for="yourUsername" class="form-label">Username</label>
                                <div class="input-group has-validation">
                                    <input type="text" name="txtusername" value="<?php if (isset($_COOKIE['cook_username'])) {echo $_COOKIE['cook_username'];} ?>" class="form-control" id="yourUsername" required value="">
                                    <div class="invalid-feedback">Please enter your username.</div>
                                </div>
                            </div>
                            <?php
                                $value = "";
                                if(isset($_SESSION['original_password'])){
                                    if (isset($_COOKIE['cook_password'])) 
                                    {
                                        if(password_verify($_SESSION['original_password'],$_COOKIE['cook_password'])){
                                            $value = $_SESSION['original_password'];
                                        }
                                        $value =  $_SESSION['original_password'];
                                    }else{
                                        $value =  $_SESSION['original_password'];
                                    }
                                }
                            ?>
                            <div class="col-12 mb-3 password-wrapper">
                                <label for="password" class="form-label">Admin Password</label>
                                <input type="password" name="txtpassword" value="<?php echo $value; ?>" class="form-control password" id="" required value="">
                                <i class="bi bi-eye-slash togglePassword" id=""></i>
                                <div class="invalid-feedback">Please, Enter password!</div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <?php 
                                        if(isset($_COOKIE['cook_username'])){
                                            echo "<input class='form-check-input' type='checkbox' checked name='remember_me' id='rememberMe'>";
                                        }else{
                                            echo "<input class='form-check-input' type='checkbox' name='remember_me' id='rememberMe'>";
                                        }
                                    ?>
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
                        <?php
                        if(isset($_POST['btn-login'])){
                            $username = $_POST['txtusername'];
                            $password = $_POST['txtpassword'];
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $check_user_have = mysqli_query($connection,"SELECT * FROM tbl_admin WHERE admin_username='$username' AND admin_password = '$password'");
                            $count = mysqli_num_rows($check_user_have);
                            if($count>0){
                                $fetch_user = mysqli_fetch_assoc($check_user_have);
                                $id = $fetch_user['id'];
                                $_SESSION['admin']=$id;
                                $_SESSION['original_password']=$password;
                                if(isset($_POST['remember_me'])){
                                    setcookie('cook_username', $username, time() + (86400 * 30));
                                    setcookie('cook_password', $hashed_password, time() + (86400 * 30));
                                } else {
                                    setcookie('cook_username', "", time() - 3600, "/");
                                    setcookie('cook_password', "", time() - 3600, "/");
                                }
                                echo "<script>alert('Admin Login Successfully');window.location.href = 'index.php';</script>";
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