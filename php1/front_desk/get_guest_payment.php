<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

    if(isset($_POST['booking']) && isset($_POST['guest'])){
      $booking_ref = $_POST['booking'];
      $guest_id = $_POST['guest'];
      $last_payment_id_query = "SELECT MAX(id) AS id FROM frontdesk_payments WHERE frontdesk_txn = '$booking_ref'";
      $last_payment_id_result = mysqli_query($dbConn, $last_payment_id_query);

      $payment_id_row = mysqli_fetch_array($last_payment_id_result);
      $payment_id = intval($payment_id_row["id"]);
  
      $last_payment = "SELECT * FROM frontdesk_payments WHERE id = $payment_id";
      $last_payment_result = mysqli_query($dbConn, $last_payment);
    
      $last_payment_details = mysqli_fetch_assoc($last_payment_result);
      //print_r($last_payment_details);

      $get_guest_sql = "SELECT * FROM frontdesk_guests WHERE checked_in = 'YES' AND guest_id = '$guest_id'";
      $guest_result = mysqli_query($dbConn, $get_guest_sql);
    
      $guest_details = mysqli_fetch_assoc($guest_result);


      $available_room = ['payment' => $last_payment_details , 'guest'=> $guest_details];
      echo json_encode($available_room);
      //exit;
    }

?>