<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kucqit Yush-ya Maltum</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</head>

<body>
        <div class="container d-flex justify-content-between align-items-center py-3">
            <div>
                <!-- <img src="assets/images/bootstrap-logo.svg" alt="Bootstrap" width="30"> -->
            </div>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a href="index.php" class="nav-link active">Home</a></li>
                    <li class="nav-item"><a href="list.php" class="nav-link">List Kosakata</a></li>
                    <li class="nav-item"><a href="kamus.php" class="nav-link">Kamus</a></li>
                </ul>
            </nav>
            <div>
            </div>
    </div>
</body>

</html>

<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "kucqit";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>