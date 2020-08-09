<?php
    
include_once 'loginDatabaseIxD4.php';
if(count($_POST)>0) {
mysqli_query($conn,"UPDATE Devices set AverageTemp='" . $_POST['AverageTemp'] . "' WHERE id='" . $_GET['id'] . "'");
$message = "Temperature has successfully been updated";
}
$result = mysqli_query($conn,"SELECT * FROM Devices WHERE id='" . $_GET['id'] . "'");
$row= mysqli_fetch_array($result);
?>
<html>
<link rel="stylesheet" href="IxD4styleSheet.css">
<head>
<title>Update Average temp</title>
</head>
<body>
<form name="frmUser" method="post" action="">
<div><?php if(isset($message)) { echo $message; } ?>
</div>

Prefered room Temperature: <br>
<input type="text" name="AverageTemp" class="txtField" value="<?php echo $row['AverageTemp']; ?>">


<input type="hidden" name="Device_code" class="txtField" value="<?php echo $row['Device_code']; ?>">

<input type="hidden" name="id" class="txtField" value="<?php echo $row['id']; ?>">


<br>
<input type="submit" name="submit" value="Submit">
<a class="buttom" href="https://studenthome.hku.nl/~rosalie.kross/homeScreenIxD4.php">Back</a>

</form>
</body>
</html>
