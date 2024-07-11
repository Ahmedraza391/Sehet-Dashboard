<?php 
    include("connection.php");
    $name = $_POST['ref_name'];
    $company = $_POST['ref_company'];
    $email = $_POST['ref_email'];
    $share = $_POST['ref_share'];
    $query  = "INSERT INTO tbl_refferals(name,company,email,financial_share)VALUES('$name','$company','$email','$share')";
    $run_query = mysqli_query($connection,$query);
    if($run_query){
        echo "Refferal Added Succesfully";
    }else{
        echo "Error In Submission";
    }
?>