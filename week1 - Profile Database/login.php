<?php
session_start();
require_once "pdo.php";
if(isset($_POST['cancel'])){
    header("location: index.php");
    return;
}

$salt = 'XyZzy12*_';
    if(isset($_POST['login'])){
    $check = hash('md5', $salt.$_POST['pass']);

    $stmt = $pdo->prepare('SELECT user_id, name FROM users

        WHERE email = :em AND password = :pw');

    $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ( $row !== false ) {

        $_SESSION['name'] = $row['name'];

        $_SESSION['user_id'] = $row['user_id'];

        // Redirect the browser to index.php

        header("Location: index.php");

        return;
    }
    else{
        $_SESSION['error'] = 'Incorrect Password or wrong E-mail';
        error_log("Login fail ".$_POST['email'].": ".$_SESSION['error']); 
        header("Location: login.php");
        return;
    }
}
?>


<html>
    <head><title>Marwan Mohamed</title></head>
    <body>
        <div>
            
        </div>
        <h1>Please Login</h1>
        <?php
        if(isset($_SESSION['error'])){
            echo('<p style="color:red">'.$_SESSION['error']."</p>\n");
            unset($_SESSION['error']);
        }
        ?>
        <div>
            <form method='post'>
                <p>Email <input type="text" name="email" id="email"></p>
                <p>Password <input type="password" name="pass" id="id_1723"></p>
                <p><input type="submit" name="login" value="Log In" onclick="doValidate();"> | <input type="submit" name="cancel" value="Cancel"></p>
            </form>
        </div>        
    </body>
    <script>
        function doValidate() {
    console.log('Validating...');
    try {
        addr = document.getElementById('email').value;
        pw = document.getElementById('id_1723').value;
        console.log("Validating addr="+addr+" pw="+pw);
        if (addr == null || addr == "" || pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if ( addr.indexOf('@') == -1 ) {
            alert("Invalid email address");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
    </script>
</html>