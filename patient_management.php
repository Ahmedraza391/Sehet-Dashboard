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
    $query = mysqli_query($connection, "SELECT * FROM tbl_employee_users WHERE user_id ='$id'");
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
                                <th class="text-center">Contact #</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </thead>
                            <tbody id="patientTable">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="viewPatient" tabindex="-1" aria-labelledby="viewPatientLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewPatientLabel">View Patient </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Registration Date:</strong> <span id="view_patient_registration_date"></span></p>
                                            <p><strong>MR No:</strong> <span id="view_patient_mr_no"></span></p>
                                            <p><strong>Patient Name:</strong> <span id="view_patient_name"></span></p>
                                            <p><strong>Attendant Name:</strong> <span id="view_patient_attendent_name"></span></p>
                                            <p><strong>Patient Email:</strong> <span id="view_patient_email"></span></p>
                                            <p><strong>Patient Contact:</strong> <span id="view_patient_contact"></span></p>
                                            <p><strong>WhatsApp:</strong> <span id="view_patient_whatsapp"></span></p>
                                            <p><strong>Patient Age:</strong> <span id="view_patient_age"></span></p>
                                            <p><strong>Patient Gender:</strong> <span id="view_patient_gender"></span></p>
                                            <p><strong>Patient Admit Date:</strong> <span id="view_patient_ad_date"></span></p>
                                            <p><strong>Patient Discharge Date:</strong> <span id="view_patient_dis_date"></span></p>
                                            <p><strong>Patient Total Days:</strong> <span id="view_patient_total_days"></span></p>
                                            <p><strong>Patient Status:</strong> <span id="view_patient_status"></span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Province:</strong> <span id="view_patient_province"></span></p>
                                            <p><strong>City:</strong> <span id="view_patient_city"></span></p>
                                            <p><strong>Area:</strong> <span id="view_patient_area"></span></p>
                                            <p><strong>Referred By:</strong> <span id="view_patient_refferal_id"></span></p>
                                            <p><strong>Panel:</strong> <span id="view_patient_panel_id"></span></p>
                                            <p><strong>Staff Name:</strong> <span id="view_patient_employee_id"></span></p>
                                            <p><strong>Patient Service:</strong> <span id="view_patient_service_id"></span></p>
                                            <p><strong>Payment Status:</strong> <span id="view_patient_payment_status"></span></p>
                                            <p><strong>Patient Rate:</strong> <span id="view_patient_patient_rate"></span></p>
                                            <p><strong>Staff Rate:</strong> <span id="view_patient_staff_rate"></span></p>
                                            <p><strong>Recovery:</strong> <span id="view_patient_recovery"></span></p>
                                            <p><strong>Running Bill:</strong> <span id="view_patient_running_bill"></span></p>
                                            <p><strong>Changes Person:</strong> <span id="view_patient_changes_person"></span></p>
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
                    <div class="modal fade" id="edit_patient" tabindex="-1" aria-labelledby="edit_patientLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="edit_patientLabel">Edit Patient</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit_patient_form">
                                        <?php
                                        $changes = "";
                                        if (isset($_SESSION['admin'])) {
                                            $changes = "Admin";
                                        }
                                        if (isset($_SESSION['employee_user'])) {
                                            $changes = $_SESSION['employee_user']['user_name'];
                                        }
                                        ?>
                                        <!-- Form Fields Here -->
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" value="<?php echo $changes; ?>" disabled placeholder="">
                                            <input type="hidden" value="<?php echo $changes; ?>" id="edit_changes_person" name="edit_changes_person">
                                            <label for="edit_changes_person">Changes Person</label>
                                        </div>
                                        <input type="hidden" name="edit_patient_id" id="edit_patient_id">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_patient_name" name="edit_patient_name" placeholder="" required>
                                            <label for="edit_patient_name">Patient Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_attendent_name" name="edit_attendent_name" placeholder="" required>
                                            <label for="edit_attendent_name">Attendent Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_patient_email" name="edit_patient_email" placeholder="" required>
                                            <label for="edit_patient_email">Patient Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_patient_contact" name="edit_patient_contact" placeholder="" required>
                                            <label for="edit_patient_contact">Patient Contact #</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_patient_whatsapp" name="edit_patient_whatsapp" placeholder="" required>
                                            <label for="edit_patient_whatsapp">Patient Whatsapp #</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" name="edit_patient_address" placeholder="" id="edit_patient_address"></textarea>
                                            <label for="edit_patient_address">Patient Address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control no-spinner" id="edit_patient_age" name="edit_patient_age" placeholder="" required>
                                            <label for="edit_patient_age">Patient Age</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_patient_gender" name="edit_patient_gender" required>
                                                <option selected value="" hidden>Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            <label for="edit_patient_gender">Gender</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_patient_status" name="edit_patient_status">
                                                <option selected value="" hidden>Patient Status</option>
                                                <option value="Admitted">Admitted</option>
                                                <option value="Discharged">Discharge</option>
                                            </select>
                                            <label for="edit_patient_status">Patient Status</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" id="edit_patient_admit_date" name="edit_patient_admit_date" placeholder="" required>
                                            <label for="edit_patient_admit_date">Admit Date</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" id="edit_patient_discharge_date" name="edit_patient_discharge_date" placeholder="">
                                            <label for="edit_patient_discharge_date">Discharge Date</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_patient_province" name="edit_patient_province" required>
                                                <option selected value="" hidden>Select Province</option>
                                            </select>
                                            <label for="edit_patient_province">Province</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_patient_city" name="edit_patient_city" required>
                                                <option selected value="" hidden>Select City</option>
                                            </select>
                                            <label for="edit_patient_city">Cities</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_patient_area" name="edit_patient_area" required>
                                                <option selected value="" hidden>Select Area</option>
                                            </select>
                                            <label for="edit_patient_area">Areas</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_patient_refferal" name="edit_patient_refferal" required>
                                                <option selected value="" hidden>Select Refferal</option>
                                            </select>
                                            <label for="edit_patient_refferal">Refferals</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_patient_panel" name="edit_patient_panel" required>
                                                <option selected value="" hidden>Select Panel</option>
                                            </select>
                                            <label for="edit_patient_panel">Panels</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_employee_staff" name="edit_employee_staff" required>
                                                <option selected value="" hidden>Select Staff</option>
                                            </select>
                                            <label for="edit_employee_staff">Staff</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_patient_service" name="edit_patient_service" required>
                                                <option selected value="" hidden>Select Service</option>
                                            </select>
                                            <label for="edit_patient_service">Service</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_payment_status" name="edit_payment_status" required>
                                                <option value="" hidden>Payment Status</option>
                                                <option value="r_from_patient">Recovery From Patient</option>
                                                <option value="r_from_panel">Recovery From Panel</option>
                                                <option value="zakat_donation">Zakat Donations</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <label for="edit_payment_status">Payment Status</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_patient_rate" name="edit_patient_rate" placeholder="" required>
                                            <label for="edit_patient_rate">Patient Rate</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_staff_rate" name="edit_staff_rate" placeholder="" required>
                                            <label for="edit_staff_rate">Staff Rate</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_recovery" name="edit_recovery" placeholder="">
                                            <label for="edit_recovery">Recovery</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_running_bill" name="edit_running_bill" placeholder="">
                                            <label for="edit_running_bill">Running Bill</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" name="edit_note" placeholder="" id="edit_note"></textarea>
                                            <label for="edit_note">Note Something</label>
                                        </div>
                                        <div class="button">
                                            <button type="submit" name="btn_update_patient" class="btn btn-primary">Update Patient</button>
                                        </div>
                                    </form>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add Service Modal -->
                    <div class="add_patient_modal">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_patient">
                            Add Patients
                        </button>
                        <div class="modal fade" id="add_patient" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_patientLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_patientLabel">Patient Registration</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="patient_form">
                                            <form id="insert_patient_form">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" value="<?php echo $changes; ?>" disabled placeholder="">
                                                    <input type="hidden" value="<?php echo $changes; ?>" id="changes_person" name="changes_person">
                                                    <label for="changes_person">Changes Person</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="" required>
                                                    <label for="patient_name">Patient Name</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="attendent_name" name="attendent_name" placeholder="" required>
                                                    <label for="attendent_name">Attendent Name</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="patient_email" name="patient_email" placeholder="" required>
                                                    <label for="patient_email">Patient Email</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="patient_contact" name="patient_contact" placeholder="" required>
                                                    <label for="patient_contact">Patient Contact #</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="patient_whatsapp" name="patient_whatsapp" placeholder="" required>
                                                    <label for="patient_whatsapp">Patient Whatsapp #</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control" name="patient_address" placeholder="" id="patient_address"></textarea>
                                                    <label for="patient_address">Patient Address</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control no-spinner" id="patient_age" name="patient_age" placeholder="" required>
                                                    <label for="patient_age">Patient Age</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="patient_gender" name="patient_gender" required>
                                                        <option selected value="" hidden>Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="male">Female</option>
                                                    </select>
                                                    <label for="patient_gender">Gender</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="patient_status" name="patient_status">
                                                        <option selected value="" hidden>Patient Status</option>
                                                        <option value="Admitted">Admitted</option>
                                                        <option value="Discharge">Discharge</option>
                                                    </select>
                                                    <label for="patient_status">Patient Status</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="date" class="form-control" id="patient_admit_date" name="patient_admit_date" placeholder="" required>
                                                    <label for="patient_admit_date">Admit Date</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="date" class="form-control" id="patient_discharge_date" name="patient_discharge_date" placeholder="">
                                                    <label for="patient_discharge_date">Discharge Date</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="patient_province" name="patient_province" required>
                                                        <option selected value="" hidden>Select Province</option>
                                                        <?php
                                                        $query = mysqli_query($connection, "SELECT * FROM tbl_province");
                                                        foreach ($query as $province) {
                                                            echo "<option value='{$province['id']}'>{$province['province']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="patient_province">Province</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="patient_city" name="patient_city" required>
                                                        <option selected value="" hidden>Select City</option>
                                                    </select>
                                                    <label for="patient_city">Cities</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="patient_area" name="patient_area" required>
                                                        <option selected value="" hidden>Select Area</option>
                                                    </select>
                                                    <label for="patient_area">Areas</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="patient_refferal" name="patient_refferal" required>
                                                        <option selected value="" hidden>Select Refferal</option>
                                                        <?php
                                                        $query = mysqli_query($connection, "SELECT * FROM tbl_refferals WHERE status ='activate'");
                                                        foreach ($query as $refferal) {
                                                            echo "<option value='{$refferal['id']}'>{$refferal['name']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="patient_refferal">Refferals</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="patient_panel" name="patient_panel" required>
                                                        <option selected value="" hidden>Select Panel</option>
                                                        <?php
                                                        $query = mysqli_query($connection, "SELECT * FROM tbl_panel WHERE status ='activate'");
                                                        foreach ($query as $refferal) {
                                                            echo "<option value='{$refferal['id']}'>{$refferal['company']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="patient_panel">Panels</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="employee_staff" name="employee_staff" required>
                                                        <option selected value="" hidden>Select Staff</option>
                                                        <?php
                                                        $query = mysqli_query($connection, "SELECT * FROM tbl_employees WHERE emp_designation !='admin' AND emp_status = 'activate'");
                                                        if (mysqli_num_rows($query) > 0) {
                                                            foreach ($query as $refferal) {
                                                                echo "<option value='{$refferal['emp_id']}'>{$refferal['emp_name']} ---- {$refferal['emp_designation']}</option>";
                                                            }
                                                        } else {
                                                            echo "<option>Staff Not Found</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="employee_staff">Staff</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="patient_service" name="patient_service" required>
                                                        <option selected value="" hidden>Select Service</option>
                                                        <?php
                                                        $query = mysqli_query($connection, "SELECT * FROM tbl_services WHERE status = 'available'");
                                                        if (mysqli_num_rows($query) > 0) {
                                                            foreach ($query as $service) {
                                                                echo "<option value='{$service['id']}'>{$service['service']}</option>";
                                                            }
                                                        } else {
                                                            echo "<option>Service Not Found</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="patient_service">Service</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="payment_status" name="payment_status" required>
                                                        <option value="" hidden>Payment Status</option>
                                                        <option value="r_from_patient">Recovery From Patient</option>
                                                        <option value="r_from_panel">Recovery From Panel</option>
                                                        <option value="zakat_donation">Zakat Donations</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                    <label for="payment_status">Payment Status</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="patient_rate" name="patient_rate" placeholder="" required>
                                                    <label for="patient_rate">Patient Rate</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="staff_rate" name="staff_rate" placeholder="" required>
                                                    <label for="staff_rate">Staff Rate</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="recovery" name="recovery" placeholder="">
                                                    <label for="recovery">Recovery</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="running_bill" name="running_bill" placeholder="">
                                                    <label for="running_bill">Running Bill</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control" name="note" placeholder="" id="note"></textarea>
                                                    <label for="note">Note Something</label>
                                                </div>
                                                <div class="button">
                                                    <button type="submit" name="btn_add_patient" class="btn btn-primary">Add Patient</button>
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