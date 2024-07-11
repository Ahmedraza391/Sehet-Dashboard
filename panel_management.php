<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>window.location.href='admin_login.php'</script>";
}
?>
<?php include("connection.php") ?>
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
                <div class="card p-md-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">Panels</h1>
                    </div>
                    <div class="panel_table overflow_table">
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
                    <!-- View Modal -->
                    <div class="modal fade" id="viewpanel" tabindex="-1" aria-labelledby="viewpanelLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="viewpanelLabel">Panel</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card p-md-3">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <h6 class="">ID : #<span class="fs-6" id="panel_id"></span></h6>
                                        </div>
                                        <div class="company">
                                            <h6>Company : <span class="fs-6" id="panel_company"></span></h6>
                                        </div>
                                        <div class="email">
                                            <h6>Email : <span class="fs-6" id="panel_email"></span></h6>
                                        </div>
                                        <div class="manager">
                                            <h6>Manager : <span class="fs-6" id="panel_manager"></span></h6>
                                        </div>
                                        <div class="c_contact">
                                            <h6>Company Contact : <span class="fs-6" id="panel_company_contact"></span></h6>
                                        </div>
                                        <div class="contact">
                                            <h6>Contact : <span class="fs-6" id="panel_contact"></span></h6>
                                        </div>
                                        <div class="province">
                                            <h6>Province : <span class="fs-6" id="panel_province"></span></h6>
                                        </div>
                                        <div class="city">
                                            <h6>City : <span class="fs-6" id="panel_city"></span></h6>
                                        </div>
                                        <div class="area">
                                            <h6>Area : <span class="fs-6" id="panel_area"></span></h6>
                                        </div>
                                        <div class="Status">
                                            <h6>Status : <span class="fs-6" id="panel_status"></span></h6>
                                        </div>
                                        <div class="services">
                                            <h6>Services : <span class="fs-6" id="panel_services"></span></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
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
                                            <input type="text" class="form-control" id="edit_panel_comapny" name="edit_panel_comapny" placeholder="Enter Company" required>
                                            <label for="edit_panel_comapny">Enter Company</label>
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
                                            <input type="text" class="form-control" id="edit_panel_contact" name="edit_panel_contact_num" placeholder="Enter Focal Person Contact #" required pattern="^03\d{9}$" title="Contact number must start with 03 and be 11 digits long.">
                                            <label for="edit_panel_contact">Enter Focal Person Contact #</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_panel_manager_contact" name="edit_panel_manager_contact_num" placeholder="Enter Manager Contact #" required pattern="^03\d{9}$" title="Contact number must start with 03 and be 11 digits long.">
                                            <label for="edit_panel_manager_contact">Enter Manager Contact #</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_province" name="edit_province" required aria-label="Select Province">
                                                <option selected value="" hidden>Select Province</option>
                                            </select>
                                            <label for="edit_province">Province</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_city_id" name="edit_city" required aria-label="Select City">
                                            </select>
                                            <label for="edit_city_id">City</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_area_id" name="edit_area" required aria-label="Select Area">
                                            </select>
                                            <label for="edit_area_id">Area</label>
                                        </div>
                                        <div class="mb-3" id="edit_services">
                                           
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
                                            <form id="panel_form">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="panel_comapny" name="panel_comapny" placeholder="" required>
                                                    <label for="panel_comapny">Enter Company</label>
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
                                                    <input type="text" class="form-control" id="panel_contact" name="panel_contact_num" placeholder="" required pattern="^03\d{9}$" title="Contact number must start with 03 and be 11 digits long.">
                                                    <label for="panel_contact">Enter Focal Person Contact #</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="panel_manager_contact" name="panel_manager_contact_num" placeholder="" required pattern="^03\d{9}$" title="Contact number must start with 03 and be 11 digits long.">
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
                                                    <div class="border p-3 rounded" id="mainservices">
                                                        <label for="mainservices" class="form-label">Select Services</label>
                                                        <?php
                                                        $query = "SELECT * FROM tbl_sub_services WHERE status = 'available'";
                                                        $run_query = mysqli_query($connection, $query);
                                                        foreach ($run_query as $services) {
                                                            echo "<div class='form-check'>";
                                                            echo "<input class='form-check-input' type='checkbox' name='services[]' value='$services[id]' id='$services[id]'>";
                                                            echo "<label class='form-check-label' for='$services[id]'>$services[sub_service]</label>";
                                                            echo "</div>";
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





<!-- Continue on edit panels -->