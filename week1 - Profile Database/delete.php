<?php
require_once "pdo.php";
session_start();

if(!isset($_GET['profile_id'])){
    die('Get outa here PUNK');
}

if(isset($_POST['cancel'])){
    header("location: index.php");
    return;
}

if(isset($_POST['delete'])){
    $stmt = $pdo->prepare('DELETE FROM profile WHERE profile_id=:pid;');
    $stmt->execute(array(':pid'=>$_GET['profile_id']));
    $_SESSION['success'] = 'Profile deleted successfully';
    error_log($_SESSION['success']." Where profile id = ".$_GET['profile_id']);
    header("Location: index.php");
    return;
}

$query = $pdo->prepare('SELECT * FROM profile WHERE profile_id=:pid;');
$query->execute(array(':pid'=>$_GET['profile_id']));
$row = $query->fetch(PDO::FETCH_ASSOC);
if($data === false){
    $_SESSION['error'] = 'Bad value for profile_id';
    header("location: index.php");
    return;
}
$fname = htmlentities($row['first_name']);
$lname = htmlentities($row['last_name']);

?>

<html>
    <head><title></title></head>
    <body>
        <h1>Deleteing Profile</h1>
        <div>
            <p>First Name: <?=$fname?></p>
            <p>Last Name: <?=$lname?></p>
            <form method="post">
                <p><input type="submit" name="delete" value="Delete" onclick="AreYouSure();"> <input type="submit" name="cancel" value="Cancel"></p>
            </form>
        </div>
    </body>
    <script>
        function AreYouSure(){
            alert("Record has been deleted");
            return true;
        }
    </script>
</html>