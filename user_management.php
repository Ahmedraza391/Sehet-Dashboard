<?php
session_start();
include("connection.php");
if ((isset($_SESSION['employee_user'])) || (isset($_SESSION['admin'])) ) {

}else{
  echo "<script>window.location.href='admin_login.php'</script>";
}
$this_page = "user_management";

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
$page = "emp_user_register";
?>
<title>Admin - User Registration</title>
<?php include("./Components/navbar.php") ?>
<?php include("./Components/sidebar.php") ?>
<div class="main" id="main">
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">User Management</li>
            </ol>
        </nav>
    </div>
    <div class="emloyee_content">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card p-md-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">Employee Users</h1>
                    </div>
                    <div class="p-md-2">
                        <h5 class="fs-4 fw-bold my-3">Select Employees :</h5>
                        <div class="form-floating mb-3">
                            <?php
                            $fetch_emp_query = mysqli_query($connection, "SELECT * FROM tbl_employees WHERE emp_status = 'activate' AND registration_status = 'unregistered' AND emp_designation = 'admin'");
                            $fetch_emp = mysqli_fetch_assoc($fetch_emp_query);
                            ?>
                            <select class="form-select" id="emp_selection" name="emp_selection" aria-label="Floating label select example" required>
                                <option value="" hidden selected>Select Employee</option>
                                <?php
                                foreach ($fetch_emp_query as $employees) {
                                    echo "<option value='$employees[emp_id]'>$employees[emp_name]</option>";
                                }
                                ?>
                            </select>
                            <label for="emp_selection">Employees</label>
                            <div class="invalid-feedback emp_designation_feedback">Please select a designation.</div>
                        </div>
                    </div>
                    <div class="employee_table overflow_table">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th class="text-center">Id</th>
                                <th class="text-left">User Name</th>
                                <th class="text-left">User Email</th>
                                <th class="text-left">User Contact</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </thead>
                            <tbody id="userTable">
                            </tbody>
                        </table>
                    </div>
                    <!-- View Modal -->
                    <div class="modal fade" id="viewUser" tabindex="-1" aria-labelledby="viewUserLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="viewUserLabel">Employee</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card p-md-3">
                                        <div class="mb-2 d-flex align-items-center justify-content-start">
                                            <h6>ID : #<span class="fs-6" id="emp_id"></span></h6>
                                        </div>
                                        <div class="name mb-2">
                                            <h6>Name : <span class="fs-6" id="emp_name"></span></h6>
                                        </div>
                                        <div class="f_name mb-2">
                                            <h6>Father Name : <span class="fs-6" id="emp_f_name"></span></h6>
                                        </div>
                                        <div class="email mb-2">
                                            <h6>Email : <span class="fs-6" id="emp_email"></span></h6>
                                        </div>
                                        <div class="password mb-2 d-flex align-items-center justify-content-left">
                                            <h6 class="mt-2 me-3">Password : </h6>
                                            <div class="password-wrapper">
                                                <input type="password" disabled id="emp_password" class="form-control password">
                                                <i class="bi bi-eye-slash togglePassword"></i>
                                            </div>
                                        </div>
                                        <div class="contact mb-2">
                                            <h6>Contact # : <span class="fs-6" id="emp_contact"></span></h6>
                                        </div>
                                        <div class="Nic mb-2">
                                            <h6>N.I.C # : <span class="fs-6" id="emp_nic"></span></h6>
                                        </div>
                                        <div class="dob mb-2">
                                            <h6>Date of Birth : <span class="fs-6" id="emp_dob"></span></h6>
                                        </div>
                                        <div class="status mb-2">
                                            <h6>Status : <span class="fs-6" id="emp_status"></span></h6>
                                        </div>
                                        <div class="status mb-2">
                                            <h6>Pages :</h6>
                                            <ul id="emp_pages"></ul>
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
                    <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit_user_form">
                                        <input type="hidden" value="edit_emp_user_id" name="edit_emp_user_id" id="edit_emp_user_id">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_emp_user_name" name="edit_emp_user_name" placeholder="" required>
                                            <label for="emp_name">Employee Name</label>
                                            <div class="invalid-feedback emp_name_feedback">Please enter the employee name.</div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_emp_user_father_name" name="edit_emp_user_father_name" placeholder="" required>
                                            <label for="edit_emp_user_father_name">Employee Father Name</label>
                                            <div class="invalid-feedback emp_father_name_feedback">Please enter the father name.</div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="edit_emp_user_email" name="edit_emp_user_email" placeholder="" title="Please enter a valid email address." required>
                                            <label for="edit_emp_user_email">Employee Email</label>
                                            <div class="invalid-feedback emp_emai_feedback">Please enter a valid email address.</div>
                                        </div>
                                        <div class="form-floating mb-3 password-wrapper">
                                            <input type="password" name="edit_emp_user_password" id="edit_emp_user_password" class="form-control password" placeholder="Employee Password" required>
                                            <i class="bi bi-eye-slash togglePassword"></i>
                                            <label for="edit_emp_user_password">Employee Password</label>
                                            <div class="invalid-feedback">Please, Enter password!</div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="tel" class="form-control" id="edit_emp_user_contact" name="edit_emp_user_contact" placeholder="" pattern="03\d{9}" title="Please enter a valid contact number starting with 03 and having 11 digits." required>
                                            <label for="edit_emp_user_contact">Employee Contact #</label>
                                            <div class="invalid-feedback emp_contact_feedback">Please enter a valid contact number starting with 03 and having 11 digits.</div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit_emp_user_nic" name="edit_emp_user_nic" placeholder="" pattern="\d{13}" required>
                                            <label for="edit_emp_user_nic">Employee N.I.C #</label>
                                            <div class="invalid-feedback emp_nic_feedback">Please enter a valid NIC number with exactly 13 digits.</div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" id="edit_emp_user_dob" name="edit_emp_user_dob" placeholder="" max="<?php echo date('Y-m-d', strtotime('-1 day')); ?>" required>
                                            <label for="emp_dob">Employee Date Of Birth</label>
                                            <div class="invalid-feedback emp_dob_feedback">Please select a date of birth from previous years only.</div>
                                        </div>
                                        <div class="card p-md-3">
                                            <label class="mb-3">Select Pages :</label>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="edit_pages_access[]" value="service_management" id="edit_service_page">
                                                <label class="form-check-label" for="edit_service_page">
                                                    Service Management
                                                </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="edit_pages_access[]" value="address_management" id="edit_address_page">
                                                <label class="form-check-label" for="edit_address_page">
                                                    Addresses Management
                                                </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="edit_pages_access[]" value="reffrel_management" id="edit_reffrel_page">
                                                <label class="form-check-label" for="edit_reffrel_page">
                                                    Reffrel Management
                                                </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="edit_pages_access[]" value="panel_management" id="edit_panel_page">
                                                <label class="form-check-label" for="edit_panel_page">
                                                    Panel Management
                                                </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="edit_pages_access[]" value="employee_management" id="edit_employee_page">
                                                <label class="form-check-label" for="edit_employee_page">
                                                    Employee Management
                                                </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="edit_pages_access[]" value="user_management" id="edit_user_page">
                                                <label class="form-check-label" for="edit_user_page">
                                                    User Management
                                                </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="edit_pages_access[]" value="patient_management" id="edit_patient_page">
                                                <label class="form-check-label" for="edit_patient_page">
                                                    Patient Management
                                                </label>
                                            </div>
                                        </div>
                                        <div class="button">
                                            <button type="submit" name="update_employee" id="update_user" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add Employee Modal -->
                    <div class="add_employee_modal">
                        <div class="modal fade" id="add_user" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_userLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_userLabel">Add User</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="employee_user_form">
                                            <form id="insert_employee_user_form" class="d-none">
                                                <input type="hidden" value="emp_user_id" name="emp_user_id" id="emp_user_id">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="emp_user_name" disabled placeholder="" required>
                                                    <label for="emp_name">Employee Name</label>
                                                    <div class="invalid-feedback emp_name_feedback">Please enter the employee name.</div>
                                                    <input type="hidden" id="emp_user_name_hidden" name="emp_user_name">
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="emp_user_father_name" disabled placeholder="" required>
                                                    <label for="emp_father_name">Employee Father Name</label>
                                                    <div class="invalid-feedback emp_father_name_feedback">Please enter the father name.</div>
                                                    <input type="hidden" id="emp_user_father_name_hidden" name="emp_user_father_name">
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" id="emp_user_email" name="emp_user_email" placeholder="" title="Please enter a valid email address." required>
                                                    <label for="emp_email">Employee Email</label>
                                                    <div class="invalid-feedback emp_emai_feedback">Please enter a valid email address.</div>
                                                </div>
                                                <div class="form-floating mb-3 password-wrapper">
                                                    <input type="password" name="emp_user_password" id="emp_user_password" class="form-control password" placeholder="Employee Password" required>
                                                    <i class="bi bi-eye-slash togglePassword"></i>
                                                    <label for="emp_user_password">Employee Password</label>
                                                    <div class="invalid-feedback">Please, Enter password!</div>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="tel" class="form-control" id="emp_user_contact" name="emp_user_contact" placeholder="" pattern="03\d{9}" title="Please enter a valid contact number starting with 03 and having 11 digits." required>
                                                    <label for="emp_contact">Employee Contact #</label>
                                                    <div class="invalid-feedback emp_contact_feedback">Please enter a valid contact number starting with 03 and having 11 digits.</div>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="emp_user_nic" disabled placeholder="" pattern="\d{13}" required>
                                                    <label for="emp_nic">Employee N.I.C #</label>
                                                    <div class="invalid-feedback emp_nic_feedback">Please enter a valid NIC number with exactly 13 digits.</div>
                                                    <input type="hidden" id="emp_user_nic_hidden" name="emp_user_nic">
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="date" class="form-control" id="emp_user_dob" disabled placeholder="" max="<?php echo date('Y-m-d', strtotime('-1 day')); ?>" required>
                                                    <label for="emp_dob">Employee Date Of Birth</label>
                                                    <div class="invalid-feedback emp_dob_feedback">Please select a date of birth from previous years only.</div>
                                                    <input type="hidden" id="emp_user_dob_hidden" name="emp_user_dob">
                                                </div>
                                                <div class="card p-md-3">
                                                    <label class="mb-3">Select Pages :</label>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pages_access[]" value="service_management" id="service_page">
                                                        <label class="form-check-label" for="service_page">
                                                            Service Management
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pages_access[]" value="address_management" id="address_page">
                                                        <label class="form-check-label" for="address_page">
                                                            Addresses Management
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pages_access[]" value="reffrel_management" id="reffrel_page">
                                                        <label class="form-check-label" for="reffrel_page">
                                                            Reffrel Management
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pages_access[]" value="panel_management" id="panel_page">
                                                        <label class="form-check-label" for="panel_page">
                                                            Panel Management
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pages_access[]" value="employee_management" id="employee_page">
                                                        <label class="form-check-label" for="employee_page">
                                                            Employee Management
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pages_access[]" value="employee_management" id="user_page">
                                                        <label class="form-check-label" for="user_page">
                                                            User Management
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pages_access[]" value="patient_management" id="patient_page">
                                                        <label class="form-check-label" for="patient_page">
                                                            Patient Management
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="button">
                                                    <button type="submit" name="btn_employee" id="insert_user" class="btn btn-primary">Add User</button>
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