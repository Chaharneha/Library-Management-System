<?php
session_start();
require_once "pdo.php";
if ( ! isset($_SESSION['name']) ) 
{
    die('Not logged in');
}
if ( isset($_POST['logout']) ) 
{
    header('Location: logout.php');
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
<h1>User :
<?php
if ( isset($_SESSION['name']) ) 
{
    echo htmlentities($_SESSION['name']);
}
?>
</h1>
<?php
if ( isset($_SESSION['error']) ) 
{
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) 
{
  echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
  unset($_SESSION['success']);
}
if ( isset($_SESSION['user']) ) 
{  if( $_SESSION['user'] == 'ADMIN')
  { echo"<ul>";
    echo'<li><p><a href="Registration.php">New Student Registration</a></p></li>';
    echo'<li><p><a href="issue.php">Issue New Book</a></p></li>';
    echo'<li><p><a href="add.php">Add New Book</a></p></li>';
    echo'<li><p><a href="booked.php">Issued Books</a></p></li>';
    echo'<li><p><a href="due.php">Due Books</a></p></li>';
    echo'<li><p><a href="view.php">Available Books</a></p></li>';
    echo'<li><p><a href="logout.php">Log Out</a></p></li>';
    echo"</ul>";
  }
  else
  { echo"<ul>";
    echo'<li><p><a href="view.php">Available Books</a></p></li>';
    echo'<li><p><a href="logout.php">Log Out</a></p></li>';
    echo"</ul>";
  }
}
?>
</div>
</body>
</html>