<!DOCTYPE html>
<html>
<head>
    <title>Vælg bryghus</title>
    <link rel="stylesheet" href="assets/css/landing.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/x-icon" href="assets/media/favicons/landing.png">
</head>
<body>
    <header>
        <h1 class="main-header">
            <span class="title">🍺 Velkommen til Øl Samlingen 🍺</span>
            <span class="sub-title">
                Der er <?php 
                    require('db.php');
                    $countQuery = "SELECT COUNT(*) as total FROM samler_vanvid";
                    $countResult = $conn->query($countQuery);
                    $countRow = $countResult->fetch_assoc();
                    echo $countRow['total'];
                ?> øl i samlingen.
            </span>
        </h1>
    </header>
    <div class="container">
        <h2>🏭 Vælg et Bryghus 🏭<br>
        <span class="small-text">Der er <?php 
            $countQuery = "SELECT COUNT(DISTINCT Brand) as totalBrands FROM samler_vanvid";
            $countResult = $conn->query($countQuery);
            $countRow = $countResult->fetch_assoc();
            echo $countRow['totalBrands'];
        ?> bryghuse i samlingen.</span>
        </h2>

        <!-- Filter knap for at vise kun de bryghuse med fejl = 0 -->
        <a href="landing.php?filter=no-error" class="filter-button">Vis kun uden fejl</a>

        <ul>
            <?php
            require('db.php');
            
            // Tjek om filteret er aktiveret
            $filter = isset($_GET['filter']) && $_GET['filter'] == 'no-error' ? "WHERE fejl = 0" : "";
            $brandsQuery = "SELECT DISTINCT Brand FROM samler_vanvid $filter";
            $brandsResult = $conn->query($brandsQuery);

            while ($row = $brandsResult->fetch_assoc()) {
                echo '<li><a href="brand.php?brand=' . urlencode($row['Brand']) . '">' . htmlspecialchars($row['Brand']) . '</a></li>';
            }
            ?>
        </ul>
    </div>
</body>
</html>
