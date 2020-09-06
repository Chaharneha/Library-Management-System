<?php
session_start();
require_once "pdo.php";

if ( isset($_POST['username']) && isset($_POST['login_password'])) 
{  if( (strlen($_POST['username']) < 1) )
   {
    $_SESSION['error'] = "*Username is required";
   }
   else{
     if( (strlen($_POST['login_password']) < 8) ) 
     { 
      $_SESSION['error'] = "Password must be 8 characters long!";
     }     
     else
     {  $ID = $_SESSION['id'];
        $sql = "INSERT INTO log_in (username, password, user_id) VALUES (:username, :login_password, :user_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
         ':username' => $_POST['username'],
         ':login_password' => $_POST['login_password'],
         ':user_id' => $ID));     
         $_SESSION['success'] = "Registration successfull";
         header("Location: home.php");
         return; 
     } 
  }
 header("Location: id_set.php");
 return; 
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Neha Chahar's library management system</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Register New Student :</h1>
<?php 
if ( isset($_SESSION['error']) ) 
{
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
?>
<form method="POST">
<p>Username:
<input type="text" name="username" size="60"/></p>
<p>Password:
<input type="password" name="login_password" size="60"/></p>
<P><input type="submit" name="Register" value="Register"></p>
</form>
</div>
</body>
</html>