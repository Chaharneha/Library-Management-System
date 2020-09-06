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
if ( isset($_POST['nam']) && isset($_POST['author']) && isset($_POST['price']) ) 
{  if( (strlen($_POST['nam']) < 1) || (strlen($_POST['author']) < 1) || (strlen($_POST['price']) < 1)  )
   {
    $_SESSION['error'] = "*All fields are mendatory";
   }
   else
   { $sql = "INSERT INTO books ( name, author, price) VALUES (:nam, :author, :price)";
     $stmt = $pdo->prepare($sql);
     $stmt->execute(array(
      ':nam' => $_POST['nam'],
      ':author' => $_POST['author'],
      ':price' => $_POST['price']));  
     $_SESSION['success'] = "Book added successfully";
     header("Location: home.php");
     return; 
   }
 header("Location: add.php");
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
<h1>Add New Book :</h1>
<?php 
if ( isset($_SESSION['error']) ) 
{
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
?>
<form method="POST">
<p>Title:
<input type="text" name="nam" size="60"/></p>
<p>Author:
<input type="text" name="author" size="60"/></p>
<p>Price:
<input type="text" name="price" size="60"/></p>
<input type="submit" name="Add" value="Add">
<input type="submit" name="Cancel" value="Cancel">
</form>
</div>
</body>
</html>