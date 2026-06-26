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
    <title>View participants</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar cec-navbar">
        <div class="container cec-shell py-0">
            <span class="navbar-brand py-2"><i class="bi bi-bicycle"></i>Cit-E Cycling</span>
        </div>
    </nav>

    <div class="cec-shell" style="max-width:1100px;">
    <a href="admin_menu.php" class="cec-backlink"><i class="bi bi-arrow-left"></i> Back to Menu</a>
    <h1 class="mb-4"><i class="bi bi-table text-warning"></i> View all of the participants for edit or delete</h1>
    <?php
        
    //including connection variables - remember to update these if you are using XAMPP    
    include 'dbconnect.php';
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //TODO SELECT - view the participants with links to edit or delete them. 
            $sql = "SELECT * FROM participant";

$stmt = $conn->prepare($sql);
$stmt->execute();

$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<div class='cec-table-wrap'>";
echo "<div class='table-responsive'>";
echo "<table class='table cec-table mb-0' border='1'>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>Firstname</th>";
echo "<th>Surname</th>";
echo "<th>Email</th>";
echo "<th>Power Output</th>";
echo "<th>Distance</th>";
echo "<th>Club ID</th>";
echo "<th>Edit</th>";
echo "<th>Delete</th>";
echo "</tr>";

foreach($participants as $row)
{
    echo "<tr>";

    echo "<td><span class='km-marker muted'>".$row['id']."</span></td>";
    echo "<td>".$row['firstname']."</td>";
    echo "<td>".$row['surname']."</td>";
    echo "<td>".$row['email']."</td>";
    echo "<td>".$row['power_output']."</td>";
    echo "<td>".$row['distance']."</td>";
    echo '<td>'. $row['club_id'] . '</td>';

    echo "<td>";
    echo '<a href="edit_participant_form.php?id='.$row['id'].'" class="button btn-edit-pill"><i class="bi bi-pencil-fill"></i> Update</a>';
    echo "</td>";

    echo "<td>";
    echo "<a href='delete.php?id=".$row['id']."' class='dbutton btn-delete-pill' onclick='return confirm(\"Are you sure you want to delete this person?\");'><i class=\"bi bi-trash-fill\"></i> Delete</a>";
    echo "</td>";

    echo "</tr>";
}

echo "</table>";
echo "</div>";
echo "</div>";
            
            }
        catch(PDOException $e)
            {
            echo $e->getMessage(); //If we are not successful we will see an error
            }
        ?>

    <footer class="cec-footer">Cit-E Cycling Web Portal</footer>
    </div>
</body>
</html>
