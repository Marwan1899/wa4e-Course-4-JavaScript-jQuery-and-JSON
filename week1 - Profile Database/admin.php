<?php
require_once "pdo.php";
session_start();

if(isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}

if(isset($_POST['add'])){
    if(!isset($_POST['name']) ||!isset($_POST['email']) ||!isset($_POST['password'])){
        $_SESSION['error'] = 'All fields are required';
        header("Location: admin.php");
        return;
    }
    else{
        $salt = 'XyZzy12*_';
        $password = hash('md5', $salt.$_POST['password']);
        $query = $pdo->prepare('INSERT INTO users (name,email,password) VALUES (:na,:em,:pa);');
        $query->execute(array(
            ':na'=>$_POST['name'],
            ':em'=>$_POST['email'],
            ':pa'=>$password
        ));
        $_SESSION['success'] = 'Admin Account has been added successfully';
        header("Location: index.php");
        return;
    }
}

?>


<html>
    <head><title></title></head>
    <body>
        <h1>Add an Admin Account</h1>
        <?php
            if(isset($_SESSION['error'])){
                echo('<p style="color:red>"'.$_SESSION['error'].'</p>');
                unset($_SESSION['error']);
            }
        ?>
        <div>
            <form method="post">
                <p>Name: <input type="text" name="name"></p>
                <p>E-mail: <input type="text" name="email" id="email"></p>
                <p>Password: <input type="password" name="password" id="password"></p>
                <p><input type="submit" name="add" value="Add" onclick="doValidate();"> | <input type="submit" name="cancel" value="Cancel"> </p>
            </form>
        </div>
    </body>
    <script>
        function doValidate() {
    console.log('Validating...');
    try {
        addr = document.getElementById('email').value;
        pw = document.getElementById('password').value;
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