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
   <title>Update participant scores</title>

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
   $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


   $id = isset($_GET['id']) ? $_GET['id'] : '';

   if (!ctype_digit((string)$id)) {
       echo "Invalid participant ID.";
       echo '<p><a href="view_participants_edit_delete.php">Back to list</a></p>';
       exit;
   }
   $id = (int)$id;

   $sql = $conn->prepare("SELECT * FROM participant WHERE id = ?");
   $sql -> bindValue(1, $id, PDO::PARAM_INT);
   $sql -> execute(); //execute the statement
   $row = $sql->fetch();

   if (!$row) {
       echo "Participant not found.";
       echo '<p><a href="view_participants_edit_delete.php">Back to list</a></p>';
       exit;
   }

   $firstname = $row['firstname'];
   $surname = $row['surname'];
   $email = $row['email'];
   $power_output = $row['power_output'];
   $distance = $row['distance'];
   $club_id = $row['club_id'];
   ?>
   <h1 class="mb-4"><i class="bi bi-pencil-fill text-warning"></i> Update participant scores</h1>

   <div class="cec-form-card">
   <form action="edit_participant.php" method="POST" onsubmit="return validateForm();" id="editForm">
   <div class="mb-3">
   <p class="mb-1">Participant Firstname</p>
   <input type="text" name="firstname" disabled value="<?php echo htmlspecialchars($firstname); ?>" class="form-control">
   </div>

   <div class="mb-3">
   <p class="mb-1">Participant Surname</p>
   <input type="text" name="surname" disabled value="<?php echo htmlspecialchars($surname); ?>" class="form-control">
   </div>

   <div class="mb-3">
   <p class="mb-1">Power output in watts</p>
   <input type="number" step="0.1" min="0" max="3000" name="power_output" id="power_output" value="<?php echo htmlspecialchars($power_output); ?>" required class="form-control">
   </div>

   <div class="mb-3">
   <p class="mb-1">Distance in KM</p>
   <input type="number" step="0.1" min="0" max="10000" name="distance" id="distance" value="<?php echo htmlspecialchars($distance); ?>" required class="form-control">
   </div>

   <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

   <button type="submit" class="btn btn-cec w-100">Update this rider</button>
</form>
</div>

<script>
function isNegativeOrNegativeZero(rawValue) {
    // catches -0, -0.0, -0.00 etc as well as any other negative number
    var trimmed = String(rawValue).trim();
    if (trimmed.charAt(0) === '-') {
        return true;
    }
    return parseFloat(trimmed) < 0;
}

function validateForm() {
    var powerField = document.getElementById('power_output');
    var distanceField = document.getElementById('distance');
    var errors = [];

    if (powerField.value === '' || isNaN(parseFloat(powerField.value))) {
        errors.push("Power output must be a number.");
    } else if (isNegativeOrNegativeZero(powerField.value)) {
        errors.push("Power output cannot be negative.");
    }

    if (distanceField.value === '' || isNaN(parseFloat(distanceField.value))) {
        errors.push("Distance must be a number.");
    } else if (isNegativeOrNegativeZero(distanceField.value)) {
        errors.push("Distance cannot be negative.");
    }

    if (errors.length > 0) {
        alert(errors.join("\n"));
        return false; // stop form submission
    }
    return true;
}
</script>

   <footer class="cec-footer">Cit-E Cycling Web Portal</footer>
   </div>
</body>
</html>
