<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

  $get_rooms_sql = "SELECT * FROM frontdesk_rooms";
  $get_rooms_result = mysqli_query($dbConn, $get_rooms_sql);
  $get_rooms_array = [];

  function get_all_frontdesk_rooms($rooms_result, $rooms_array, $connDB) {
    $rooms_array = [];

    if (mysqli_num_rows($rooms_result) > 0){
 	  while($rows = mysqli_fetch_assoc($rooms_result)) {
      $room_id = $rows["room_id"];
      $reservation_query = "SELECT * FROM frontdesk_reservations WHERE room_id = '$room_id' ORDER BY reserved_date";
      $get_reservations_result = mysqli_query($connDB, $reservation_query);
      if (mysqli_num_rows($get_reservations_result) > 0) {
        $reservations_rows = [];
        while ($rows_reservations = mysqli_fetch_assoc($get_reservations_result)) {
           $reservations_rows[] = $rows_reservations;
         }
         $rows["reservations"] = $reservations_rows;
      }
      $rooms_array[] = $rows;
 	  }
 	  return $rooms_array;
    }
  }

  function select_available_rooms($get_rooms_result, $get_rooms_array, $dbConn){
    $frontdesk_rooms = get_all_frontdesk_rooms($get_rooms_result, $get_rooms_array, $dbConn);
    $start_date = $_POST['startDate'];
    $end_date = $_POST['endDate'];
    $available_rooms = [];
    //print_r($frontdesk_rooms);
    
    foreach($frontdesk_rooms as $room){
      if(
        ($room['booked'] == 'YES') && 
        !(strtotime($start_date) > strtotime($room['booking_expires']) && strtotime($end_date) > strtotime($room['booking_expires']))
        )  {
          continue;
        }else{

          if(!isset($room['reservations'])) {
            if(!isset($available_rooms[$room['room_category']]))
            $available_rooms[$room['room_category']] = ['rooms' => [], 'category' => $room['room_category'] ];
            $room['no_of_nights'] = intval($_POST['nights']);
            array_push($available_rooms[$room['room_category']]['rooms'], $room);
            continue;
          }
          foreach($room['reservations'] as $resvtn){
            $start_reserved_date = $resvtn['reserved_date'];
            $enddate = date_create($resvtn['reserved_date']);
            date_add(
               $enddate , date_interval_create_from_date_string($resvtn['no_of_nights'] . ' days')
            );
            $end_reserved_date = date_format($enddate, 'Y-m-d');
            if(
              (strtotime($start_date) < strtotime($start_reserved_date) && strtotime($end_date) < strtotime($start_reserved_date)) || 
              (strtotime($start_date) > strtotime($end_reserved_date) && strtotime($end_date) > strtotime($end_reserved_date))
              ) {
                
                //array_push($available_rooms, [$start_date, $end_date, $start_reserved_date, $end_reserved_date]);
                if(!isset($available_rooms[$room['room_category']]))
                $available_rooms[$room['room_category']] = ['rooms' => [], 'category' => $room['room_category'] ];
                $room['no_of_nights'] = intval($_POST['nights']);
                array_push($available_rooms[$room['room_category']]['rooms'], $room);
              }  
          }

        }
    }
    $get_rooms_json = json_encode($available_rooms);
    return $get_rooms_json;
  }
  $frontdesk_rooms = select_available_rooms($get_rooms_result, $get_rooms_array, $dbConn);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $frontdesk_rooms;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>