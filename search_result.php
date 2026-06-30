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
    <title>Search results</title>

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

<div class="cec-shell" style="max-width:680px;">
<a href="Search_form.php" class="cec-backlink"><i class="bi bi-arrow-left"></i> Back to Search Menu</a>
    <?php
        
            
            include 'dbconnect.php';
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //checking which form has been posted
            if (isset($_POST['participant']) && $_POST['participant'] == "1") {

                $search = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';

                if ($search === '') {
                    echo "<p>Please enter a name to search for.</p>";
                } elseif (strlen($search) > 50) {
                    echo "<p>Search term is too long.</p>";
                } else {

$sql = "SELECT * FROM participant
        WHERE firstname LIKE :search
        OR surname LIKE :search";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':search' => "%$search%"
]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2><i class='bi bi-person-fill text-warning'></i> Participant Results</h2>";

if (count($results) === 0) {
    echo "<p>No participants found.</p>";
}

foreach($results as $row)
{
    echo "<div class='cec-result-card'>";
    echo "<span class='km-marker muted me-2'>ID " . htmlspecialchars($row['id']) . "</span>";
    echo "<span class='name'>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['surname']) . "</span><br>";
    echo "<span class='text-muted small'><i class='bi bi-envelope'></i> " . htmlspecialchars($row['email']) . "</span><br>";
    echo "<span class='km-marker mt-2 me-2'>" . htmlspecialchars($row['power_output']) . " W</span>";
    echo "<span class='km-marker mt-2'>" . htmlspecialchars($row['distance']) . " KM</span>";
    echo "</div>";
}
                }
            }
            else{

                $club = isset($_POST['club']) ? trim($_POST['club']) : '';

                if ($club === '') {
                    echo "<p>Please enter a club name to search for.</p>";
                } elseif (strlen($club) > 100) {
                    echo "<p>Search term is too long.</p>";
                } else {

$sql = "
SELECT
participant.*,
club.name
FROM participant
INNER JOIN club
ON participant.club_id = club.id
WHERE club.name LIKE :club
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':club' => "%$club%"
]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2><i class='bi bi-flag-fill text-warning'></i> Club Results</h2>";

$totalDistance = 0;
$totalPower = 0;
$count = 0;

if (count($results) === 0) {
    echo "<p>No clubs found.</p>";
}

foreach($results as $row)
{
    echo "<div class='cec-result-card'>";
    echo "<span class='km-marker muted me-2'>ID " . htmlspecialchars($row['id']) . "</span>";
    echo "<span class='name'>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['surname']) . "</span><br>";
    echo "<span class='km-marker mt-2 me-2'>" . htmlspecialchars($row['distance']) . " KM</span>";
    echo "<span class='km-marker mt-2'>" . htmlspecialchars($row['power_output']) . " W</span>";
    echo "</div>";

    $totalDistance += $row['distance'];
    $totalPower += $row['power_output'];
    $count++;
}

if($count > 0)
{
    echo "<div class='cec-stats-banner'>";
    echo "<h3 class='h6 mb-3' style='color:var(--lime);'><i class='bi bi-bar-chart-fill'></i> Club Statistics</h3>";
    echo "<div class='row text-center g-3'>";

    echo "<div class='col-6 col-md-3'><div class='stat-label'>Total Distance</div><div class='stat-value'>" . $totalDistance . " KM</div></div>";

    echo "<div class='col-6 col-md-3'><div class='stat-label'>Average Distance</div><div class='stat-value'>" .
        round($totalDistance / $count, 2) . " KM</div></div>";

    echo "<div class='col-6 col-md-3'><div class='stat-label'>Total Power</div><div class='stat-value'>" .
        $totalPower . " W</div></div>";

    echo "<div class='col-6 col-md-3'><div class='stat-label'>Average Power</div><div class='stat-value'>" .
        round($totalPower / $count, 2) . " W</div></div>";

    echo "</div></div>";
}
                }
            }
            
               
            }
        catch(PDOException $e)
            {
                //put error stuff here
            }
        ?>

<footer class="cec-footer">Cit-E Cycling Web Portal</footer>
</div>
</body>
</html>