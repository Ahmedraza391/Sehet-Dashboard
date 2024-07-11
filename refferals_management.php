<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>window.location.href='admin_login.php'</script>";
}
?>
<?php include("connection.php") ?>
<?php include("./Components/top.php") ?>
<?php
$page = "reffrals";
?>
<title>Admin - Reffrels Management</title>
<?php include("./Components/navbar.php") ?>
<?php include("./Components/sidebar.php") ?>
<div class="main" id="main">
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Reffrels-Management</li>
            </ol>
        </nav>
    </div>
    <div class="addresses_content">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card p-md-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">Refferals</h1>
                    </div>
                    <div class="reffral_table overflow_table">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th class="text-center">Id</th>
                                <th class="text-left">Reffred By</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </thead>
                            <tbody id="reffralTable">
                            </tbody>
                        </table>
                    </div>
                    <!-- View Modal -->
                    <div class="modal fade" id="viewReffral" tabindex="-1" aria-labelledby="viewReffralLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="viewReffralLabel">Refferal</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                   <div class="card p-md-3">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <h6 class="">ID : #<span class="fs-6" id="ref_id"></span></h6>
                                    </div>
                                    <div class="name"><h6>Name : <span class="fs-6" id="ref_name"></span></h6></div>
                                    <div class="company"><h6>Company : <span class="fs-6" id="ref_company"></span></h6></div>
                                    <div class="email"><h6>Email : <span class="fs-6" id="ref_email"></span></h6></div>
                                    <div class="share"><h6>Financial Share : <span class="fs-6" id="ref_share"></span>%</h6></div>
                                    <div class="Status"><h6>Status : <span class="fs-6" id="ref_status"></span></h6></div>
                                   </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editReffrals" tabindex="-1" aria-labelledby="editReffralsLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editReffralsLabel">Edit Refferal</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit_reffrals_form">
                                        <input type="hidden" id="reffral_id" name="reffral_id">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="" id="reffral_name" name="reffral_name" required>
                                            <label for="reffral_name">Enter Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="" id="reffral_company" name="reffral_company" required>
                                            <label for="reffral_company">Enter Company</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="" id="reffral_email" name="reffral_email">
                                            <label for="reffral_email">Enter Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control share" placeholder="" min="0" max="100" id="reffral_share" name="reffral_share" required>
                                            <label for="reffral_share">Financial Share</label>
                                            <div id="error" class="error text-danger"></div>
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

                    <!-- Add Reffrals Modal -->
                    <div class="reffrel_modal">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reffral_modal">
                            Add Refferals
                        </button>
                        <div class="modal fade" id="reffral_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="reffral_modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="reffral_modalLabel">Add Refferals</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="reffral_form">
                                            <form id="reffral_form">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="ref_name" name="ref_name" placeholder="" required>
                                                    <label for="ref_name">Enter Name</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="ref_company" name="ref_company" placeholder="" required>
                                                    <label for="ref_company">Enter Company</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="ref_email" name="ref_email" placeholder="">
                                                    <label for="ref_email">Enter Email</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control share" id="ref_share" name="ref_share" min="0" max="100" required placeholder="">
                                                    <label for="ref_share">Enter Financial Share</label>
                                                    <div id="error" class="error text-danger"></div>
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