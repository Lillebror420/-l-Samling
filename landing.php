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
    </header>
    <div class="container">
        <h2>🏭 Vælg kategori 🏭</h2>
        <ul>
        <li><a href="brand.php?fejl=1">❌ Flasker med fejl</a></li> <!-- Tilføj link til kun fejlflasker -->
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
