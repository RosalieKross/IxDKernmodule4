<!DOCTYPE html>
<html><body>
<?php


$servername = "localhost";

// REPLACE with your Database name
$dbname = "rosaliekross";
// REPLACE with Database user
$username = "rosaliekross";
// REPLACE with Database user password
$password = "iexee4Choh";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, sensor, location, value1, value2, value3, reading_time FROM SensorData ORDER BY id DESC";

echo '<table cellspacing="5" cellpadding="5">
      <tr>
        <td>ID</td>
        <td>Sensor Name</td>
        <td>Location</td>
        <td>Temperature °C</td>
        <td>Humidity</td>
        <td>Window Position</td>
        <td>Timestamp</td>
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_sensor = $row["sensor"];
        $row_location = $row["location"];
        $row_value1 = $row["value1"];
        $row_value2 = $row["value2"];
        $row_value3 = $row["value3"];
        $row_reading_time = $row["reading_time"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '<tr>
                <td>' . $row_id . '</td>
                <td>' . $row_sensor . '</td>
                <td>' . $row_location . '</td>
                <td>' . $row_value1 . '</td>
                <td>' . $row_value2 . '</td>
                <td>' . $row_value3 . '</td>
                <td>' . $row_reading_time . '</td>
              </tr>';
    }
    $result->free();
}

$conn->close();
?>
</table>
</body>
</html>
