<?php
include_once 'loginDatabaseIxD4.php';

if(count($_POST)>0) {
mysqli_query($conn,"UPDATE WindowController set Device_code='" . $_POST['Device_code'] . "', Pos='" . $_POST['Pos'] . "' WHERE Device_code='" . $_POST['Device_code'] . "'");
$message1 = "The window is now closed";
}

$resultWindow = mysqli_query($conn,"SELECT * FROM WindowController WHERE id='1'");
$roww= mysqli_fetch_array($resultWindow);
    
header('Location: https://studenthome.hku.nl/~rosalie.kross/windowControllerOnOff.php');
    
?>



