<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header("Location: admin_login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete participant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar cec-navbar">
    <div class="container cec-shell py-0">
        <a href="index.html" class="navbar-brand py-2"><i class="bi bi-bicycle"></i>Cit-E Cycling</a>
    </div>
</nav>

<div class="cec-shell" style="max-width:520px;">
    <?php
       
    include 'dbconnect.php';

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //TODO DELETE - complete the functionality
                $id = isset($_GET['id']) ? $_GET['id'] : '';

                if (!ctype_digit((string)$id)) {
                    echo "Invalid participant ID.";
                    echo '<p><a href="view_participants_edit_delete.php" class="btn btn-cec-outline mt-2">Back to list</a></p>';
                    exit;
                }
                $id = (int)$id;

               $sql = $conn->prepare("DELETE FROM participant WHERE id = ? ");
               $sql -> bindValue(1, $id, PDO::PARAM_INT); //we bind this variable to the first ? in the sql statement
               $sql -> execute(); //execute the statement
               header("Location: view_participants_edit_delete.php");
               exit;


                }
            catch(PDOException $e)
                {
                echo "Sorry, the delete failed. Please try again.";
                }

        
        
        ?>

</div>
</body>
</html>
