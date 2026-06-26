<?php
session_start();
include 'dbconnect.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // --- Validation ---
    $login_username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $login_password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($login_username === '' || $login_password === '') {
        $error = "Username and password are both required.";
    } elseif (strlen($login_username) > 10) {
        // table column is varchar(10) - can't possibly match, fail fast
        $error = "Wrong username or password";
    } else {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = $conn->prepare("SELECT * FROM user WHERE username = :username AND password = :pword");
            $sql->bindParam(':username', $login_username);
            $sql->bindParam(':pword', $login_password);
            $sql->execute();

            if ($sql->rowCount()) {
                $row = $sql->fetch();
                $_SESSION['login'] = 1;
                $_SESSION['username'] = $row['username'];
                header("Location: admin_menu.php");
                exit;
            } else {
                $error = "Wrong username or password";
            }
        }
        catch(PDOException $e) {
            $error = "Unable to log in right now. Please try again later.";
        }
    }
} else {
    $error = "You're here by mistake";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

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

    <div class="cec-shell" style="max-width:480px;">
        <?php if ($error !== "") { ?>
            <div class="cec-form-card text-center">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
                <p class="mt-2 mb-3" style="text-transform:none;font-weight:600;color:var(--ink);">
                    <?php echo htmlspecialchars($error); ?>
                </p>
                <a href="admin_login.html" class="btn btn-cec">Try again</a>
            </div>
        <?php } ?>
    </div>
</body>
</html>
