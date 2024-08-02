<?php
session_start();
include("connection.php");
if ((isset($_SESSION['employee_user'])) || (isset($_SESSION['admin']))) {
} else {
    echo "<script>window.location.href='admin_login.php'</script>";
}
$this_page = "employee_management";

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
$page = "emp_register";
$changes = "";
if (isset($_SESSION['admin'])) {
    $changes = "Admin";
} else if (isset($_SESSION['employee_user'])) {
    $changes = $_SESSION['employee_user']['user_name'];
}
?>
<title>Admin - Employee Registration</title>
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
    <div class="emloyee_content">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card p-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">Employees</h1>
                    </div>
                    <div class="employee_table overflow_table mb-3">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th class="text-center">Employee Id</th>
                                <th class="text-left">Employee Name</th>
                                <th class="text-left">Employee Email</th>
                                <th class="text-left">Employee Contact</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </thead>
                            <tbody id="employeeTable">
                            </tbody>
                        </table>
                    </div>
                    <!-- View Modal -->
                    <div class="modal fade" id="viewEmployee" tabindex="-1" aria-labelledby="viewEmployeeLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="viewEmployeeLabel">Employee</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card p-md-3">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <h6 class="">ID : #<span class="fs-6" id="emp_id"></span></h6>
                                        </div>
                                        <div class="name">
                                            <h6>Name : <span class="fs-6" id="emp_name"></span></h6>
                                        </div>
                                        <div class="f_name">
                                            <h6>Father Name : <span class="fs-6" id="emp_f_name"></span></h6>
                                        </div>
                                        <div class="email">
                                            <h6>Email : <span class="fs-6" id="emp_email"></span></h6>
                                        </div>
                                        <div class="contact">
                                            <h6>Contact # : <span class="fs-6" id="emp_contact"></span></h6>
                                        </div>
                                        <div class="Nic">
                                            <h6>N.I.C # : <span class="fs-6" id="emp_nic"></span></h6>
                                        </div>
                                        <div class="dob">
                                            <h6>Date of Birth : <span class="fs-6" id="emp_dob"></span></h6>
                                        </div>
                                        <div class="designation">
                                            <h6>Designation : <span class="fs-6" id="emp_designation"></span></h6>
                                        </div>
                                        <div class="Status">
                                            <h6>Status : <span class="fs-6" id="emp_status"></span></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- View History Modal -->
                    <div class="modal fade" id="view_employees_history" tabindex="-1" aria-labelledby="view_employees_historyLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="view_employees_historyLabel">Employee History</h3>
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
                                                $query = mysqli_query($connection, "SELECT * FROM tbl_history WHERE page_name='employees' ORDER BY id DESC");
                                                $index = 1;
                                                if(mysqli_num_rows($query)>0){
                                                    foreach ($query as $history) {
                                                        echo "<tr>";
                                                        $page_name = "";
                                                        if ($history['page_name'] == "employees") {
                                                            $page_name = "Employee";
                                                        }
                                                        echo "<td>{$index}</td>";
                                                        echo "<td>{$page_name}</td>";
                                                        echo "<td>{$history['changes_person']}</td>";
                                                        $type = "";
                                                        if ($history['change_type'] == "add_employees") {
                                                            $type = "Employee Added";
                                                        } else if ($history['change_type'] == "edit_employees") {
                                                            $type = "Employee Edited";
                                                        } else if ($history['change_type'] == "available_employees") {
                                                            $type = "Employee Available";
                                                        } else if ($history['change_type'] == "unavailable_employees") {
                                                            $type = "Employee Unavailable";
                                                        } else if ($history['change_type'] == "enable_employees") {
                                                            $type = "Employee Enable";
                                                        } else if ($history['change_type'] == "disable_employees") {
                                                            $type = "Employee Disable";
                                                        } else if ($history['change_type'] == "activate_employees") {
                                                            $type = "Employee Activate";
                                                        } else if ($history['change_type'] == "deactivate_employees") {
                                                            $type = "Employee Deactivate";
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
                    <div class="modal fade" id="editEmployee" tabindex="-1" aria-labelledby="editEmployeeLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editEmployeeLabel">Edit Employee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit_employee_form">
                                        <input type="hidden" name="tbl_id" id="tbl_id">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_emp_id" disabled>
                                            <label for="edit_emp_id">Employee Id</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_emp_name" name="edit_emp_name" required>
                                            <label for="edit_emp_name">Employee Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_emp_father_name" name="edit_emp_father_name" required>
                                            <label for="edit_emp_father_name">Employee Father Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="edit_emp_email" name="edit_emp_email" required>
                                            <label for="edit_emp_email">Employee Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control no-spinner" id="edit_emp_contact" name="edit_emp_contact" required>
                                            <label for="edit_emp_contact">Employee Contact #</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_emp_nic" name="edit_emp_nic" pattern="\d{13}" required>
                                            <label for="edit_emp_nic">Employee N.I.C #</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" id="edit_emp_dob" name="edit_emp_dob" max="<?php echo date('Y-m-d', strtotime('-1 day')); ?>" required>
                                            <label for="edit_emp_dob">Employee Date Of Birth</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="edit_emp_designation" name="edit_emp_designation" required>
                                                <option value="" hidden>Select Designation</option>
                                                <option value="nursing_staff">Nursing Staff</option>
                                                <option value="doctor">Doctor</option>
                                                <option value="physiotherapist">Physiotherapist</option>
                                                <option value="phlebotomist">Phlebotomist</option>
                                            </select>
                                            <label for="edit_emp_designation">Designation</label>
                                        </div>
                                        <input type="hidden" name="edit_employee_changes_person" id="edit_employee_changes_person" value="<?php echo $changes; ?>">
                                        <div class="button">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
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
                            <button type="button" class="btn btn-primary btn-sm text-center" data-bs-toggle="modal" data-bs-target="#add_employe">
                                Add Employees
                            </button>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-sm-12 mb-2 mb-sm-3 mb-md-0 col-md-4 d-md-flex align-items-center justify-content-end">
                            <button type="button" class="btn btn-success btn-sm text-center" data-bs-toggle="modal" data-bs-target="#view_employees_history">
                                View Employees History
                            </button>
                        </div>
                    </div>
                    <!-- Add Employee Modal -->
                    <div class="add_employee_modal">
                        <div class="modal fade" id="add_employe" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_employeLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_employeLabel">Add Employee</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="employees_form">
                                            <form id="insert_employee_form">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" placeholder="" id="emp_id" name="emp_id" required>
                                                    <label for="emp_id">Employee Id</label>
                                                    <div class="invalid-feedback emp_id_feedback">Please enter the employee Id in the format 1234-567.</div>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="emp_name" name="emp_name" placeholder="" required>
                                                    <label for="emp_name">Employee Name</label>
                                                    <div class="invalid-feedback emp_name_feedback">Please enter the employee name.</div>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="emp_father_name" name="emp_father_name" placeholder="" required>
                                                    <label for="emp_father_name">Employee Father Name</label>
                                                    <div class="invalid-feedback emp_father_name_feedback">Please enter the father name.</div>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" id="emp_email" name="emp_email" placeholder="" title="Please enter a valid email address." required>
                                                    <label for="emp_email">Employee Email</label>
                                                    <div class="invalid-feedback emp_email_feedback">Please enter a valid email address.</div>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control no-spinner" id="emp_contact" name="emp_contact" placeholder="" required>
                                                    <label for="emp_contact">Employee Contact #</label>
                                                    <div class="invalid-feedback emp_contact_feedback">Contact Field Required.</div>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="emp_nic" name="emp_nic" placeholder="" pattern="\d{13}" required>
                                                    <label for="emp_nic">Employee N.I.C #</label>
                                                    <div class="invalid-feedback emp_nic_feedback">Please enter a valid NIC number with exactly 13 digits.</div>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="date" class="form-control" id="emp_dob" name="emp_dob" placeholder="" max="<?php echo date('Y-m-d', strtotime('-1 day')); ?>" required>
                                                    <label for="emp_dob">Employee Date Of Birth</label>
                                                    <div class="invalid-feedback emp_dob_feedback">Please select a date of birth from previous years only.</div>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="emp_designation" name="emp_designation" aria-label="Floating label select example" required>
                                                        <option value="" hidden>Select Designation</option>
                                                        <option value="nursing_staff">Nursing Staff</option>
                                                        <option value="doctor">Doctor</option>
                                                        <option value="physiotherapist">Physiotherapist</option>
                                                        <option value="phlebotomist">Phlebotomist</option>
                                                    </select>
                                                    <label for="emp_designation">Designations</label>
                                                    <div class="invalid-feedback emp_designation_feedback">Please select a designation.</div>
                                                </div>
                                                <input type="hidden" name="add_employee_changes_person" id="add_employee_changes_person" value="<?php echo $changes; ?>">
                                                <div class="button">
                                                    <button type="submit" name="btn_employee" id="insert_employee" class="btn btn-primary">Add Employee</button>
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