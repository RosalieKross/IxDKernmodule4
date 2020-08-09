<?php
    session_start();
    include_once 'loginDatabaseIxD4.php';
if (isset($_SESSION['idd']) && isset($_SESSION['user_name'])) {
$sql = "DELETE FROM Devices WHERE id='" . $_GET['id'] . "'";
if (mysqli_query($conn, $sql)) {
    header('Location: https://studenthome.hku.nl/~rosalie.kross/deviceOverviewPageIxD4.php');
    //echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

    
mysqli_close($conn);
}
?>
