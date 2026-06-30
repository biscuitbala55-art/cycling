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
    <title>Register your interest</title>

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

    <div class="cec-shell" style="max-width:620px;">
        <a href="admin_menu.php" class="cec-backlink"><i class="bi bi-arrow-left"></i> Back to Menu</a>
        <h1 class="mb-4"><i class="bi bi-search text-warning"></i> Search for participants or clubs</h1>

        <div class="cec-form-card mb-4">
            <h2 class="h5 mb-3" style="color:var(--ink);"><i class="bi bi-person-fill"></i> Search for an individual participant</h2>
            <form action="search_result.php" method="POST">
                <div class="mb-3">
                    <p class="mb-1">Participant firstname or surname</p>
                    <input type="text" name="firstname" maxlength="50" required class="form-control">
                </div>
                <input type="hidden" name="participant" value="1">
                <button type="submit" class="btn btn-cec">Search</button>
            </form>
        </div>

        <div class="cec-form-card">
            <h2 class="h5 mb-3" style="color:var(--ink);"><i class="bi bi-flag-fill"></i> Search for a club / team</h2>
            <form action="search_result.php" method="POST">
                <div class="mb-3">
                    <p class="mb-1">Club name</p>
                    <input type="text" name="club" maxlength="100" required class="form-control">
                </div>
                <button type="submit" class="btn btn-cec">Search</button>
            </form>
        </div>

        <footer class="cec-footer">Cit-E Cycling Web Portal</footer>
    </div>
</body>
</html>
