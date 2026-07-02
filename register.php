<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register your interest</title>

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
    
    <div class="cec-shell" style="max-width:480px;">
        <a href="." class="cec-backlink"><i class="bi bi-arrow-left"></i> Back to index</a>

    <div class="cec-shell" style="max-width:560px;">
    <?php
    //including connection variables  
    include 'dbconnect.php';

            $errors = [];

            // --- Validation ---
            $first_name = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
            $surname    = isset($_POST['surname'])   ? trim($_POST['surname'])   : '';
            $email      = isset($_POST['email'])     ? trim($_POST['email'])     : '';
            $terms_raw  = isset($_POST['terms'])      ? $_POST['terms']           : '';

            if ($first_name === '') {
                $errors[] = "Firstname is required.";
            } elseif (!preg_match("/^[a-zA-Z\-' ]{1,50}$/", $first_name)) {
                $errors[] = "Firstname must only contain letters, spaces, hyphens or apostrophes (max 50 characters).";
            }

            if ($surname === '') {
                $errors[] = "Surname is required.";
            } elseif (!preg_match("/^[a-zA-Z\-' ]{1,50}$/", $surname)) {
                $errors[] = "Surname must only contain letters, spaces, hyphens or apostrophes (max 50 characters).";
            }

            if ($email === '') {
                $errors[] = "Email is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Please enter a valid email address.";
            } elseif (strlen($email) > 100) {
                $errors[] = "Email must be 100 characters or fewer.";
            }

            $terms = ($terms_raw === "yes") ? 1 : 0;
            if ($terms !== 1) {
                $errors[] = "You must accept the terms and conditions.";
            }

            if (!empty($errors)) {
                echo "<ul style='color:red;'>";
                foreach ($errors as $err) {
                    echo "<li>" . htmlspecialchars($err) . "</li>";
                }
                echo "</ul>";
                echo '<a href="register_form.html" class="btn btn-cec-outline mt-2">Go back and try again</a>';
            } else {
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("INSERT INTO interest (firstname, surname, email, terms)
                    VALUES (:firstname, :surname, :email, :terms)");
                    $stmt->bindParam(':firstname', $first_name);
                    $stmt->bindParam(':surname', $surname);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':terms', $terms, PDO::PARAM_INT);

                    $stmt->execute();

                     echo '<div class="cec-form-card text-center"><i class="bi bi-check-circle-fill text-success fs-1"></i><p class="mt-3 mb-0" style="text-transform:none;font-weight:600;color:var(--ink);">Registration successful</p><p class="mt-2 mb-0" style="text-transform:none;font-weight:400;color:var(--muted);">Thanks, ' . htmlspecialchars($first_name) . ' ' . htmlspecialchars($surname) . '! We\'ll keep you posted about future events.</p></div>';
                }
                catch(PDOException $e)
                {
                    echo "Sorry, something went wrong saving your details."; // don't leak DB errors to the page
                }
            }
        ?>

    <footer class="cec-footer">Cit-E Cycling Web Portal</footer>
    </div>
</body>
</html>
