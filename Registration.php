<?php
session_start();
if ( isset($_POST['Cancel'] ) ) 
{ 
  header("Location: home.php");
  return; 
}
require_once "pdo.php";
if ( isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['gender']) && isset($_POST['phone']) ) 
{  if( (strlen($_POST['name']) < 1) || (strlen($_POST['surname']) < 1) || (strlen($_POST['gender']) < 1) || (strlen($_POST['phone']) < 1) )
   {
    $_SESSION['error'] = "*All fields are mendatory";
   }
   else{
     if( is_numeric($_POST['phone']) ) 
     { $ID_no = substr($_POST['name'],0,2).substr($_POST['surname'],0,2).substr($_POST['phone'],-9,4);
       $sql = "INSERT INTO users ( first, last, gender, phone, user_id) VALUES (:name, :surname, :gender, :phone, :user_id)";
       $stmt = $pdo->prepare($sql);
       $stmt->execute(array(
        ':name' => $_POST['name'],
        ':surname' => $_POST['surname'],
        ':gender' => $_POST['gender'],
        ':phone' => $_POST['phone'],
        ':user_id' => $ID_no));     
        $_SESSION['success'] = "Registration successfull";
        $_SESSION['id'] = $ID_no;
        header("Location: id_set.php");
        return; 
      }     
     else
     {
        $_SESSION['error'] = "Invalid phone number";
     } 
  }
 header("Location: Registration.php");
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
<p>Name:
<input type="text" name="name" size="60"/></p>
<p>Surname:
<input type="text" name="surname" size="60"/></p>
<p>Gender:
<select name="gender" id="gender">
  <option value="Select">- select -</option>
  <option value="Male">Male</option>
  <option value="Female">Female</option>
  <option value="Transgender">Transgender</option>
  <option value="Other">Other</option>
</select></p>
<p>Phone:
<input type="text" name="phone"/></p>
<input type="submit" name="Submit" value="Submit">
<input type="submit" name="Cancel" value="Cancel">
</form>
</div>
</body>
</html>