<?php
session_start();
include("connection.php");
if ((isset($_SESSION['employee_user'])) || (isset($_SESSION['admin']))) {
} else {
    echo "<script>window.location.href='admin_login.php'</script>";
    exit();
}

$this_page = "patient_management";

if (isset($_SESSION['employee_user'])) {
    $id = $_SESSION['employee_user']['user_id'];
    $query = mysqli_query($connection,"SELECT * FROM tbl_employee_users WHERE user_id ='$id'");
    $fetch_qurey = mysqli_fetch_assoc($query);
    $pages = explode(",", $fetch_qurey['pages_access']);    

    if (in_array($this_page, $pages)) {
    } else {
        echo "<script>alert('You don\'t have permission to access this page.'); window.location.href='index.php';</script>";
        exit();
    }
}
?>
<?php include("./Components/top.php") ?>
<?php
$page = "patients";
?>
<title>Admin - Patients</title>
<?php include("./Components/navbar.php") ?>
<?php include("./Components/sidebar.php") ?>
<div class="main" id="main">
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Patients</li>
            </ol>
        </nav>
    </div>
    <div class="patients_content">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card p-md-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">Patients</h1>
                    </div>
                    <div class="services_table overflow_table">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th class="text-center">MR #</th>
                                <th class="text-left">Patients</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </thead>
                            <tbody id="serviceTable">
                            </tbody>
                        </table>
                    </div>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editserviceForm">
                                        <input type="hidden" id="edit_ServiceId">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="" id="edit_ServiceName" required>
                                            <label for="editServiceName" >Service</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add Service Modal -->
                    <div class="add_service_modal">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_service">
                            Add Services
                        </button>
                        <div class="modal fade" id="add_service" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_serviceLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_serviceLabel">Add Service</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="services_form">
                                            <form id="insert_service_form">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="serivce" name="service" placeholder="" required>
                                                    <label for="serivce">Enter Service</label>
                                                </div>
                                                <div class="button">
                                                    <button type="submit" name="btn_service" class="btn btn-primary">Add Service</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<?php include("./Components/bottom.php") ?>



<!-- Continue on patient management -->

