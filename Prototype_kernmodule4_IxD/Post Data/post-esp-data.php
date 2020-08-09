<?php
    session_start();
    include "loginDatabaseIxD4.php";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page.
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $sensor = $temp = $humidity = $windowPos = $deviceCode = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $api_key = test_input($_GET["api_key"]);
    if($api_key == $api_key_value) {
        $sensor = test_input($_GET["sensor"]);
        $temp = test_input($_GET["temp"]);
        $humidity = test_input($_GET["humidity"]);
        $windowPos = test_input($_GET["windowPos"]);
        $deviceCode = test_input($_GET["deviceCode"]);
        
        
        $sql = "INSERT INTO SensorData (sensor, temp, humidity, windowPos, deviceCode)
        VALUES ('" . $sensor . "', '" . $temp . "', '" . $humidity . "', '" . $windowPos . "', '" . $deviceCode ."')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        }
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
