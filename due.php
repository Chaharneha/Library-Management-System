<?php
session_start();
if ( ! isset($_SESSION['name']) ) 
{
  die('Not logged in');
}
require_once "pdo.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Neha Chahar's library management system</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Overdue books :</h1>
<?php
$stmt = $pdo->query("SELECT issue_id, return_date, book_id, user_id FROM issued");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ( $rows as $row ) 
{ $d1 = strtotime($row['return_date']);
  $d2 = strtotime(date(DATE_ATOM));
  $diff = abs($d2-$d1);
  $y = floor($diff/(365*60*60*24));
  $m = floor(($diff - $y*365*60*60*24)/(30*60*60*24));
  $d = floor(($diff - $y*365*60*60*24 - $m*30*60*60*24)/(60*60*24));
  if( $d > 14)
  { echo '<table border="1" width="600" height="80">'."\n";
    echo "<tr><td width=25% height=20><b>";
    echo(" Student Name");
    echo("</td><td width=40% height=20><b>");
    echo(" Book");
    echo("</td><td width=40% height=20><b>");
    echo(" Days");
    echo("</td><td width=40% height=20><b>");
    echo(" Penalty");
    echo("</td></tr>");
    echo("\n");
    $id_no = $row['issue_id'];
    $p = ($d-14)*2;
    $sql = "UPDATE issued SET penalty = $p WHERE issue_id = $id_no";
    $stmt = $pdo->exec($sql); 
    $b = $row['book_id'];
    $u = $row['user_id'];
  $stmt = $pdo->query("SELECT first, last, user_id FROM users");
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo "<tr><td width=25% height=30>";
  foreach ( $rows as $row ) 
  { if($row['user_id']===$u)
    { echo(htmlentities($row['first']." ".$row['last']));
    }
  }
  echo "</td>";
  $stmt = $pdo->query("SELECT name, author FROM books WHERE book_id = $b");
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo "<td width=25% height=30>";
  foreach ( $rows as $row ) 
  { echo(htmlentities($row['name']));
    echo(" By ");
    echo(htmlentities($row['author']));
    echo("   ");
  }
   echo "</td>";
   echo "<td width=25% height=30>";
   echo($d);
   echo "</td>";
   echo "<td width=25% height=30>";
   echo($p);
   echo("Rs");
   echo "</td></tr>";
  }
}
?>
<p>
<a href="home.php">Home</a> 
</p>
</div>
</body>
</html>