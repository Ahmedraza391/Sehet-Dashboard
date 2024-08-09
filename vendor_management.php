<?php
session_start();
include("connection.php");
if ((isset($_SESSION['employee_user'])) || (isset($_SESSION['admin']))) {
} else {
    echo "<script>window.location.href='admin_login.php'</script>";
}
$this_page = "vendor_management";

if (isset($_SESSION['employee_user'])) {
    $id = $_SESSION['employee_user']['user_id'];
    $query = mysqli_query($connection, "SELECT * FROM tbl_users WHERE user_id ='$id'");
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
$page = "vendor";
$changes = "";
if (isset($_SESSION['admin'])) {
    $changes = "Admin";
} else if (isset($_SESSION['employee_user'])) {
    $changes = $_SESSION['employee_user']['user_name'];
}
?>
<title>Admin - Vendor Management</title>
<?php include("./Components/navbar.php") ?>
<?php include("./Components/sidebar.php") ?>
<div class="main" id="main">
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Vendor-Management</li>
            </ol>
        </nav>
    </div>
    <div class="vendor_content">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card p-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">Vendors</h1>
                    </div>
                    <div class="vendor_table overflow_table mb-3">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th class="text-center">Vendor Id</th>
                                <th class="text-left">Vendor Name</th>
                                <th class="text-center">Vendor N-T-N</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Action</th>
                            </thead>
                            <tbody id="vendorTable">
                            </tbody>
                        </table>
                    </div>
                    <!-- View Vendor Modal -->
                    <div class="modal fade" id="viewVendor" tabindex="-1" aria-labelledby="viewVendorLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewVendorLabel">View Vendor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Vendor ID:</strong> <span id="view_vendor_id"></span></p>
                                            <p><strong>Vendor Name:</strong> <span id="view_vendor_name"></span></p>
                                            <p><strong>Vendor N-T-N:</strong> <span id="view_vendor_ntn"></span></p>
                                            <p><strong>Focal Person:</strong> <span id="view_vendor_f_person"></span></p>
                                            <p><strong>Vendor Contact:</strong> <span id="view_vendor_contact"></span></p>
                                            <p><strong>Vendor Whatsapp:</strong> <span id="view_vendor_w_contact"></span></p>
                                            <p><strong>Vendor Address:</strong> <span id="view_vendor_address"></span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Status:</strong> <span id="view_vendor_status"></span></p>
                                            <p><strong>Province:</strong> <span id="view_vendor_province"></span></p>
                                            <p><strong>City:</strong> <span id="view_vendor_city"></span></p>
                                            <p><strong>Area:</strong> <span id="view_vendor_area"></span></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Services</h5>
                                            <div id="view_vendor_services"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- View History Modal -->
                    <div class="modal fade" id="view_vendor_history" tabindex="-1" aria-labelledby="view_vendor_historyLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="view_vendor_historyLabel">Panel History</h3>
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
                                                $query = mysqli_query($connection, "SELECT * FROM tbl_history WHERE page_name='vendors' ORDER BY id DESC");
                                                $index = 1;
                                                if (mysqli_num_rows($query) > 0) {
                                                    foreach ($query as $history) {
                                                        echo "<tr>";
                                                        $page_name = "";
                                                        if ($history['page_name'] == "vendors") {
                                                            $page_name = "Vendor";
                                                        }
                                                        echo "<td>{$index}</td>";
                                                        echo "<td>{$page_name}</td>";
                                                        echo "<td>{$history['changes_person']}</td>";
                                                        $type = "";
                                                        if ($history['change_type'] == "add_vendors") {
                                                            $type = "Vendor Added";
                                                        } else if ($history['change_type'] == "edit_vendors") {
                                                            $type = "Vendor Edited";
                                                        } else if ($history['change_type'] == "available_vendors") {
                                                            $type = "Vendor Available";
                                                        } else if ($history['change_type'] == "unavailable_vendors") {
                                                            $type = "Vendor Unavailable";
                                                        } else if ($history['change_type'] == "enable_vendors") {
                                                            $type = "Vendor Enable";
                                                        } else if ($history['change_type'] == "disable_vendors") {
                                                            $type = "Vendor Disable";
                                                        } else if ($history['change_type'] == "activate_vendors") {
                                                            $type = "Vendor Activate";
                                                        } else if ($history['change_type'] == "deactivate_vendors") {
                                                            $type = "Vendor Deactivate";
                                                        }
                                                        echo "<td>{$type}</td>";
                                                        echo "<td>{$history['date']}</td>";
                                                        echo "<td>{$history['time']}</td>";
                                                        echo "</tr>";
                                                        $index++;
                                                    }
                                                } else {
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
                    <div class="modal fade" id="editVendor" tabindex="-1" aria-labelledby="editVendorLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editVendorLabel">Edit Vendor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit_vendor_form" method="POST">
                                        <input type="hidden" name="edit_vendor_id" id="edit_vendor_id">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_vendor_name" name="edit_vendor_name" placeholder="" required>
                                            <label for="edit_vendor_name">Vendor Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_vendor_ntn" name="edit_vendor_ntn" placeholder="" required>
                                            <label for="edit_vendor_ntn">Vendor N-T-N</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_focal_person" name="edit_focal_person" placeholder="" required>
                                            <label for="edit_focal_person">Vendor Focal Person</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control no-spinner" id="edit_vendor_contact" name="edit_vendor_contact_num" placeholder="" required>
                                            <label for="edit_vendor_contact">Vendor Contact #</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control no-spinner" id="edit_vendor_w_contact" name="edit_vendor_w_contact_num" placeholder="" required>
                                            <label for="edit_vendor_w_contact">Vendor Whatsapp #</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" placeholder="Vendor Address" id="edit_vendor_address" name="edit_vendor_address"></textarea>
                                            <label for="edit_vendor_address">Vendor Address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_vendor_province" name="edit_vendor_province" required aria-label="Floating label select example">
                                                <option selected value="" hidden>Select Province</option>
                                            </select>
                                            <label for="edit_vendor_province">Provinces</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_vendor_city" name="edit_vendor_city" required aria-label="Floating label select example">
                                                <option selected value="" hidden>Select City</option>
                                            </select>
                                            <label for="edit_vendor_city">Cities</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_vendor_area" name="edit_vendor_area" required aria-label="Floating label select example">
                                                <option selected value="" hidden>Select Area</option>
                                            </select>
                                            <label for="edit_vendor_area">Areas</label>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <div class="border p-3 rounded overflow-y-auto" style="height: 400px !important;" id="edit_services_container">
                                                    <!-- Services and extra services will be dynamically populated here -->
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="edit_vendor_changes_person" id="edit_vendor_changes_person" value="<?php echo $changes; ?>">
                                        <div class="button">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 mb-sm-3 mb-md-0 col-md-4 d-md-flex align-items-center justify-content-start">
                            <button type="button" class="btn btn-primary btn-sm text-center" data-bs-toggle="modal" data-bs-target="#vendor_modal">
                                Add Vendors
                            </button>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-sm-12 mb-2 mb-sm-3 mb-md-0 col-md-4 d-md-flex align-items-center justify-content-end">
                            <button type="button" class="btn btn-success btn-sm text-center" data-bs-toggle="modal" data-bs-target="#view_vendor_history">
                                View Vendors History
                            </button>
                        </div>
                    </div>
                    <!-- Add Vendor Modal -->
                    <div class="vendor_modal">
                        <div class="modal fade" id="vendor_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="vendor_modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="vendor_modalLabel">Add Vendor</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="vendor_form">
                                            <form id="vendor_form" method="POST">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="vendor_name" name="vendor_name" placeholder="" required>
                                                    <label for="vendor_name">Vendor Name</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="vendor_ntn" name="vendor_ntn" placeholder="" required>
                                                    <label for="vendor_ntn">Vendor N-T-N</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="focal_person" name="focal_person" placeholder="" required>
                                                    <label for="focal_person">Vendor Focal Person</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control no-spinner" id="vendor_contact" name="vendor_contact_num" placeholder="" required>
                                                    <label for="vendor_contact">Vendor Contact #</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control no-spinner" id="vendor_w_contact" name="vendor_w_contact_num" placeholder="" required>
                                                    <label for="vendor_w_contact">Vendor Whatsapp #</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control" placeholder="Vendor Address" id="vendor_address" name="vendor_address"></textarea>
                                                    <label for="vendor_address">Vendor Address</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="vendor_province" name="vendor_province" required aria-label="Floating label select example">
                                                        <option selected value="" hidden>Select Province</option>
                                                        <?php
                                                        $query = mysqli_query($connection, "SELECT * FROM tbl_province WHERE disabled_status='enabled'");
                                                        foreach ($query as $province) {
                                                            echo "<option value='{$province['id']}'>{$province['province']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="vendor_province">Province</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="vendor_city" name="vendor_city" required aria-label="Floating label select example">
                                                        <option selected value="" hidden>Select City</option>
                                                    </select>
                                                    <label for="vendor_city">Cities</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="vendor_area" name="vendor_area" required aria-label="Floating label select example">
                                                        <option selected value="" hidden>Select Area</option>
                                                    </select>
                                                    <label for="vendor_area">Areas</label>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="border p-3 rounded overflow-y-auto" style="height: 400px !important;" id="vendor_services">
                                                        <label for="vendor_services" class="form-label">Select Services</label>
                                                        <?php
                                                        $query = "SELECT * FROM tbl_sub_services WHERE status = 'available' AND disabled_status ='enabled'";
                                                        $run_query = mysqli_query($connection, $query);
                                                        foreach ($run_query as $services) {
                                                            echo "<div class='form-check'>";
                                                            echo "<input class='form-check-input' type='checkbox' name='services[]' value='{$services['id']}' id='{$services['id']}'>";
                                                            echo "<label class='form-check-label' for='{$services['id']}'>{$services['sub_service']}-------{$services['sub_service_price']}</label>";
                                                            echo "<input type='tel' class='form-control no-spinner' name='service_prices[{$services['id']}]' placeholder='Enter Price'>";
                                                            echo "</div>";

                                                            $extra_services_query = "SELECT * FROM tbl_extra_services WHERE sub_services_id = {$services['id']}";
                                                            $extra_services_result = mysqli_query($connection, $extra_services_query);

                                                            if (mysqli_num_rows($extra_services_result) > 0) {
                                                                echo "<div class='form-group' style='margin-left: 20px;'>";
                                                                echo "<label for='extra_services_{$services['id']}'>Choose extra services:</label>";
                                                                while ($extra_service = mysqli_fetch_assoc($extra_services_result)) {
                                                                    echo "<div class='form-check'>";
                                                                    echo "<input class='form-check-input' type='checkbox' name='extra_services[{$services['id']}][]' value='{$extra_service['id']}' id='extra_service_{$extra_service['id']}'>";
                                                                    echo "<label class='form-check-label' for='extra_service_{$extra_service['id']}'>{$extra_service['extra_service']}-------{$extra_service['extra_service_price']}</label>";
                                                                    echo "<input type='tel' class='form-control no-spinner' name='extra_service_prices[{$services['id']}][{$extra_service['id']}]' placeholder='Enter Price'>";
                                                                    echo "</div>";
                                                                }
                                                                echo "</div>";
                                                                echo "<hr>";
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="add_vendor_changes_person" id="add_vendor_changes_person" value="<?php echo $changes; ?>">
                                                <div class="button">
                                                    <button type="submit" class="btn btn-primary">Add</button>
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