<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>window.location.href='admin_login.php'</script>";
}
?>
<?php include("connection.php") ?>
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
                        <?php
                        $fetch_image_query = mysqli_query($connection, "SELECT * FROM tbl_admin WHERE id = $_SESSION[admin]");
                        if (mysqli_num_rows($fetch_image_query) > 0) {
                            $fetch_data = mysqli_fetch_assoc($fetch_image_query);
                        }
                        ?>
                        <img src="<?php echo $fetch_data['admin_image']; ?>" alt="Profile" class="rounded-circle">
                        <h2><?php echo $fetch_data['admin_name']; ?></h2>
                        <!-- <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div> -->
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
                                    <div class="col-lg-9 col-md-8"><?php echo $fetch_data['admin_name']; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Username</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $fetch_data['admin_username']; ?></div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-lg-3 col-md-4 label">Password</div>
                                    <div class="col-lg-9 col-md-8 password-wrapper">
                                        <input type="password" disabled value="<?php echo $_SESSION['original_password']; ?>" class="form-control password">
                                        <i class="bi bi-eye-slash togglePassword"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <!-- Profile Edit Form -->
                                <form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                        <div class="col-md-8 col-lg-9 d-flex align-items-center">
                                            <img src="<?php echo $fetch_data['admin_image']; ?>" alt="Profile">
                                            <div class="ms-md-5">
                                                <div class="mb-3">
                                                    <label for="formFileMultiple" class="form-label">Upload Image</label>
                                                    <input class="form-control" type="file" name="image" required id="formFileMultiple" multiple>
                                                </div>
                                                <div class="button">
                                                    <button class="btn btn-primary btn-sm" name="btn-image-update">Update Image</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <?php
                                if (isset($_POST['btn-image-update'])) {
                                    // Handle file upload
                                    $image = $_FILES['image'];
                                    $imageName = $_FILES['image']['name'];
                                    $imageTmpName = $_FILES['image']['tmp_name'];
                                    $imageSize = $_FILES['image']['size'];
                                    $imageError = $_FILES['image']['error'];
                                    $imageType = $_FILES['image']['type'];

                                    // Allow certain file formats
                                    $allowed = array('jpg', 'jpeg', 'png', 'gif');
                                    $imageExt = explode('.', $imageName);
                                    $imageActualExt = strtolower(end($imageExt));

                                    if (in_array($imageActualExt, $allowed)) {
                                        if ($imageError === 0) {
                                            if ($imageSize < 5000000) { // 1MB max file size
                                                $imageNameNew = uniqid('', true) . "." . $imageActualExt;
                                                $imageDestination = './assets/img/admin/' . $imageNameNew;

                                                // Move the uploaded file to the server
                                                if (move_uploaded_file($imageTmpName, $imageDestination)) {
                                                    // Insert image info into database
                                                    $sql = "UPDATE tbl_admin SET admin_image ='$imageDestination' WHERE id = $_SESSION[admin]";
                                                    if ($connection->query($sql) === TRUE) {
                                                        echo "<p class='text-success'>Image uploaded successfully!</p>";
                                                    } else {
                                                        echo "<p class='text-danger'>Error: " . $sql . "<br>" . $connection->error . "</p>";
                                                    }
                                                } else {
                                                    echo "<p class='text-danger'>There was an error uploading your file.</p>";
                                                }
                                            } else {
                                                echo "<p class='text-danger'>Your file is too big!</p>";
                                            }
                                        } else {
                                            echo "<p class='text-danger'>There was an error uploading your file!</p>";
                                        }
                                    } else {
                                        echo "<p class='text-danger'>You cannot upload files of this type!</p>";
                                    }

                                    $connection->close();
                                }
                                ?>
                                <form method="post" class="needs-validation" novalidate>
                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" id="fullName" value="<?php echo $fetch_data['admin_name']; ?>" name="admin_name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="company" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" id="company" value="<?php echo $fetch_data['admin_username']; ?>" name="admin_username">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="company" class="col-md-4 col-lg-3 col-form-label">Password</label>
                                        <div class="col-md-8 col-lg-9 mb-3 password-wrapper">
                                            <input type="password" value="<?php echo $_SESSION['original_password']; ?>" class="form-control password" required name="admin_password">
                                            <i class="bi bi-eye-slash togglePassword"></i>
                                            <div class="invalid-feedback">Please, Enter password!</div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="btn_update_data" class="btn btn-primary btn-sm">Update Profile</button>
                                    </div>
                                </form>
                                <?php 
                                    // update profile
                                    if(isset($_POST['btn_update_data'])){
                                        $name = $_POST['admin_name'];
                                        $username = $_POST['admin_username'];
                                        $password = $_POST['admin_password'];
                                        
                                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                                        $update_data_query = "UPDATE tbl_admin SET admin_name='$name',admin_username='$username',admin_password='$password' WHERE id = $_SESSION[admin]";
                                        $run_update_query = mysqli_query($connection,$update_data_query);
                                        if($run_update_query){
                                            $_SESSION['original_password'] = $password;
                                            // setcookie('cook_username', $username, time() + (86400 * 30));
                                            setcookie('cook_password', $hashed_password, time() + (86400 * 30));
                                            echo "<script>alert('Profile Updated Successfully');window.location.href = 'admin_profile.php'</script>";
                                        }else{
                                            echo "<script>alert('Error in Profile Updating');window.location.href = 'admin_profile.php'</script>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

</main>
<?php include("./Components/bottom.php") ?>