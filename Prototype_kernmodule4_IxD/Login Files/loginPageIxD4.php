<!DOCTYPE html>
<html>
<head>
    <title>LOGIN</title>
    <link rel="stylesheet" type="text/css" href="IxD4styleSheet.css">
</head>
<body>

  <br>
<br>
<br>
     <form action="loginIxD4.php" method="post">
         <h2>Login page</h2>
         <?php if (isset($_GET['error'])) { ?>
             <p class="error"><?php echo $_GET['error']; ?></p>
         <?php } ?>
         <label>User Name</label>
         <input type="text" name="user_name" placeholder="User Name"><br>

         <label>User Name</label>
         <input type="password" name="password" placeholder="Password"><br>

         <button type="submit">Login</button>
     </form>
</body>
</html>
