<?php
require_once "pdo.php";
session_start();

$stmt = $pdo->query('SELECT profile_id,first_name,last_name,headline FROM profile;');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<html>
    <head><title></title></head>
    <body>
        <h1>Resume Builder</h1>
            <div>
                <?php
                    if(isset($_SESSION['success'])){
                        echo("<p style='color:green'>".$_SESSION['success']."</p>\n");
                        unset($_SESSION['success']);
                    }
                ?>    
            </div>
            <div>
                <?php
                    if (isset($_SESSION['name'])){
                        if(sizeof($rows) >= 1){
                            echo "<table border='1'><thead><tr>";
                            echo "<th>Name</th>";
                            echo "<th>Headline</th>";
                            echo "<th>Action</th></tr></thead>";
                            foreach($rows as $row){
                                echo ("<tr><td><a href='view.php?profile_id=".$row['profile_id']."'>".$row['first_name']." ".$row['last_name']."</a></td>");
                                echo ("<td>".$row['headline']."</td>");
                                echo ("<td><a href='edit.php?profile_id=".$row['profile_id']."'>Edit</a> | 
                                <a href='delete.php?profile_id=".$row['profile_id']."'>Delete</a></td></tr>");
                            }
                            echo "</table>";
                        }
                        else{
                            echo("<p>No rows found</p>\n");
                        }

                        echo('<p><a href="logout.php">Logout</a></p>');
                        echo('<p><a href="add.php">Add New Entry</a></p>');
                    }
                    else{
                        echo('<p><a href="login.php">Please log in</a></p>');
                    }
                ?>
            </div>
    </body>
</html>