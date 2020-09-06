<?php 
session_start();
require_once "pdo.php";
if ( isset($_POST['cancel'] ) ) 
{ 
  header("Location: index.php");
  return; 
}

 
if ( isset($_POST['username']) && isset($_POST['pass']) ) 
{  unset($_SESSION["username"]); 
  if ( strlen($_POST['username']) < 1 || strlen($_POST['pass']) < 1 ) 
   { $_SESSION['error'] = "Username and password are required";
   } 
  else 
   {  $count = false;
      $var_name = $_POST['username'];
      $id = $_POST['pass']; 
      $stmt = $pdo->query("SELECT log_in.username, log_in.password, users.user FROM log_in JOIN users ON log_in.user_id = users.user_id");
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ( $rows as $row )
      {  if ( ($row['username'] === $var_name) && ($row['password'] == $id) )  
        { error_log("Login success ".$_POST['username']);
          $count = 1;
          $_SESSION['name'] = $_POST['username'];
          $_SESSION["success"] = "Logged in";
          $_SESSION['user'] = $row['user'];
          header("Location: home.php");
          return; 
        }   
      }
      if( $count == false)        
      { error_log("Login fail ".$_POST['username']." $check");
        $_SESSION['error'] = "Incorrect username or password";
      }
    }   
 header("Location: login.php");
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
<h1>Please Log In :</h1>
<?php
if ( isset($_SESSION['error']) ) 
{
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
?>
<form method="POST">
<label for="username">Username</label>
<input type="text" name="username" id="username"><br/>
<label for="pass">Password</label>
<input type="password" name="pass" id="pass"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>