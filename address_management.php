<?php
session_start();
include("connection.php");
if ((isset($_SESSION['employee_user'])) || (isset($_SESSION['admin'])) ) {

}else{
  echo "<script>window.location.href='admin_login.php'</script>";
}
$this_page = "address_management";

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
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card p-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">Province</h1>
                    </div>
                    <div class="province_table overflow_table">
                        <table class="table rounded table-bordered mb-3">
                            <thead>
                                <th>Id</th>
                                <th>Province</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </thead>
                            <tbody id="provinceTable">
                            </tbody>
                        </table>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="edit_province_modal" tabindex="-1" aria-labelledby="edit_province_modalLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="edit_province_modalLabel">Edit Province</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editprovinceForm">
                                        <input type="hidden" id="edit_province_Id">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="" id="edit_province" required>
                                            <label for="edit_province">Province</label>
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_province">
                            Add Provinces
                        </button>
                        <div class="modal fade" id="add_province" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_provinceLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_provinceLabel">Add Province</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="province_form">
                                            <form id="insert_province_form">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="province" name="province" placeholder="" required>
                                                    <label for="province">Enter Province</label>
                                                </div>
                                                <div class="button">
                                                    <button type="submit" name="btn_province" value="add_province" class="btn btn-primary">Add Province</button>
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
                        <h1 class="fs-3 fw-bold">Cities</h1>
                    </div>
                    <div class="city_table overflow_table mb-3">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th>Id</th>
                                <th>City</th>
                                <th>Province</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </thead>
                            <tbody id="cityTable">
                            </tbody>
                        </table>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="edit_city_modal" tabindex="-1" aria-labelledby="edit_city_modalLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="edit_city_modalLabel">Edit City</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editcityForm">
                                        <input type="hidden" name="city_id" id="city_id">
                                        <div class="form-floating my-3">
                                            <select class="form-select" id="province_menu" name="province_id" aria-label="Floating label select example" required>
                                            </select>
                                            <label for="province_menu">Provinces</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="city" placeholder="" name="city" required>
                                            <label for="city">City</label>
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
                            Add Cities
                        </button>
                        <div class="modal fade" id="add_city" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_cityLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_cityLabel">Add City-Capital</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="city_form">
                                            <form id="insert_city_form">
                                                <div class="form-floating my-3">
                                                    <select class="form-select" id="province_id" name="province_id" aria-label="Floating label select example" required>
                                                        <option value="" hidden>Select Province</option>
                                                        <?php
                                                        $fetch_province = mysqli_query($connection, "SELECT * FROM tbl_province");
                                                        foreach ($fetch_province as $province) {
                                                            echo "<option value='$province[id]'>$province[province]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="city_id">Provinces</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="city" name="city" placeholder="" required>
                                                    <label for="city">Enter City-Capital</label>
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
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card p-3">
                    <div class="heading my-2 text-center">
                        <h1 class="fs-3 fw-bold">City Areas</h1>
                    </div>
                    <div class="city_area_table overflow_table mb-3">
                        <table class="table rounded table-bordered">
                            <thead>
                                <th>Id</th>
                                <th>City-Areas</th>
                                <th>City-Captials</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </thead>
                            <tbody id="cityareaTable">
                            </tbody>
                        </table>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editCapitalAreaModal" tabindex="-1" aria-labelledby="editCapitalAreaModalLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCapitalAreaModalLabel">Edit Area</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editcityareaForm">
                                        <input type="hidden" name="area_id" id="area_id">
                                        <div class="form-floating my-3">
                                            <select class="form-select" id="city_menu" name="city_id" aria-label="Floating label select example" required>
                                            </select>
                                            <label for="city_menu">Cities</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="area_name" name="area_name"  placeholder="">
                                            <label for="area_name">Area</label>
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_city_area">
                            Add Areas
                        </button>
                        <div class="modal fade" id="add_city_area" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_city_areaLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-4 fw-bold" id="add_city_areaLabel">Add City-Capital</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="city_form">
                                            <form id="insert_capital_area_form">
                                                <div class="form-floating my-3">
                                                    <select class="form-select" id="city_id" name="city_id" aria-label="Floating label select example" required>
                                                        <option value="" hidden>Select City</option>
                                                        <?php
                                                        $fetch_city = mysqli_query($connection, "SELECT * FROM tbl_city");
                                                        foreach ($fetch_city as $city) {
                                                            echo "<option value='$city[id]'>$city[city]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="city_id">Cities</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="city_area" name="city_area" placeholder="" required>
                                                    <label for="city_area">Enter City-Area</label>
                                                </div>
                                                <div class="button">
                                                    <button type="submit" name="btn_area" value="btn_area" class="btn btn-primary">Add Area</button>
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