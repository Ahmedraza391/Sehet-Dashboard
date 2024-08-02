<?php 
    include("connection.php");
    $name = $_POST['ref_name'];
    $company = $_POST['ref_company'];
    $email = $_POST['ref_email'];
    $share = $_POST['ref_share'];
    $query  = "INSERT INTO tbl_refferals(name,company,email,financial_share)VALUES('$name','$company','$email','$share')";
    $run_query = mysqli_query($connection,$query);
    if($run_query){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('refferals','$_POST[add_refferal_changes_person]','add_refferals','$date','$time')");
        echo "Refferal Added Succesfully";
    }else{
        echo "Error In Submission";
    }
?>