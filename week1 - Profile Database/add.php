<?php
session_start();
require_once "pdo.php";

if(!isset($_SESSION['name'])){
    die("ACCESS DENIED");
}

if(isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}

if(isset($_POST['add'])){
    if(!isset($_POST['first_name']) ||!isset($_POST['last_name']) ||!isset($_POST['email']) ||!isset($_POST['headline']) ||!isset($_POST['summary'])){
        $_SESSION['error'] = 'All fields are required';
        error_log("Adding fail ".$name.": ".$_SESSION['error']);
        header("Location: add.php");
        return;
    }
    if ( ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] ="All fields are required";
        error_log("Adding fail ".$name.": ".$_SESSION['error']);
        header("location: add.php"); 
        return;
    }
    else{
        $stmt = $pdo->prepare('INSERT INTO profile (user_id,first_name,last_name,email,headline,summary) VALUES (:uid,:fn,:ln,:em,:hl,:su);');
        $stmt->execute(array(
            ':uid'=>$_SESSION['user_id'],
            ':fn'=>$_POST['first_name'],
            ':ln'=>$_POST['last_name'],
            ':em'=>$_POST['email'],
            ':hl'=>$_POST['headline'],
            ':su'=>$_POST['summary']
        ));
        $_SESSION['success'] = 'Profile added';
        error_log($_SESSION['success']);
        header("Location: index.php");
        return;
    }
}

?>


<html>
    <head><title>Marwan Mohamed</title></head>
    <body>
       <h1>Adding Profile for <?php echo $_SESSION['name']; ?></h1>
        <div>
            <?php
                if(isset($_SESSION['error'])){
                    echo('<p style="color:red">'.$_SESSION['error']."</p>\n");
                    unset($_SESSION['error']);
                }
            ?>
        </div>
       <div>
           <form method="post">
               <p>First Name: <input type="text" name="first_name"></p>
               <p>Last Name: <input type="text" name="last_name"></p>
               <p>E-mail: <input type="text" name="email" size="50"> </p>
               <p>Password: <input type="password" name="password"></p>
               <p>Headline:<br><input type="text" name="headline" size="85"></p>
               <p>Summary:<br><textarea name="summary" rows="8" cols="80"></textarea></p>
               <p> <input type="submit" name="add" value="Add"> | <input type="submit" name="cancel" value="Cancel"></p>
           </form>
       </div> 
    </body>
</html>