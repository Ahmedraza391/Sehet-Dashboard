<?php
session_start();
if (!isset($_SESSION['employee_user'])) {
    echo "<script>window.location.href='admin_login.php'</script>";
}
include("connection.php");
if (isset($_SESSION['employee_user'])) {
    $id = $_SESSION['employee_user']['user_id'];
}
$fetch_image_query = mysqli_query($connection, "SELECT * FROM tbl_users WHERE user_id = '$id'");
if (mysqli_num_rows($fetch_image_query) > 0) {
    $fetch_data = mysqli_fetch_assoc($fetch_image_query);
}
if (isset($_POST['btn_update_data'])) {
    // Retrieve form data and sanitize input
    $name = mysqli_real_escape_string($connection, $_POST['user_name']);
    $f_name = mysqli_real_escape_string($connection, $_POST['user_f_name']);
    $email = mysqli_real_escape_string($connection, $_POST['user_email']);
    $password = mysqli_real_escape_string($connection, $_POST['user_password']);
    $contact = mysqli_real_escape_string($connection, $_POST['user_contact']);
    $dob = mysqli_real_escape_string($connection, $_POST['user_dob']);
    $id = mysqli_real_escape_string($connection, $fetch_data['user_id']);

    // Update query
    $update_data_query = "UPDATE tbl_users SET user_name='$name', user_father_name='$f_name', user_email='$email', user_password='$password', user_contact='$contact', user_dob='$dob' WHERE user_id='$id'";
    $run_update_query = mysqli_query($connection, $update_data_query);

    // Remove old cookies
    setcookie('emp_user_email', "", time() - 3600, "/");
    setcookie('emp_user_password', "", time() - 3600, "/");

    if ($run_update_query) {
        // Set new cookies after removing old ones
        setcookie('emp_user_email', $email, time() + (86400 * 30), "/");
        setcookie('emp_user_password', $password, time() + (86400 * 30), "/");

        // Use JavaScript to redirect and display a message
        echo "<script>
        alert('Profile Updated Successfully');
        window.location.href = 'user_profile.php';
    </script>";
    } else {
        // Use JavaScript to redirect and display a message
        echo "<script>
        alert('Error in Profile Updating');
        window.location.href = 'user_profile.php';
    </script>";
    }
}
?>
<?php include("./Components/top.php") ?>
<title>Admin - Profile</title>
<?php include("./Components/navbar.php") ?>
<?php include("./Components/sidebar.php") ?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <i class="ri-user-3-line fs-1 rounded-circle border p-3"></i>
                        <h2><?php echo $fetch_data['user_name']; ?></h2>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <div class="row mt-3">
                                    <div class="col-lg-3 col-md-4 label">Full Name</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $fetch_data['user_name']; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Father Name</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $fetch_data['user_father_name']; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Username</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $fetch_data['user_email']; ?></div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-lg-3 col-md-4 label">Password</div>
                                    <div class="col-lg-9 col-md-8 password-wrapper">
                                        <input type="password" disabled value="<?php echo $fetch_data['user_password']; ?>" class="form-control password">
                                        <i class="bi bi-eye-slash togglePassword"></i>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Contact #</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $fetch_data['user_contact']; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Date of Birth</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $fetch_data['user_dob']; ?></div>
                                </div>
                            </div>
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <form method="post" class="needs-validation" novalidate>
                                    <div class="row mb-3">
                                        <label for="user_name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" id="user_name" value="<?php echo $fetch_data['user_name']; ?>" name="user_name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="f_name" class="col-md-4 col-lg-3 col-form-label">Father Name</label>
                                        <div class="col-md-8 col-lg-9 mb-3 password-wrapper">
                                            <input type="text" value="<?php echo $fetch_data['user_father_name']; ?>" id="f_name" class="form-control" required name="user_f_name">
                                            <div class="invalid-feedback">Please, Enter Father Name!</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="user_email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="email" class="form-control" id="user_email" value="<?php echo $fetch_data['user_email']; ?>" name="user_email">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="user_password" class="col-md-4 col-lg-3 col-form-label">Password</label>
                                        <div class="col-md-8 col-lg-9 mb-3 password-wrapper">
                                            <input type="password" value="<?php echo $fetch_data['user_password']; ?>" id="user_password" class="form-control password" required name="user_password">
                                            <i class="bi bi-eye-slash togglePassword"></i>
                                            <div class="invalid-feedback">Please, Enter password!</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="contact_no" class="col-md-4 col-lg-3 col-form-label">Contact #</label>
                                        <div class="col-md-8 col-lg-9 mb-3 password-wrapper">
                                            <input type="number" value="<?php echo $fetch_data['user_contact']; ?>" id="contact_no" class="form-control" required name="user_contact">
                                            <div class="invalid-feedback">Please, Enter Contact #.</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="dob" class="col-md-4 col-lg-3 col-form-label">Date of Birth</label>
                                        <div class="col-md-8 col-lg-9 mb-3 password-wrapper">
                                            <input type="date" value="<?php echo $fetch_data['user_dob']; ?>" id="dob" class="form-control" required name="user_dob">
                                            <div class="invalid-feedback">Please, Enter Dob!</div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="btn_update_data" class="btn btn-primary btn-sm">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<?php include("./Components/bottom.php") ?>