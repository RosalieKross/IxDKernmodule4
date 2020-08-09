<?php
session_start();
include_once 'loginDatabaseIxD4.php';
    
    
    
$result = mysqli_query($conn,"SELECT AverageTemp FROM Devices WHERE Device_code='". $_GET['Device_code'] . "'");

    $row= mysqli_fetch_array($result);
    
    echo $row["AverageTemp"];


?>

