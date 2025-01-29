<!DOCTYPE html>
<html>
<head>
    <title>Vælg bryghus</title>
    <link rel="stylesheet" href="assets/css/landing.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/x-icon" href="assets/media/favicons/landing.png">
</head>
<body>
    <header>
    <h1>🍺 Velkommen til Øl Samlingen 🍺</h1>
        <p>Der er <?php 
            require('db.php');
            $countQuery = "SELECT COUNT(*) as total FROM samler_vanvid";
            $countResult = $conn->query($countQuery);
            $countRow = $countResult->fetch_assoc();
            echo $countRow['total'];
        ?> øl i databasen.</p>
    </header>
    <div class="container">
        <h2>🏭 Vælg et Bryghus 🏭</h2>
        <ul>
            <?php
            require('db.php');
            $brandsQuery = "SELECT DISTINCT Brand FROM samler_vanvid";
            $brandsResult = $conn->query($brandsQuery);

            while ($row = $brandsResult->fetch_assoc()) {
                echo '<li><a href="brand.php?brand=' . urlencode($row['Brand']) . '">' . htmlspecialchars($row['Brand']) . '</a></li>';
            }
            ?>
        </ul>
    </div>
</body>
</html>
