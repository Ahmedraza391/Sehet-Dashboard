<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>window.location.href='admin_login.php'</script>";
}
?>
<?php include("connection.php") ?>
<?php include("./Components/top.php") ?>
<?php
$page = "address";
?>
<title>Admin - Address Management</title>
<?php include("./Components/navbar.php") ?>
<?php include("./Components/sidebar.php") ?>
<div class="main" id="main">
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Address-Management</li>
            </ol>
        </nav>
    </div>
    <div class="addresses_content">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card p-md-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">Cities</h1>
                    </div>
                    <div class="city_table">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th>Id</th>
                                <th>City</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </thead>
                            <tbody id="cityTable">
                            </tbody>
                        </table>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editCityModal" tabindex="-1" aria-labelledby="editCityModalLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCityModalLabel">Edit City</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editcityForm">
                                        <input type="hidden" id="edit_city_Id">
                                        <div class="mb-3">
                                            <label for="editCityName" class="form-label">City</label>
                                            <input type="text" class="form-control" id="editCityName" required>
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

                    <!-- Add City Modal -->
                    <div class="add_city_modal">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_city">
                            Add City
                        </button>
                        <div class="modal fade" id="add_city" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_cityLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_cityLabel">Add City</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="city_form">
                                            <form id="insert_city_form">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="city" name="city" placeholder="" required>
                                                    <label for="city">Enter City</label>
                                                </div>
                                                <div class="button">
                                                    <button type="submit" name="btn_city" value="add_city" class="btn btn-primary">Add City</button>
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
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
<?php include("./Components/bottom.php") ?>