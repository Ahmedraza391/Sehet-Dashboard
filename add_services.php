<?php include("./Components/top.php") ?>
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
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="services_form p-md-5">
                    <form method="POST">
                    <div class="heading my-3">
                        <h2 class="text-body-secondary fw-bold text-center">Add Service</h2>
                    </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="serivce" placeholder="">
                            <label for="serivce">Enter Service</label>
                        </div>
                        <div class="button">
                            <a href="" class="btn btn-primary">Add Service</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
<?php include("./Components/bottom.php") ?>