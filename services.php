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
    $query = mysqli_query($connection, "SELECT * FROM tbl_users WHERE user_id ='$id'");
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
$changes = "";
if (isset($_SESSION['admin'])) {
    $changes = "Admin";
} else if (isset($_SESSION['employee_user'])) {
    $changes = $_SESSION['employee_user']['user_name'];
}
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
                        <h1 class="fs-3 fw-bold">Manage Services</h1>
                    </div>
                    <div class="services_table overflow_table mb-3">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th class="text-center">Id</th>
                                <th class="text-left">Manage Service</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Action</th>
                            </thead>
                            <tbody id="serviceTable">
                            </tbody>
                        </table>
                    </div>
                    <!-- View Modal -->
                    <div class="modal fade" id="view_manage_service_history" tabindex="-1" aria-labelledby="view_manage_service_historyLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="view_manage_service_historyLabel">Manage Service History</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card p-3">
                                        <!-- Table to display history data -->
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S#</th>
                                                    <th>Page Name</th>
                                                    <th>SPK User</th>
                                                    <th>Data Type</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($connection, "SELECT * FROM tbl_history WHERE page_name='manage_service' ORDER BY id DESC");
                                                $index = 1;
                                                if(mysqli_num_rows($query)>0){
                                                    foreach ($query as $history) {
                                                        echo "<tr>";
                                                        $page_name = "";
                                                        if ($history['page_name'] == "manage_service") {
                                                            $page_name = "Manage Service";
                                                        }
                                                        echo "<td>{$index}</td>";
                                                        echo "<td>{$page_name}</td>";
                                                        echo "<td>{$history['changes_person']}</td>";
                                                        $type = "";
                                                        if ($history['change_type'] == "add_manage_service") {
                                                            $type = "Manage Service Added";
                                                        } else if ($history['change_type'] == "edit_manage_service") {
                                                            $type = "Manage Service Edited";
                                                        } else if ($history['change_type'] == "available_manage_service") {
                                                            $type = "Manage Service Available";
                                                        } else if ($history['change_type'] == "unavailable_manage_service") {
                                                            $type = "Manage Service Unavailable";
                                                        } else if ($history['change_type'] == "enable_manage_service") {
                                                            $type = "Manage Service Enable";
                                                        } else if ($history['change_type'] == "disable_manage_service") {
                                                            $type = "Manage Service Disable";
                                                        }
                                                        echo "<td>{$type}</td>";
                                                        echo "<td>{$history['date']}</td>";
                                                        echo "<td>{$history['time']}</td>";
                                                        echo "</tr>";
                                                        $index++;
                                                    }
                                                }else{
                                                    echo "<tr><td colspan='6'>Manage Service Not Have Any History</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editServiceModalLabel">Edit Manage Service</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editserviceForm">
                                        <input type="hidden" id="edit_ServiceId">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="" id="edit_ServiceName" required>
                                            <label for="editServiceName">Manage Service</label>
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
                    <div class="row">
                        <div class="col-sm-12 mb-2 mb-sm-3 mb-md-0 col-md-4 d-md-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-primary btn-sm text-center" data-bs-toggle="modal" data-bs-target="#add_service">
                                Add Manage Services
                            </button>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-sm-12 mb-2 mb-sm-3 mb-md-0 col-md-4 d-md-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-success btn-sm text-center" data-bs-toggle="modal" data-bs-target="#view_manage_service_history">
                                View Service History
                            </button>
                        </div>
                    </div>
                    <!-- Add Service Modal -->
                    <div class="add_service_modal">
                        <div class="modal fade" id="add_service" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_serviceLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_serviceLabel">Add Manage Service</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="services_form">
                                            <form id="insert_service_form">
                                                <input type="hidden" value="<?php echo $changes; ?>" name="changes_person" id="changes_person">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="serivce" name="service" placeholder="" required>
                                                    <label for="serivce">Enter Manage Service</label>
                                                </div>
                                                <div class="button">
                                                    <button type="submit" name="btn_service" class="btn btn-primary">Add Manage Service</button>
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
                        <h1 class="fs-3 fw-bold">Services Main Head</h1>
                    </div>
                    <div class="services_table overflow_table mb-3">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th class="text-center">Id</th>
                                <th class="text-left">Services Main Head</th>
                                <th class="text-left">Price</th>
                                <th class="text-left">Manage Services</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Action</th>
                            </thead>
                            <tbody id="subServiceTable">
                            </tbody>
                        </table>
                    </div>
                    <!-- View Modal -->
                    <div class="modal fade" id="view_service_main_head_history" tabindex="-1" aria-labelledby="view_service_main_head_historyLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="view_service_main_head_historyLabel">Services Main Head History</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card p-3">
                                        <!-- Table to display history data -->
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S#</th>
                                                    <th>Page Name</th>
                                                    <th>SPK User</th>
                                                    <th>Data Type</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($connection, "SELECT * FROM tbl_history WHERE page_name='service_main_head' ORDER BY id DESC");
                                                $index = 1;
                                                if(mysqli_num_rows($query)>0){
                                                    foreach ($query as $history) {
                                                        echo "<tr>";
                                                        $page_name = "";
                                                        if ($history['page_name'] == "service_main_head") {
                                                            $page_name = "Service Main Head";
                                                        }
                                                        echo "<td>{$index}</td>";
                                                        echo "<td>{$page_name}</td>";
                                                        echo "<td>{$history['changes_person']}</td>";
                                                        $type = "";
                                                        if ($history['change_type'] == "add_service_main_head") {
                                                            $type = "Service Main Head Added";
                                                        } else if ($history['change_type'] == "edit_service_main_head") {
                                                            $type = "Service Main Head Edited";
                                                        } else if ($history['change_type'] == "available_service_main_head") {
                                                            $type = "Service Main Head Available";
                                                        } else if ($history['change_type'] == "unavailable_service_main_head") {
                                                            $type = "Service Main Head Unavailable";
                                                        } else if ($history['change_type'] == "enable_service_main_head") {
                                                            $type = "Service Sub Head Enable";
                                                        } else if ($history['change_type'] == "disable_service_main_head") {
                                                            $type = "Service Sub Head Disable";
                                                        }
                                                        echo "<td>{$type}</td>";
                                                        echo "<td>{$history['date']}</td>";
                                                        echo "<td>{$history['time']}</td>";
                                                        echo "</tr>";
                                                        $index++;
                                                    }
                                                }else{
                                                    echo "<tr><td colspan='6'>Service Main Head Not Have Any History</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editSubServicesModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Services-Main-Head</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editSubServices">
                                        <input type="hidden" id="edit_SubServiceId" name="sub_service_id">
                                        <div class="form-floating">
                                            <select class="form-select mb-3" id="edit_service_id" name="service_id" aria-label="Floating label select example" required>
                                            </select>
                                            <label for="edit_service_id">Manage Services</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="sub_service_name" id="edit_service_name" placeholder="" required>
                                            <label for="edit_ServiceName">Services Main Head</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" name="sub_service_price" id="edit_service_price" placeholder="" required>
                                            <label for="edit_service_price">Enter Services Main Head Price</label>
                                        </div>
                                        <input type="hidden" name="edit_service_main_changes_person" id="edit_service_main_changes_person" value="<?php echo $changes; ?>">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 mb-sm-3 mb-md-0 col-md-4 d-md-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-primary btn-sm text-center" data-bs-toggle="modal" data-bs-target="#add_sub_service">
                                Add Services Main Head
                            </button>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-sm-12 mb-2 mb-sm-3 mb-md-0 col-md-4 d-md-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-success btn-sm text-center" data-bs-toggle="modal" data-bs-target="#view_service_main_head_history">
                                View Services Main Head
                            </button>
                        </div>
                    </div>
                    <!-- Add Service Modal -->
                    <div class="add_sub_service_modal">
                        <div class="modal fade" id="add_sub_service" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_sub_serviceLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_sub_serviceLabel">Add Services Main Head</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="services_form">
                                            <form id="insert_sub_service_form">
                                                <div class="form-floating my-3">
                                                    <select class="form-select" id="service_id" name="service_id" aria-label="Floating label select example" required>
                                                        <option value="" hidden>Select Manage Service</option>
                                                        <?php
                                                        $fetch_service = mysqli_query($connection, "SELECT * FROM tbl_services WHERE disabled_status='enabled'");
                                                        foreach ($fetch_service as $service) {
                                                            echo "<option value='$service[id]'>$service[service]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="service_id">Manage Services</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="sub_service" name="sub_service" placeholder="" required>
                                                    <label for="sub_serivce">Enter Service Main Head</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="sub_service_price" name="sub_service_price" placeholder="" required>
                                                    <label for="sub_service_price">Enter Service Main Head Price</label>
                                                </div>
                                                <input type="hidden" name="service_main_changes_person" id="service_main_changes_person" value="<?php echo $changes; ?>">
                                                <div class="button">
                                                    <button type="submit" name="btn_service" class="btn btn-primary">Add Services-Main-Head</button>
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
                        <h1 class="fs-3 fw-bold">Services Sub Head</h1>
                    </div>
                    <div class="extra_services_table overflow_table mb-3">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th class="text-center">Id</th>
                                <th class="text-left">Services Sub Head</th>
                                <th class="text-left">Services Sub Head Prices</th>
                                <th class="text-left">Services Main Head</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Action</th>
                            </thead>
                            <tbody id="extraServiceTable">
                            </tbody>
                        </table>
                    </div>
                    <!-- View Modal -->
                    <div class="modal fade" id="view_service_sub_head_history" tabindex="-1" aria-labelledby="view_service_sub_head_historyLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="view_service_sub_head_historyLabel">Services Sub Head History</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card p-3">
                                        <!-- Table to display history data -->
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S#</th>
                                                    <th>Page Name</th>
                                                    <th>SPK User</th>
                                                    <th>Data Type</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($connection, "SELECT * FROM tbl_history WHERE page_name='service_sub_head' ORDER BY id DESC");
                                                $index = 1;
                                                if(mysqli_num_rows($query)>0){
                                                    foreach ($query as $history) {
                                                        echo "<tr>";
                                                        $page_name = "";
                                                        if ($history['page_name'] == "service_sub_head") {
                                                            $page_name = "Service Sub Head";
                                                        }
                                                        echo "<td>{$index}</td>";
                                                        echo "<td>{$page_name}</td>";
                                                        echo "<td>{$history['changes_person']}</td>";
                                                        $type = "";
                                                        if ($history['change_type'] == "add_service_sub_head") {
                                                            $type = "Service Sub Head Added";
                                                        } else if ($history['change_type'] == "edit_service_sub_head") {
                                                            $type = "Service Sub Head Edited";
                                                        } else if ($history['change_type'] == "available_service_sub_head") {
                                                            $type = "Service Sub Head Available";
                                                        } else if ($history['change_type'] == "unavailable_service_sub_head") {
                                                            $type = "Service Sub Head Unavailable";
                                                        } else if ($history['change_type'] == "enable_service_sub_head") {
                                                            $type = "Service Sub Head Enable";
                                                        } else if ($history['change_type'] == "disable_service_sub_head") {
                                                            $type = "Service Sub Head Disable";
                                                        }
                                                        echo "<td>{$type}</td>";
                                                        echo "<td>{$history['date']}</td>";
                                                        echo "<td>{$history['time']}</td>";
                                                        echo "</tr>";
                                                        $index++;
                                                    }
                                                }else{
                                                    echo "<tr><td colspan='6'>Service Sub Head Not Have Any History</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editextraServicesModal" tabindex="-1" aria-labelledby="editextraServicesModalLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editextraServicesModalLabel">Edit Service Sub Head</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editExtraServices">
                                        <input type="hidden" id="edit_extra_ServiceId" name="extra_service_id">
                                        <div class="form-floating">
                                            <select class="form-select mb-3" id="edit_sub_service_id" name="sub_service_id" aria-label="Floating label select example" required>
                                            </select>
                                            <label for="edit_sub_service_id">Services Main Head</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="extra_service_name" id="edit_extra_service_name" placeholder="" required>
                                            <label for="edit_extra_service_name">Service Sub Head</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" name="extra_service_price" id="edit_extra_service_price" placeholder="" required>
                                            <label for="edit_extra_service_price">Service Sub Head Price</label>
                                        </div>
                                        <input type="hidden" name="edit_service_sub_changes_person" id="edit_service_sub_changes_person" value="<?php echo $changes; ?>">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 mb-sm-3 mb-md-0 col-md-4 d-md-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-primary btn-sm text-center" data-bs-toggle="modal" data-bs-target="#add_extra_service">
                                Add Services Sub Head
                            </button>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-sm-12 mb-2 mb-sm-3 mb-md-0 col-md-4 d-md-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-success btn-sm text-center" data-bs-toggle="modal" data-bs-target="#view_service_sub_head_history">
                                View Services Sub Head
                            </button>
                        </div>
                    </div>
                    <!-- Add Extra-Service Modal -->
                    <div class="add_extra_service_modal">
                        <div class="modal fade" id="add_extra_service" tabindex="-1" aria-labelledby="add_extra_serviceLabel" aria-hidden="true" data-bs-backdrop="static">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_extra_serviceLabel">Add Service Sub Head</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="services_form">
                                            <form id="insert_extra_service_form">
                                                <div class="form-floating my-3">
                                                    <select class="form-select" id="sub_service_id" name="sub_service_id" aria-label="Floating label select example" required>
                                                        <option value="" hidden>Select Service Main Head</option>
                                                        <?php
                                                        $fetch_service = mysqli_query($connection, "SELECT * FROM tbl_sub_services WHERE disabled_status='enabled'");
                                                        foreach ($fetch_service as $sub_service) {
                                                            echo "<option value='$sub_service[id]'>$sub_service[sub_service]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="sub_service_id">Services Main Head</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="extra_service" name="extra_service" placeholder="" required>
                                                    <label for="sub_serivce">Service Sub Head</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="extra_service_price" name="extra_service_price" placeholder="" required>
                                                    <label for="extra_service_price">Service Sub Head Price</label>
                                                </div>
                                                <input type="hidden" name="service_sub_changes_person" id="service_sub_changes_person" value="<?php echo $changes; ?>">
                                                <div class="button">
                                                    <button type="submit" name="btn_service" class="btn btn-primary">Add Service Sub Head</button>
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