<?php
require_once "pdo.php";
session_start();

if(!isset($_GET['profile_id'])){
    die('Now what on earth do want from here');
}

$query = $pdo->prepare('SELECT * FROM profile WHERE profile_id=:pid;');
$query->execute(array(':pid'=> $_GET['profile_id']));
$row = $query->fetch(PDO::FETCH_ASSOC);
if($row === false){
    $_SESSION['error'] = 'Bad value for profile_id';
    header("location: index.php");
    return;
}
$fname = htmlentities($row['first_name']);
$lname = htmlentities($row['last_name']);
$email = htmlentities($row['email']);
$headline = htmlentities($row['headline']);
$summary = htmlentities($row['summary']);

?>


<html>
    <head><title></title></head>
    <body>
    <h1>Profile information</h1>
    <div>
    <p>First Name: <?=$fname?></p>
    <p>Last Name: <?=$lname?></p>
    <p>Email: <?=$email?></p>
    <p>Headline:<br> <?=$headline?></p>
    <p>Summary:<br> <?=$summary?></p>
    <p><a href="index.php">Done</a></p>
    </div>        
    </body>
</html>