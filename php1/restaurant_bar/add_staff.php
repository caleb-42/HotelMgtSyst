<?php
include "settings/connect.php"; //$database handler $dbConn or $conn

$new_staff = json_decode($_POST["new_staff"], true);

$staff_name = $new_staff["staff_name"];
$department = $new_staff["department"];
$phone_number = $new_staff["phone_number"];
$contact_adress = $new_staff["contact_adress"];
$email = $new_staff["email"];
$role = $new_staff["role"];
$current_salary = $new_staff["current_salary"];

$staff_name = mysqli_real_escape_string($dbConn, $staff_name);
$phone_number = mysqli_real_escape_string($dbConn, $phone_number);
$contact_adress = mysqli_real_escape_string($dbConn, $contact_adress);
$email = mysqli_real_escape_string($dbConn, $email);
$role = mysqli_real_escape_string($dbConn, $role);

$staff = mysqli_real_escape_string($dbConn, $staff);
$msg_response=["OUTPUT", "NOTHING HAPPENED"];

if ($staff_name == "" || $department == "") {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "THE FIELDS 'staff_name', 'department', ARE ALL COMPULSORY";
	$response_message = json_encode($msg_response);
	die($response_message);
}

$add_staff_query = "INSERT INTO admin_staff (staff_id, staff_name, department, password) VALUES ('$staff_name', '$staff', '$department', '$hashedPassword')";

$add_staff_result = mysqli_query($dbConn, $add_staff_query);

if($add_staff_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY ADDED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>