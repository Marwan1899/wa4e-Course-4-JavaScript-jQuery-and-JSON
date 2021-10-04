<?php
session_start();
require_once "pdo.php";

if(!isset($_GET['profile_id'])){
    die('NOTHING TO SEE HERE BITCH');
}

if(isset($_POST['cancel'])){
    header("Location: view.php");
    return;
}

if(isset($_POST['save'])){
    if(strlen($_POST['first_name'])<1 || strlen('last_name')<1 || strlen('email')<1 || strlen('headline')<1 || strlen('summary')<1 ){
        $_SESSION['error'] = 'All fields are required';
        error_log("edit fail ".$_GET['profile_id'].": ".$_SESSION['error']);
        header('Location:edit.php?profile_id='.$_GET['profile_id']);
        return;
    }
    if ( ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] ="Email must have an at-sign (@)";
        header('Location:edit.php?profile_id='.$_GET['profile_id']);
        return;
    }
    else{
        $stmt = $pdo->prepare('UPDATE profile SET first_name=:fn,last_name=:ln,email=:em,headline=:hl,summary=:su WHERE profile_id=:pid;');
        $stmt->execute(array(
            ':fn'=>$_POST['first_name'],
            ':ln'=>$_POST['last_name'],
            ':em'=>$_POST['email'],
            ':hl'=>$_POST['headline'],
            ':su'=>$_POST['summary'],
            ':pid'=>$_GET['profile_id']
        ));
        $_SESSION['success'] = 'Profile has been updated';
        header("Location: index.php");
        return;
    }
}

$query = $pdo->prepare('SELECT * FROM profile WHERE profile_id=:pid;');
$query->execute(array(':pid'=> $_GET['profile_id']));
$data = $query->fetch(PDO::FETCH_ASSOC);
if($data === false){
    $_SESSION['error'] = 'Bad value for profile_id';
    header("location: index.php");
    return;
}
$fname = htmlentities($data['first_name']);
$lname = htmlentities($data['last_name']);
$email = htmlentities($data['email']);
$headline = htmlentities($data['headline']);
$summary = htmlentities($data['summary']);
?>

<html>
    <head><title></title></head>
    <body>
       <h1>Edit</h1>
       <?php
       if(isset($_SESSION['error'])){
           echo('<p style="color:red">'.$_SESSION['error']."</p>\n");
           unset($_SESSION['error']);
       }
       ?>
       <div>
           <form method="post">
               <p>First Name: <input type="text" name="first_name" value="<?=$fname?>"></p>
               <p>Last Name: <input type="text" name="last_name" value="<?=$lname?>"></p>
               <p>E-mail: <input type="text" name="email" size="50" value="<?=$email?>"> </p>
               <p>Headline:<br><input type="text" name="headline" size="85" value="<?=$headline?>"></p>
               <p>Summary:<br><textarea name="summary" rows="8" cols="80"><?=$summary?></textarea></p>
               <p> <input type="submit" name="save" value="Save"> | <input type="submit" name="cancel" value="Cancel"></p>
           </form>
       </div> 
    </body>
</html>