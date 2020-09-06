<?php
session_start();
if ( ! isset($_SESSION['name']) ) 
{
  die('Not logged in');
}
if ( isset($_POST['Cancel'] ) ) 
{ 
  header("Location: home.php");
  return; 
}
require_once "pdo.php";
if ( isset($_POST['id_no']) && isset($_POST['user']) && isset($_POST['date']) && isset($_POST['return_date']) ) 
{  unset($_SESSION['id_no']);
   if( (strlen($_POST['id_no']) < 1) || (strlen($_POST['user']) < 1) )
   {
    $_SESSION['error'] = "*All fields are mendatory";
   }
   else
   { $id_no = $_POST['id_no'];
     $sql = "INSERT INTO issued ( issue_date, return_date, book_id, user_id) VALUES (:issue, :return, :book_id, :user_id)";
     $stmt = $pdo->prepare($sql);
     $stmt->execute(array(
      ':issue' => $_POST['date'],
      ':return' => $_POST['return_date'],
      ':book_id' => $_POST['id_no'],
      ':user_id' => $_POST['user'] ));  
     $sql = "UPDATE books SET status = 0 WHERE book_id = $id_no";
     $stmt = $pdo->exec($sql);
     $_SESSION['user_id'] = $_POST['user'];
     $_SESSION['success'] = "Book issued successfully";
     header("Location: home.php");
     return; 
   }
 header("Location: issue.php");
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
<h1>New Book Issue :</h1>
<?php 
if ( isset($_SESSION['error']) ) 
{
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
?>
<form method="POST">
<p>Book ID:
<input type="text" name="id_no" size="60"/></p>
<p>User ID:
<input type="text" name="user" size="60"/></p>
<p>Issue Date:
<input type="text" name="date" size="60"/></p>
<p>Return Date:
<input type="text" name="return_date" size="60"/></p>
<input type="submit" name="Submit" value="Submit">
<input type="submit" name="Cancel" value="Cancel">
</form>
</div>
</body>
</html>