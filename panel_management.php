<?php
session_start();
include("connection.php");
if ((isset($_SESSION['employee_user'])) || (isset($_SESSION['admin'])) ) {

}else{
  echo "<script>window.location.href='admin_login.php'</script>";
}
$this_page = "panel_management";

if (isset($_SESSION['employee_user'])) {
    $id = $_SESSION['employee_user']['user_id'];
    $query = mysqli_query($connection,"SELECT * FROM tbl_users WHERE user_id ='$id'");
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
$page = "panels";
?>
<title>Admin - Panel Management</title>
<?php include("./Components/navbar.php") ?>
<?php include("./Components/sidebar.php") ?>
<div class="main" id="main">
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Panel-Management</li>
            </ol>
        </nav>
    </div>
    <div class="panel_content">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card p-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">Panels</h1>
                    </div>
                    <div class="panel_table overflow_table mb-3">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th class="text-center">Id</th>
                                <th class="text-left">Company</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </thead>
                            <tbody id="panelTable">
                            </tbody>
                        </table>
                    </div>
                    <!-- View Panel Modal -->
                    <div class="modal fade" id="viewpanel" tabindex="-1" aria-labelledby="viewPanelLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewPanelLabel">View Panel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Panel ID:</strong> <span id="view_panel_id"></span></p>
                                            <p><strong>Company:</strong> <span id="view_panel_company"></span></p>
                                            <p><strong>Email:</strong> <span id="view_panel_email"></span></p>
                                            <p><strong>Focal Person:</strong> <span id="view_panel_manager"></span></p>
                                            <p><strong>Company Contact:</strong> <span id="view_panel_company_contact"></span></p>
                                            <p><strong>Focal Person Contact:</strong> <span id="view_panel_contact"></span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Status:</strong> <span id="view_panel_status"></span></p>
                                            <p><strong>Province:</strong> <span id="view_panel_province"></span></p>
                                            <p><strong>City:</strong> <span id="view_panel_city"></span></p>
                                            <p><strong>Area:</strong> <span id="view_panel_area"></span></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Services</h5>
                                            <div id="view_panel_services"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editPanel" tabindex="-1" aria-labelledby="editPanelLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPanelLabel">Edit Panel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit_panel_form">
                                        <input type="hidden" id="edit_panel_id" name="edit_panel_id">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_panel_company" name="edit_panel_company" placeholder="Enter Company" required>
                                            <label for="edit_panel_company">Enter Company</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_panel_manager" name="edit_panel_manager" placeholder="Enter Focal Person" required>
                                            <label for="edit_panel_manager">Enter Focal Person</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="edit_panel_email" name="edit_panel_email" placeholder="Enter Email" required>
                                            <label for="edit_panel_email">Enter Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control no-spinner" id="edit_panel_contact" name="edit_panel_contact_num" placeholder="Enter Focal Person Contact #" required>
                                            <label for="edit_panel_contact">Enter Focal Person Contact #</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control no-spinner" id="edit_panel_manager_contact" name="edit_panel_manager_contact_num" placeholder="Enter Manager Contact #" required>
                                            <label for="edit_panel_manager_contact">Enter Manager Contact #</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_province" name="edit_panel_province" required aria-label="Select Province">
                                                <option selected value="" hidden>Select Province</option>
                                            </select>
                                            <label for="edit_province">Province</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_city_id" name="edit_panel_city" required aria-label="Select City">
                                            </select>
                                            <label for="edit_city_id">City</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_area_id" name="edit_panel_area" required aria-label="Select Area">
                                            </select>
                                            <label for="edit_area_id">Area</label>
                                        </div>
                                        <div id="edit_services_container">
                                            <!-- Services checkboxes will be dynamically populated here -->
                                        </div>
                                        <div id="edit_extra_services_container">
                                            <!-- Extra Services checkboxes will be dynamically populated here -->
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="btn_update">Save changes</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Panel Modal -->
                    <div class="panel_modal">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#panel_modal">
                            Add Panels
                        </button>
                        <div class="modal fade" id="panel_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="panel_modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="panel_modalLabel">Add Panel</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="panel_form">
                                            <form id="panel_form" method="POST" action="insert_panel.php">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="panel_company" name="panel_company" placeholder="" required>
                                                    <label for="panel_company">Enter Company</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="panel_manager" name="panel_manager" placeholder="" required>
                                                    <label for="panel_manager">Enter Focal Person</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" id="panel_email" name="panel_email" placeholder="" required>
                                                    <label for="panel_email">Enter Email</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control no-spinner" id="panel_contact" name="panel_contact_num" placeholder="" required>
                                                    <label for="panel_contact">Enter Focal Person Contact #</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control no-spinner" id="panel_manager_contact" name="panel_manager_contact_num" placeholder="" required>
                                                    <label for="panel_manager_contact">Enter Manager Contact #</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="province" name="province" required aria-label="Floating label select example">
                                                        <option selected value="" hidden>Select Province</option>
                                                        <?php
                                                        $query = mysqli_query($connection, "SELECT * FROM tbl_province");
                                                        foreach ($query as $province) {
                                                            echo "<option value='{$province['id']}'>{$province['province']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="province">Province</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="city_id" name="city" required aria-label="Floating label select example">
                                                        <option selected value="" hidden>Select City</option>
                                                    </select>
                                                    <label for="city">Cities</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="area_id" name="area_id" required aria-label="Floating label select example">
                                                        <option selected value="" hidden>Select Area</option>
                                                    </select>
                                                    <label for="area_id">Areas</label>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="border p-3 rounded overflow-y-auto" style="height: 400px !important;" id="mainservices">
                                                        <label for="mainservices" class="form-label">Select Services</label>
                                                        <?php
                                                        $query = "SELECT * FROM tbl_sub_services WHERE status = 'available'";
                                                        $run_query = mysqli_query($connection, $query);

                                                        foreach ($run_query as $services) {
                                                            echo "<div class='form-check'>";
                                                            echo "<input class='form-check-input' type='checkbox' name='services[]' value='{$services['id']}' id='{$services['id']}'>";
                                                            echo "<label class='form-check-label' for='{$services['id']}'>{$services['sub_service']}</label>";
                                                            echo "<input type='number' class='form-control' name='service_prices[{$services['id']}]' placeholder='Enter Price'>";
                                                            echo "</div>";

                                                            $extra_services_query = "SELECT * FROM tbl_extra_services WHERE sub_services_id = {$services['id']}";
                                                            $extra_services_result = mysqli_query($connection, $extra_services_query);

                                                            if (mysqli_num_rows($extra_services_result) > 0) {
                                                                echo "<div class='form-group' style='margin-left: 20px;'>";
                                                                echo "<label for='extra_services_{$services['id']}'>Choose extra services:</label>";
                                                                while ($extra_service = mysqli_fetch_assoc($extra_services_result)) {
                                                                    echo "<div class='form-check'>";
                                                                    echo "<input class='form-check-input' type='checkbox' name='extra_services[{$services['id']}][]' value='{$extra_service['id']}' id='extra_service_{$extra_service['id']}'>";
                                                                    echo "<label class='form-check-label' for='extra_service_{$extra_service['id']}'>{$extra_service['extra_service']}</label>";
                                                                    echo "<input type='number' class='form-control' name='extra_service_prices[{$services['id']}][{$extra_service['id']}]' placeholder='Enter Price'>";
                                                                    echo "</div>";
                                                                }
                                                                echo "</div>";
                                                                echo "<hr>";
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="button">
                                                    <button type="submit" name="btn_reffrals" value="add_reffrals" class="btn btn-primary">Add</button>
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