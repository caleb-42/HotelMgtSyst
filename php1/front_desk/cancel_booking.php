<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

    $guest = $_POST['guest'];



/* start get booking */
$query = "SELECT * FROM frontdesk_bookings WHERE guest_id = '$guest' AND checked_out = 'NO'";
$result = mysqli_query($dbConn, $query);
$arr = [];
if (mysqli_num_rows($result) > 0){
    while($rows = mysqli_fetch_assoc($result)) {
        $arr[] = $rows;
        cancel($rows['booking_ref'], $guest, $dbConn);
    }
}

$room_booking = $arr;
print_r($arr);
/* end get booking */
function cancel($booking, $guest, $dbConn){
    //echo $booking;
    $count_booking_query = "SELECT COUNT(*) as num FROM frontdesk_bookings WHERE booking_ref = '$booking' AND checked_out = 'NO'";
    $count_booking_result = mysqli_query($dbConn, $count_booking_query);

    $count_booking_row = mysqli_fetch_array($count_booking_result);
    $count_booking = intval($count_booking_row["num"]);

    print_r($count_booking);

    $frontdesk_booking_query = "DELETE FROM `frontdesk_bookings` WHERE booking_ref = '$booking'";

    $booking_cmd = mysqli_query($dbConn, $frontdesk_booking_query);

    $frontdesk_guests_query = "SELECT * FROM frontdesk_guests WHERE guest_id = '$guest'";
    $frontdesk_guests_result = mysqli_query($dbConn, $frontdesk_guests_query);

    $frontdesk_guests_details = mysqli_fetch_assoc($frontdesk_guests_result);

    print_r($frontdesk_guests_details['visit_count']);

    if(intval($frontdesk_guests_details['visit_count']) > 0){
        $frontdesk_guests_query = "UPDATE `frontdesk_guests` SET total_rooms_booked = total_rooms_booked - $count_booking, checked_in = 'NO', check_in_date = '0000-00-00', room_outstanding = 0, restaurant_outstanding = 0, checked_out = 'YES', visit_count = visit_count - 1 WHERE guest_id = '$guest'";
    }else{
        $frontdesk_guests_query = "DELETE FROM `frontdesk_guests` WHERE guest_id = '$guest'";
    }

    $frontdesk_guests_result = mysqli_query($dbConn, $frontdesk_guests_query);


    $frontdesk_guests_query = "SELECT * FROM frontdesk_reservations WHERE booking_ref = '$booking'";
    $frontdesk_guests_result = mysqli_query($dbConn, $frontdesk_guests_query);

    $frontdesk_guests_details = mysqli_fetch_assoc($frontdesk_guests_result);

    $resvtn_ref = $frontdesk_guests_details['reservation_ref'];


    $frontdesk_payment_query = "DELETE FROM `frontdesk_payments` WHERE frontdesk_txn = '$booking' OR frontdesk_txn = '$resvtn_ref'";

    $payment_cmd = mysqli_query($dbConn, $frontdesk_payment_query);




    $frontdesk_resvtn_query = "DELETE FROM `frontdesk_reservations` WHERE booking_ref = '$booking'";

    $resvtn_cmd = mysqli_query($dbConn, $frontdesk_resvtn_query);


    $frontdesk_resvtn_query = "DELETE FROM `frontdesk_reservation_txn` WHERE reservation_ref = '$resvtn_ref'";

    $resvtn_cmd = mysqli_query($dbConn, $frontdesk_resvtn_query);



    $frontdesk_room_query = "SELECT * FROM frontdesk_rooms WHERE booking_ref = '$booking'";
    $frontdesk_room_result = mysqli_query($dbConn, $frontdesk_room_query);

    if (mysqli_num_rows($frontdesk_room_result) > 0) {
        
        while ($rows = mysqli_fetch_assoc($frontdesk_room_result)) {
            $id = $rows['id'];
            $frontdesk_guests_query = "UPDATE `frontdesk_rooms` SET current_guest_id = '',booking_ref = '', booked = 'NO', guests = 0, booked_on = '0000-00-00', booking_expires = '0000-00-00' WHERE id = '$id'";

            $frontdesk_guests_result = mysqli_query($dbConn, $frontdesk_guests_query);
        }
    }



    $frontdesk_txn_query = "DELETE FROM `frontdesk_txn` WHERE booking_ref = '$booking'";

    $booking_cmd = mysqli_query($dbConn, $frontdesk_txn_query);
}
    

?>