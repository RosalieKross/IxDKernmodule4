<?php
session_start();
include_once 'loginDatabaseIxD4.php';
    
if (isset($_SESSION['idd']) && isset($_SESSION['user_name'])) {
    
    //Query die de User tabel en de Devices tabel aan elkaar joint
    $sql = "SELECT Devices.Device_code, Devices.Device_name, Devices.AverageTemp, Devices.NightTemp, Users.name FROM Devices JOIN Users ON Devices.User_id = Users.idd WHERE Users.idd ='" . $_SESSION['idd'] . "'";
    $getInfo= mysqli_query($conn, $sql);
    
    //Query die De AverageUserTemp weergeeft
    $results = mysqli_query($conn,"SELECT Devices.id, Device_name, AverageTemp FROM Devices WHERE User_id ='" . $_SESSION['idd'] . "'");
    
    $resultsNight = mysqli_query($conn,"SELECT Devices.id, Device_name, NightTemp FROM Devices WHERE User_id ='" . $_SESSION['idd'] . "'");
    
    
    
    //Query Manual/Automatic window control
    $currentControl = mysqli_query($conn,"SELECT WindowController.ControllerMode, WindowController.Pos,  ControlStatus.ControlPos FROM WindowController JOIN ControlStatus ON WindowController.ControllerMode = ControlStatus.Control_id");
    
    // Query die Huidige gemeten temp toont
    $current = mysqli_query($conn,"SELECT temp FROM SensorData WHERE id = (SELECT MAX(id) FROM SensorData)");
    
    //Query die readings uit de Sensor data haalt
    $dataReadings = "SELECT temp, reading_time FROM SensorData WHERE deviceCode='1111' order by reading_time desc limit 200";
    
    
    $result = $conn->query($dataReadings);

    while ($data = $result->fetch_assoc()){
        $sensor_data[] = $data;
    }

    $readings_time = array_column($sensor_data, 'reading_time');


    $value1 = json_encode(array_reverse(array_column($sensor_data, 'temp')), JSON_NUMERIC_CHECK);


    $reading_time = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);


    $result->free();
    $conn->close();
   
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>HOME</title>
    <link rel="stylesheet" type="text/css" href="IxD4styleSheet.css">
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>
<br>
<h1>Welcome back <?php echo $_SESSION['name']; ?></h1>
<br>
<div class="CurrentTemp">
<?php
//echo huidige temp //
while($currentTemp = mysqli_fetch_array($current)) {
?>
<h3> Current temp: <?php echo $currentTemp["temp"]; ?> &deg;C</h3>
<?php
}
?>

</div>


<div id="chart-temperature" class="container"></div>
<div class="grafiek">
<script>

var value1 = <?php echo $value1; ?>;

var reading_time = <?php echo $reading_time; ?>;

var chartT = new Highcharts.Chart({
  chart:{ renderTo : 'chart-temperature' },
  title: { text: 'Current temperature readings' },
  series: [{
    showInLegend: false,
    data: value1
  }],
  plotOptions: {
    line: { animation: true,
      dataLabels: { enabled: true }
    },
    series: { color: '#e6be6e' }
  },
  xAxis: {
    type: 'datetime',
    categories: reading_time
  },
  yAxis: {
    title: { text: 'Temperature (Celsius)' }
    
  },
  credits: { enabled: false }
});
</script>
</div>
<br>
<br>
<br>
</div>

<br>

<div class="displayDevices">
<form>
<h4> Overview Devices </h4>

<table>
<tr>
<td>User Name </td>
<td>Devices Code </td>
<td>Devices Name </td>
<td>Prefered </td>
<td>NightModeTemp </td>
</tr>
<?php
$i=0;
//echo huidige devices //
while($displayDevices = mysqli_fetch_array($getInfo)) {

if($i%2==0)
$classname="even";
else
$classname="odd";
?>
<tr class="<?php if(isset($classname)) echo $classname;?>">

<td><?php echo $displayDevices["name"]; ?></td>
<td><?php echo $displayDevices["Device_code"]; ?></td>
<td><?php echo $displayDevices["Device_name"]; ?></td>
<td><?php echo $displayDevices["AverageTemp"]; ?>&deg;C</td>
<td><?php echo $displayDevices["NightTemp"]; ?>&deg;C</td>
</tr>
<?php
$i++;
}
?>

</table>
</form>
</div>
<br>
<a href="deviceOverviewPageIxD4.php">Edit Device</a>
<br>
<br>

<div class="WindowControler">
<form>
<?php
    while($windowControl = mysqli_fetch_array($currentControl)) {
    ?>
    <td> Window Control is set to: <?php echo $windowControl["ControlPos"]; ?></td>
    <td><a class="button" href="windowControllerOnOff.php">Control Window</a></td>
    <?php
    }
    ?>

    


</form>
</div>

<br>

<div class="updateNightTemp">
<form>
<h3>Set desired NightMode temperature </h3>
<h4>Note that the best sleeping temperature is around 18 &deg;C</h4>

<table>
<tr>
<td>Room Name</td>
<td>NightMode Temp</td>

</tr>
<?php
$i=0;
while($displayNightTemp = mysqli_fetch_array($resultsNight)) {
if($i%2==0)
$classname="even";
else
$classname="odd";
?>
<tr class="<?php if(isset($classname)) echo $classname;?>">

<td><?php echo $displayNightTemp["Device_name"]; ?></td>
<td><?php echo $displayNightTemp["NightTemp"]; ?>&deg;C</td>

<td><a href="updateNightModeIxD4.php?id=<?php echo $displayNightTemp["id"]; ?>">Update</a></td>
</tr>
<?php
$i++;
}
?>

</table>
</form>
</div>

<br>

<div class="updateAverage">
<form>
<h3>Set desired average room temperature </h3>

<table>
<tr>
<td>Room Name</td>
<td>Temp Settings</td>

</tr>
<?php
$i=0;
while($displayAverage = mysqli_fetch_array($results)) {
if($i%2==0)
$classname="even";
else
$classname="odd";
?>
<tr class="<?php if(isset($classname)) echo $classname;?>">

<td><?php echo $displayAverage["Device_name"]; ?></td>
<td><?php echo $displayAverage["AverageTemp"]; ?>&deg;C</td>

<td><a href="updateUserSettingsIxD4.php?id=<?php echo $displayAverage["id"]; ?>">Update</a></td>
</tr>
<?php
$i++;
}
?>

</table>
</form>
</div>
<br>

<a href="loginPageIxD4.php">Logout</a>
</body>
</html>

<?php
}else{
     header("Location: loginPageIxD4.php");
     exit();
}
 ?>
