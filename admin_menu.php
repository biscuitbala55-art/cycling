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
    <title>Admin menu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>


<body>
    <nav class="navbar cec-navbar">
        <div class="container cec-shell py-0 d-flex justify-content-between">
            <a href="admin_menu.php" class="navbar-brand py-2"><i class="bi bi-bicycle"></i>Cit-E Cycling</a>
            <span class="text-white-50 align-self-center small">
                <?php if (isset($_SESSION['username'])) echo "Signed in as " . htmlspecialchars($_SESSION['username']); ?>
            </span>
        </div>
    </nav>

    <div class="cec-shell">
        <h1 class="mb-4"><i class="bi bi-speedometer2 text-warning"></i> Admin menu</h1>
          <p class="text-muted mb-4" style="text-transform:none;font-weight:400;">Welcome to the admin menu, where you can manage clubs and participants and manage your login session.</p>

        <div class="row g-3">
            <div class="col-12 col-md-6">
                <a href="search_form.php" class="cec-card-link">
                    <span class="cec-icon"><i class="bi bi-search"></i></span>
                    <span>
                        <span class="cec-card-title">Search</span>
                        <span class="cec-card-sub">for clubs or participants</span>
                    </span>
                </a>
            </div>
            <div class="col-12 col-md-6">
                <a href="view_participants_edit_delete.php" class="cec-card-link">
                    <span class="cec-icon"><i class="bi bi-table"></i></span>
                    <span>
                        <span class="cec-card-title">View all participants</span>
                        <span class="cec-card-sub">edit or delete an entry</span>
                    </span>
                </a>
            </div>
            <div class="col-12 col-md-6">
                <a href="logout.php" class="cec-card-link danger-hover" onclick="return cecConfirm(event, this.href, 'Are you sure you want to logout?');">
                    <span class="cec-icon" style="background:var(--danger);color:#fff;"><i class="bi bi-box-arrow-right"></i></span>
                    <span>
                        <span class="cec-card-title">Logout</span>
                        <span class="cec-card-sub">end your admin session</span>
                    </span>
                </a>
            </div>
        </div>

        <footer class="cec-footer">Cit-E Cycling Web Portal</footer>
    </div>

    <div class="cec-modal-overlay" id="cecModalOverlay" style="display:none;">
        <div class="cec-modal-box">
            <i class="bi bi-exclamation-triangle-fill cec-modal-icon"></i>
            <p id="cecModalMessage">Are you sure?</p>
            <div class="cec-modal-actions">
                <button type="button" class="cec-modal-cancel" onclick="cecModalCancel();">Cancel</button>
                <button type="button" class="cec-modal-confirm" onclick="cecModalConfirm();">Yes, continue</button>
            </div>
        </div>
    </div>

    <script>
    var cecModalTargetUrl = null;

    function cecConfirm(event, url, message) {
        event.preventDefault();
        cecModalTargetUrl = url;
        document.getElementById('cecModalMessage').textContent = message;
        var overlay = document.getElementById('cecModalOverlay');
        overlay.style.display = 'flex';
        return false;
    }

    function cecModalCancel() {
        cecModalTargetUrl = null;
        document.getElementById('cecModalOverlay').style.display = 'none';
    }

    function cecModalConfirm() {
        if (cecModalTargetUrl) {
            window.location.href = cecModalTargetUrl;
        }
        document.getElementById('cecModalOverlay').style.display = 'none';
    }
    </script>
</body>
</html>