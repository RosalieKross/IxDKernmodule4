<?php
session_start();
include 'loginDatabaseIxD4.php';

if (isset($_SESSION['idd']) && isset($_SESSION['user_name'])) {
    $sql = "SELECT Devices.id, Devices.Device_code, Devices.Device_name, Devices.User_id FROM Devices WHERE User_id ='" . $_SESSION['idd'] . "'";
    $result= mysqli_query($conn, $sql);
    
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="IxD4styleSheet.css">
<title>Overview Devices</title>
</head>
<body>

<h1>Overview Devices</h1>
<form>
<table>
    <tr>
    <td>Device Name</td>
    <td>Device Code</td>
    </tr>
    <?php
    $i=0;
    while($row = mysqli_fetch_array($result)) {
    ?>
    <tr class="<?php if(isset($classname)) echo $classname;?>">
    <td><?php echo $row["Device_name"]; ?></td>
    <td><?php echo $row["Device_code"]; ?></td>
    <td><a href="deleteDevicesIxD4.php?id=<?php echo $row["id"]; ?>">Delete</a></td>
    </tr>
    <?php
    $i++;
    }
    ?>
</table>
</form>
<br>
    <a class="button" href="https://studenthome.hku.nl/~rosalie.kross/addDevicePageIxD4.php">Add Device</a>
<br>
    <a class="button" href="https://studenthome.hku.nl/~rosalie.kross/homeScreenIxD4.php">Main page</a>


</body>
</html>
    <?php
    }
     ?>
