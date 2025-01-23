<!DOCTYPE html>
<html>
<head>
    <title>Øl Samling - Brands</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1, h2 {
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        li {
            margin: 10px;
        }

        a {
            text-decoration: none;
            color: #fff;
            background-color: #4caf50;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        a:hover {
            background-color: #388e3c;
        }

        /* Mobile-friendly adjustments */
        @media (max-width: 600px) {
            a {
                font-size: 16px;
                padding: 8px 15px;
            }

            li {
                margin: 5px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>🍺 Velkommen til Øl Samlingen 🍺</h1>
    </header>
    <div class="container">
        <h2>Vælg et Bryghus</h2>
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
