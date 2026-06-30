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
    <title>Update participants score</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar cec-navbar">
    <div class="container cec-shell py-0">
        <a href="admin_menu.php" class="navbar-brand py-2"><i class="bi bi-bicycle"></i>Cit-E Cycling</a>
    </div>
</nav>

<div class="cec-shell" style="max-width:520px;">
<a href="view_participants_edit_delete.php" class="cec-backlink"><i class="bi bi-arrow-left"></i> Back to list</a>
   <?php
       include 'dbconnect.php';
       try {
           if($_SERVER['REQUEST_METHOD'] == 'POST')
           {
               $errors = [];

               // --- Validation ---
               $id = isset($_POST['id']) ? $_POST['id'] : '';
               $power_output_raw = isset($_POST['power_output']) ? trim($_POST['power_output']) : '';
               $distance_raw = isset($_POST['distance']) ? trim($_POST['distance']) : '';

               if (!ctype_digit((string)$id)) {
                   $errors[] = "Invalid participant ID.";
               } else {
                   $id = (int)$id;
               }

               if ($power_output_raw === '' || !is_numeric($power_output_raw)) {
                   $errors[] = "Power output must be a number.";
               } elseif (substr($power_output_raw, 0, 1) === '-' || $power_output_raw < 0 || $power_output_raw > 3000) {
                   $errors[] = "Power output cannot be negative and must be between 0 and 3000 watts.";
               } else {
                   $power_output = (float)$power_output_raw;
               }

               if ($distance_raw === '' || !is_numeric($distance_raw)) {
                   $errors[] = "Distance must be a number.";
               } elseif (substr($distance_raw, 0, 1) === '-' || $distance_raw < 0 || $distance_raw > 10000) {
                   $errors[] = "Distance cannot be negative and must be between 0 and 10000 km.";
               } else {
                   $distance = (float)$distance_raw;
               }

               if (!empty($errors)) {
                   echo "<ul style='color:red;'>";
                   foreach ($errors as $err) {
                       echo "<li>" . htmlspecialchars($err) . "</li>";
                   }
                   echo "</ul>";
                   echo '<a href="edit_participant_form.php?id=' . urlencode($id) . '" class="btn btn-cec-outline mt-2">Go back and try again</a>';
               } else {
                   $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                   $sql = $conn->prepare("UPDATE participant SET power_output = :power_output, distance = :distance WHERE id = :id");
                   $sql -> bindParam(':power_output', $power_output);
                   $sql -> bindParam(':distance', $distance);
                   $sql -> bindParam(':id', $id, PDO::PARAM_INT);
                   $sql -> execute();
                   echo '<div class="cec-form-card text-center"><i class="bi bi-check-circle-fill text-success fs-1"></i><p class="mt-3 mb-0" style="text-transform:none;font-weight:600;color:var(--ink);">Person updated</p></div>';
               }
           }
           else{
               $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
               $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               include "edit_participant_form.php";
           }
       }
       catch(PDOException $e)
           {
            echo "Sorry, something went wrong."; // don't leak DB errors
           }
       ?>

<footer class="cec-footer">Cit-E Cycling Web Portal</footer>
</div>
</body>
</html>
