<?php
include_once 'loginDatabaseIxD4.php';
$result = mysqli_query($conn,"SELECT * FROM Devices");
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="IxD4styleSheet.css">
<title>Delete employee data</title>
</head>
<body>
<form>
<table>
<tr>
<td>Temp Settings</td>

<td>Action</td>
</tr>
<?php
$i=0;
while($row = mysqli_fetch_array($result)) {
if($i%2==0)
$classname="even";
else
$classname="odd";
?>
<tr class="<?php if(isset($classname)) echo $classname;?>">

<td><?php echo $row["AverageTemp"]; ?></td>

<td><a href="updateUserSettingsIxD4.php?id=<?php echo $row["id"]; ?>">Update</a></td>
</tr>
<?php
$i++;
}
?>
</table>
</form>
</body>
</html>
