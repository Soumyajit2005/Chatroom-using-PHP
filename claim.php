<?php

// Getting the value of post parameter
$room = $_POST['room'];

// Checking for string size 
if (strlen($room) > 20 or strlen($room) < 2) {
    $message = "Please chose a name between 2 or 20 characters";
    echo "<script language='javascript'>";
    echo "alert('$message');";
    echo "window.location='http://localhost/chatroom';";
    echo "</script>";

}
// Checking whether room name is alpha numeric
else if (!ctype_alnum($room)) {
    $message = "Please chose an alphanumeric room name";
    echo "<script language='javascript'>";
    echo "alert('$message');";
    echo "window.location='http://localhost/chatroom';";
    echo "</script>";
} else {
    // Connect to the database
    include "db_connect.php";
}

// Check if room already exists

$sql = "SELECT * FROM `rooms` WHERE roomname = '$room'";
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $message = "Please chose a different room name. This room name already exists";
        echo "<script language='javascript'>";
        echo "alert('$message');";
        echo "window.location='http://localhost/chatroom';";
        echo "</script>";
    } else {
        $sql = "INSERT INTO `rooms` (`roomname`, `stime`) VALUES ('$room', current_timestamp());";
        if (mysqli_query($conn, $sql)) {
            $message = "Your room is ready and you are ready to chat now";
            echo "<script language='javascript'>";
            echo "alert('$message');";
            echo 'window.location="http://localhost/chatroom/rooms.php?roomname=' . $room . '";';
            echo "</script>";
        }
    }
}
else{
    echo "Error: " . mysqli_error($conn);
}

?>