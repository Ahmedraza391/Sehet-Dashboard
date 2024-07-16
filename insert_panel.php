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
  $service_prices = $_POST['service_prices']; // Custom service prices
  $extra_service_prices = $_POST['extra_service_prices']; // Custom extra service prices
  if (!isset($_POST['services']) || empty($_POST['services'])) {
    echo "Please select at least one service";
  } else {
    $services = $_POST['services'];
    $extra_services = isset($_POST['extra_services']) ? $_POST['extra_services'] : [];

    // Start transaction
    mysqli_begin_transaction($connection);

    try {
      // Insert main panel data using prepared statement
      $query = "INSERT INTO tbl_panel (company, email, focal_person, company_contact, focal_person_contact, province_id, city_id, area_id, status, services)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'activate', '')";
      $stmt = mysqli_prepare($connection, $query);
      if (!$stmt) {
        throw new Exception("Preparation failed: " . mysqli_error($connection));
      }
      mysqli_stmt_bind_param($stmt, 'ssssssss', $company, $email, $manager, $p_contact, $manager_contact, $province, $city, $area);
      if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Execution failed: " . mysqli_stmt_error($stmt));
      }

      $panel_id = mysqli_insert_id($connection);

      // Insert sub-services and their extra services into tbl_panel_services
      foreach ($services as $sub_service_id) {
        // Determine service price
        $sub_service_price = isset($service_prices[$sub_service_id]) ? $service_prices[$sub_service_id] : null;

        // Insert main service into tbl_panel_services
        $query = "INSERT INTO tbl_panel_services (panel_id, sub_services_id, extra_services_id, sub_service_price, extra_service_price)
                          VALUES (?, ?, NULL, ?, NULL)";
        $stmt = mysqli_prepare($connection, $query);
        if (!$stmt) {
          throw new Exception("Preparation failed: " . mysqli_error($connection));
        }
        mysqli_stmt_bind_param($stmt, 'iid', $panel_id, $sub_service_id, $sub_service_price);
        if (!mysqli_stmt_execute($stmt)) {
          throw new Exception("Execution failed: " . mysqli_stmt_error($stmt));
        }

        // Insert extra services into tbl_panel_services if any
        if (isset($extra_services[$sub_service_id])) {
          foreach ($extra_services[$sub_service_id] as $extra_service_id) {
            // Determine extra service price
            $extra_service_price = isset($extra_service_prices[$sub_service_id][$extra_service_id]) ? $extra_service_prices[$sub_service_id][$extra_service_id] : null;

            // Insert extra service into tbl_panel_services
            $query = "INSERT INTO tbl_panel_services (panel_id, sub_services_id, extra_services_id, sub_service_price, extra_service_price)
                                  VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($connection, $query);
            if (!$stmt) {
              throw new Exception("Preparation failed: " . mysqli_error($connection));
            }
            mysqli_stmt_bind_param($stmt, 'iiidd', $panel_id, $sub_service_id, $extra_service_id, $sub_service_price, $extra_service_price);
            if (!mysqli_stmt_execute($stmt)) {
              throw new Exception("Execution failed: " . mysqli_stmt_error($stmt));
            }
          }
        }
      }

      // Update the services field in tbl_panel with sub-service IDs
      $fetched_services = implode(",", $services);
      $update_query = "UPDATE tbl_panel SET services=? WHERE id=?";
      $stmt = mysqli_prepare($connection, $update_query);
      if (!$stmt) {
        throw new Exception("Preparation failed: " . mysqli_error($connection));
      }
      mysqli_stmt_bind_param($stmt, 'si', $fetched_services, $panel_id);
      if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Execution failed: " . mysqli_stmt_error($stmt));
      }

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
