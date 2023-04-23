<?php
require "libs/rb-mysql.php";
R::setup('mysql:host=localhost;dbname=5laba', 'root', '');
$con = mysqli_connect('localhost', 'root', '',"5laba");
try {
    $dbh = new PDO('mysql:host=localhost;dbname=5laba', 'root', '');
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
  }
?>