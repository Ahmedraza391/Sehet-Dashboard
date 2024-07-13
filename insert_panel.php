<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $company = $_POST['panel_company'];
  $manager = $_POST['panel_manager'];
  $email = $_POST['panel_email'];
  $p_contact = $_POST['panel_contact_num'];
  $manager_contact = $_POST['panel_manager_contact_num'];
  $province = $_POST['province'];
  $city = $_POST['city'];
  $area = $_POST['area_id'];

  if (!isset($_POST['services']) || empty($_POST['services'])) {
    echo "Please select at least one service";
  } else {
    $services = $_POST['services'];
    if(isset($_POST['extra_services'])){
        $extra_services = $_POST['extra_services']; // Assuming this is structured as an array of arrays
    }

    // Start transaction
    mysqli_begin_transaction($connection);
  
    try {
      // Insert main panel data using prepared statement
      $query = "INSERT INTO tbl_panel (company, email, focal_person, company_contact, focal_person_contact, province_id, city_id, area_id, status, services)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'activate', '')";
      $stmt = mysqli_prepare($connection, $query);
      mysqli_stmt_bind_param($stmt, 'ssssssss', $company, $email, $manager, $p_contact, $manager_contact, $province, $city, $area);
      mysqli_stmt_execute($stmt);
  
      $panel_id = mysqli_insert_id($connection);
  
      // Insert sub-services and their extra services into tbl_panel_services
      foreach ($services as $sub_service_id) {
        $extra_service_ids = isset($extra_services[$sub_service_id]) ? $extra_services[$sub_service_id] : [];

        // Insert main service into tbl_panel_services
        $query = "INSERT INTO tbl_panel_services (panel_id, sub_services_id, extra_services_id)
                  VALUES (?, ?, NULL)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $panel_id, $sub_service_id);
        mysqli_stmt_execute($stmt);

        // Insert extra services into tbl_panel_services
        foreach ($extra_service_ids as $extra_service_id) {
          $query = "INSERT INTO tbl_panel_services (panel_id, sub_services_id, extra_services_id)
                    VALUES (?, ?, ?)";
          $stmt = mysqli_prepare($connection, $query);
          mysqli_stmt_bind_param($stmt, 'iii', $panel_id, $sub_service_id, $extra_service_id);
          mysqli_stmt_execute($stmt);
        }
      }
  
      // Update the services field in tbl_panel with sub-service IDs
      $fetched_services = implode(",", $services);
      $update_query = "UPDATE tbl_panel SET services=? WHERE id=?";
      $stmt = mysqli_prepare($connection, $update_query);
      mysqli_stmt_bind_param($stmt, 'si', $fetched_services, $panel_id);
      mysqli_stmt_execute($stmt);
  
      // Commit transaction
      mysqli_commit($connection);
      echo "Panel Inserted Successfully";
    } catch (Exception $e) {
      // Rollback transaction on error
      mysqli_rollback($connection);
      echo "Error in Panel Insertion: " . $e->getMessage();
    }

  }
}
?>
