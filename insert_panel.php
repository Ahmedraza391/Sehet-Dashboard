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
  $service_prices = $_POST['service_prices'];
  $extra_service_prices = $_POST['extra_service_prices'];

  if (empty($_POST['services'])) {
    echo "Please select at least one service";
    exit;
  }

  $services = $_POST['services'];
  $extra_services = $_POST['extra_services'] ?? [];

  mysqli_begin_transaction($connection);

  try {
    // Insert main panel data
    $query = "INSERT INTO tbl_panel (company, email, focal_person, company_contact, focal_person_contact, province_id, city_id, area_id, status, services)
              VALUES ('$company', '$email', '$manager', '$p_contact', '$manager_contact', '$province', '$city', '$area', 'activate', '')";
    if (!mysqli_query($connection, $query)) {
      throw new Exception("Error inserting panel: " . mysqli_error($connection));
    }
    
    $panel_id = mysqli_insert_id($connection);
    date_default_timezone_set('Asia/Karachi');
    $date = date('Y-m-d');
    $time = date('h:i:s');
    $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('panels','$_POST[add_panel_changes_person]','add_panels','$date','$time')");
    // Insert services and extra services
    foreach ($services as $sub_service_id) {
      $sub_service_price = $service_prices[$sub_service_id] ?? 'NULL';

      $query = "INSERT INTO tbl_panel_services (panel_id, sub_services_id, sub_service_price) VALUES ($panel_id, $sub_service_id, $sub_service_price)";
      if (!mysqli_query($connection, $query)) {
        throw new Exception("Error inserting service: " . mysqli_error($connection));
      }

      if (isset($extra_services[$sub_service_id])) {
        foreach ($extra_services[$sub_service_id] as $extra_service_id) {
          $extra_service_price = $extra_service_prices[$sub_service_id][$extra_service_id] ?? 'NULL';

          $query = "INSERT INTO tbl_panel_services (panel_id, sub_services_id, extra_services_id, sub_service_price, extra_service_price)
                    VALUES ($panel_id, $sub_service_id, $extra_service_id, $sub_service_price, $extra_service_price)";
          if (!mysqli_query($connection, $query)) {
            throw new Exception("Error inserting extra service: " . mysqli_error($connection));
          }
        }
      }
    }

    // Update services field in tbl_panel
    $fetched_services = implode(",", $services);
    $query = "UPDATE tbl_panel SET services='$fetched_services' WHERE id=$panel_id";
    if (!mysqli_query($connection, $query)) {
      throw new Exception("Error updating services: " . mysqli_error($connection));
    }

    mysqli_commit($connection);
    echo "Panel Inserted Successfully";
  } catch (Exception $e) {
    mysqli_rollback($connection);
    echo "Error in Panel Insertion: " . $e->getMessage();
  }
}
?>
