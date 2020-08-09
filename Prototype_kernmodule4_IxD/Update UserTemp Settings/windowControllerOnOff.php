<?php
include_once 'loginDatabaseIxD4.php';
if(count($_POST)>0) {
$postWindowOnOff = mysqli_query($conn,"UPDATE WindowController set ControllerMode='" . $_POST['ControllerMode'] . "' WHERE Device_code='" . $_POST['Device_code'] . "'");
}

$resultWindow = mysqli_query($conn,"SELECT * FROM WindowController WHERE Device_code='1111'");
$roww= mysqli_fetch_array($resultWindow);

// Query current WindowControl position + Join
$currentControl = mysqli_query($conn,"SELECT WindowController.ControllerMode, WindowController.Pos,  ControlStatus.ControlPos FROM WindowController JOIN ControlStatus ON WindowController.ControllerMode = ControlStatus.Control_id");

    

?>
<html>
<link rel="stylesheet" href="IxD4styleSheet.css">
<head>
<title>Update Average temp</title>
</head>
<body>
<?php
//echo huidige temp //
while($currentcontrol = mysqli_fetch_array($currentControl)) {
?>
<h3> Window Control set to: <?php echo $currentcontrol["ControlPos"]; ?></h3>
<h3> The window is <?php echo $currentcontrol["Pos"]; ?>&deg; opened </h3>
<?php
}
?>
<form name="frmUser" method="post" action="">


<div class="WindowButtons">
<td>Choose window control mode</td>
<button type="submit" name="ControllerMode" <?php if (isset($ControllerMode) && $ControllerMode=="0") echo "checked";?> value="0">Set window to Automatic Mode
<button type="submit" name="ControllerMode" <?php if (isset($ControllerMode) && $ControllerMode=="1") echo "checked";?> value="1">Set window to Manual Mode
<button type="submit" name="ControllerMode" <?php if (isset($ControllerMode) && $ControllerMode=="2") echo "checked";?> value="2">Set window to Night Mode
<input type="hidden" name="Device_code" class="txtField" value="<?php echo $roww['Device_code']; ?>">
<input type="hidden" name="id" class="txtField" value="<?php echo $roww['id']; ?>">



</div>
</form>
<br>

<form name="frmUser" method="post" action="windowController.php">

<div class="ManualControl">
<td> Set window position to: </td>
<td><button name="Pos" type="submit" value="0">Close</button>
<button name="Pos" type="submit" value="90">Half Open</button>
<button name="Pos" type="submit" value="180">Open</button>

<input type="hidden" name="Device_code" class="txtField" value="<?php echo $roww['Device_code']; ?>">
<input type="hidden" name="id" class="txtField" value="<?php echo $roww['id']; ?>">
</td>
</form>
</div>
<br>
<a href="https://studenthome.hku.nl/~rosalie.kross/homeScreenIxD4.php">Back</a>
</body>
</html>
