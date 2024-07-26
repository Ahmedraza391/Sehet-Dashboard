<?php
session_start();
include("connection.php");
if ((isset($_SESSION['employee_user'])) || (isset($_SESSION['admin']))) {
    // User is either employee_user or admin, continue with the script
} else {
    // Redirect to admin login page if no session is found
    echo "<script>window.location.href='admin_login.php'</script>";
    exit();
}

$this_page = "service_management";

if (isset($_SESSION['employee_user'])) {
    $id = $_SESSION['employee_user']['user_id'];
    $query = mysqli_query($connection,"SELECT * FROM tbl_users WHERE user_id ='$id'");
    $fetch_qurey = mysqli_fetch_assoc($query);
    $pages = explode(",", $fetch_qurey['pages_access']);    

    if (in_array($this_page, $pages)) {
        // User has permission to access this page, continue with the script
    } else {
        // Alert the user and redirect if they don't have permission
        echo "<script>alert('You don\'t have permission to access this page.'); window.location.href='index.php';</script>";
        exit();
    }
}
?>
<?php include("./Components/top.php") ?>
<?php
$page = "services";
?>
<title>Admin - Services</title>
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
    <div class="services_content">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card p-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">Services</h1>
                    </div>
                    <div class="services_table overflow_table mb-3">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th class="text-center">Id</th>
                                <th class="text-left">Service</th>
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
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card p-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">Sub Services</h1>
                    </div>
                    <div class="services_table overflow_table mb-3">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th class="text-center">Id</th>
                                <th class="text-left">Sub Service</th>
                                <th class="text-left">Price</th>
                                <th class="text-left">Service</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </thead>
                            <tbody id="subServiceTable">
                            </tbody>
                        </table>
                    </div>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editSubServicesModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Sub-Service</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editSubServices">
                                        <input type="hidden" id="edit_SubServiceId" name="sub_service_id">
                                        <div class="form-floating">
                                            <select class="form-select mb-3" id="edit_service_id" name="service_id" aria-label="Floating label select example" required>
                                            </select>
                                            <label for="edit_service_id">Services</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="sub_service_name" id="edit_service_name" placeholder="" required>
                                            <label for="edit_ServiceName">Sub-Service</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" name="sub_service_price" id="edit_service_price" placeholder="" required>
                                            <label for="edit_service_price">Sub-Service Price</label>
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
                    <div class="add_sub_service_modal">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_sub_service">
                            Add Sub-Services
                        </button>
                        <div class="modal fade" id="add_sub_service" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_sub_serviceLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_sub_serviceLabel">Add Sub-Service</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="services_form">
                                            <form id="insert_sub_service_form">
                                                <div class="form-floating my-3">
                                                    <select class="form-select" id="service_id" name="service_id" aria-label="Floating label select example" required>
                                                        <option value="" hidden>Select Service</option>
                                                        <?php
                                                        $fetch_service = mysqli_query($connection, "SELECT * FROM tbl_services");
                                                        foreach ($fetch_service as $service) {
                                                            echo "<option value='$service[id]'>$service[service]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="sub_services">Select Service</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="sub_service" name="sub_service" placeholder="" required>
                                                    <label for="sub_serivce">Enter Sub-Service</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="sub_service_price" name="sub_service_price" placeholder="" required>
                                                    <label for="sub_service_price">Sub-Service Price</label>
                                                </div>
                                                <div class="button">
                                                    <button type="submit" name="btn_service" class="btn btn-primary">Add Sub-Service</button>
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
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card p-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">Extra Services</h1>
                    </div>
                    <div class="extra_services_table overflow_table mb-3">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th class="text-center">Id</th>
                                <th class="text-left">Extra Service</th>
                                <th class="text-left">Extra Service Price</th>
                                <th class="text-left">Sub Service</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </thead>
                            <tbody id="extraServiceTable">
                            </tbody>
                        </table>
                    </div>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editextraServicesModal" tabindex="-1" aria-labelledby="editextraServicesModalLabel" aria-hidden="true"  data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editextraServicesModalLabel">Edit Extra-Service</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editExtraServices">
                                        <input type="hidden" id="edit_extra_ServiceId" name="extra_service_id">
                                        <div class="form-floating">
                                            <select class="form-select mb-3" id="edit_sub_service_id" name="sub_service_id" aria-label="Floating label select example" required>
                                            </select>
                                            <label for="edit_sub_service_id">Sub Services</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="extra_service_name" id="edit_extra_service_name" placeholder="" required>
                                            <label for="edit_extra_service_name">Extra-Service</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" name="extra_service_price" id="edit_extra_service_price" placeholder="" required>
                                            <label for="edit_extra_service_price">Extra-Service Price</label>
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
                    <!-- Add Extra-Service Modal -->
                    <div class="add_extra_service_modal">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_extra_service">
                            Add Extra-Services
                        </button>
                        <div class="modal fade" id="add_extra_service" tabindex="-1" aria-labelledby="add_extra_serviceLabel" aria-hidden="true" data-bs-backdrop="static">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_extra_serviceLabel">Add Extra-Service</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="services_form">
                                            <form id="insert_extra_service_form">
                                                <div class="form-floating my-3">
                                                    <select class="form-select" id="sub_service_id" name="sub_service_id" aria-label="Floating label select example" required>
                                                        <option value="" hidden>Select Sub-Service</option>
                                                        <?php
                                                        $fetch_service = mysqli_query($connection, "SELECT * FROM tbl_sub_services");
                                                        foreach ($fetch_service as $sub_service) {
                                                            echo "<option value='$sub_service[id]'>$sub_service[sub_service]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="sub_service_id">Sub-Service</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="extra_service" name="extra_service" placeholder="" required>
                                                    <label for="sub_serivce">Enter Extra-Service</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="extra_service_price" name="extra_service_price" placeholder="" required>
                                                    <label for="extra_service_price">Enter Extra-Service Price</label>
                                                </div>
                                                <div class="button">
                                                    <button type="submit" name="btn_service" class="btn btn-primary">Add Extra-Service</button>
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