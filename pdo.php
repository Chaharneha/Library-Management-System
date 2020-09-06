<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=library','NEHA','CHAHAR');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

