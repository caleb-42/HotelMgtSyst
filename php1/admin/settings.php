<?php
  include "../settings/connect.php"; //$database handler $dbConn or $conn
  $settings_data = $_POST["settings_data"];
  $msg_response=["OUTPUT", "NOTHING HAPPENED"];

  //$settings_data = '{"shop_address":"44 Akhiobare Street", "shop_name": "Webplay Nigeria Ltd", "shop_contact":"08091953375, info@webplaynigeria.net"}';
  $settings_data = json_decode($_POST["settings_data"], true);

  $update_settings_query = $conn->prepare("UPDATE admin_settings SET property_value = ? WHERE shop_settings = ?");
  $update_settings_query->bind_param("ss", $property_setting, $key_setting);
  $updated = [];

  foreach ($settings_data as $settings_key => $settings_value) {
  	$property_setting = $settings_value;
  	$key_setting = $settings_key;
 	$update_settings_query->execute();
 	$updated[] = $settings_key;
  }

  $update_settings_query->close();
  $updated_settings = json_encode($updated);

  if ($conn->error) {
  	$msg_response=["ERROR", "SOMETHING WENT WRONG"];
    $response_message = json_encode($msg_response);
    die($response_message);
  }

$msg_response=["OUTPUT", "SUCCESSFUL"];
$response_message = json_encode($msg_response);
echo $response_message;

?>