<?php
session_start();
include "loginDatabaseIxD4.php";
if (isset($_SESSION['idd']) && isset($_SESSION['user_name'])) {
if(isset($_POST['save']))
{
     $Device_name = $_POST['Device_name'];
     $Device_code = $_POST['Device_code'];
     $AverageTemp = $_POST['AverageTemp'];
     $User_id = $_POST['User_id'];
    
    
     $sql = "INSERT INTO Devices (Device_name,Device_code, AverageTemp, User_id) VALUES ('$Device_name','$Device_code','$AverageTemp','$User_id')";
    
    
    $query=mysqli_query($conn, $sql) or die (mysqli_error($conn));
    
    
    if ($query==1) {
        header('Location: https://studenthome.hku.nl/~rosalie.kross/deviceOverviewPageIxD4.php');
         
         //$add = "INSERT INTO UserSettings (Device_code,AverageTemp) VALUES ('$Device_code','$AverageTemp')";
         
//         $quey=mysqli_query($conn, $add) or die(mysqli_error($conn));
//            if($quey==1)
//                {
//                    header('Location: https://studenthome.hku.nl/~rosalie.kross/deviceOverviewPageIxD4.php');
//                }
                                                
                            
        } else {
        echo "Error: " . $sql . " " . mysqli_error($conn);
     }
    
    mysqli_close($conn);
    
}
}
  
?>
