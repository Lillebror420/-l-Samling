<?php
require('db.php');

// Aktivér fejldebugging (fjern i produktion)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Tjek om 'brand' parameter er sat
if (!isset($_GET['brand'])) {
    die("Fejl: Ingen brand valgt.");
}

// Beskyt mod SQL-injektion
$brand = $conn->real_escape_string($_GET['brand']);

// Hent data for det valgte brand
$query = "SELECT * FROM samler_vanvid WHERE Brand = '$brand'";
$result = $conn->query($query);

if (!$result) {
    die("Fejl ved forespørgsel: " . $conn->error);
}

// Funktion til at generere flag-emoji baseret på landekode
function countryFlagEmoji($countryCode)
{
    if (!$countryCode) return '🏳️';
    return implode('', array_map(
        fn($char) => mb_chr(ord($char) + 127397),
        str_split(strtoupper($countryCode))
    ));
}
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkter fra <?php echo htmlspecialchars($brand); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #4caf50;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #4caf50;
            color: white;
        }

        .image-cell img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }

        .details-row {
            display: none; /* Skjuler detaljerne som standard */
        }

        .details-content {
            padding: 10px;
        }

        .back-link {
            display: block;
            margin: 15px 0;
            text-decoration: none;
            color: #4caf50;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .main-row:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>Produkter fra <?php echo htmlspecialchars($brand); ?></h1>
    </header>
    <div class="container">
        <a href="landing.php" class="back-link">← Tilbage til oversigten</a>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Bryghus 🍺</th>
                    <th>Collection 📝</th>
                    <th class="udlob-cell">Udløb 📅</th>
                    <th>Billede 📸</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="main-row" onclick="toggleDetails(this)">
                        <td><?php echo htmlspecialchars($row['Brand'] ?? 'INGEN DATA'); ?></td>
                        <td><?php echo htmlspecialchars($row['Collection'] ?? 'INGEN DATA'); ?></td>
                        <td><?php echo $row['Udlob'] ? date('d-m-Y', strtotime($row['Udlob'])) : 'Uden dato 📅'; ?></td>
                        <td class="image-cell">
                            <img src="<?php echo htmlspecialchars($row['Img'] ?? 'assets/Billede-på-vej.png'); ?>" alt="Billede af <?php echo htmlspecialchars($row['Collection'] ?? 'produkt'); ?>">
                        </td>
                    </tr>
                    <tr class="details-row">
                        <td colspan="4">
                            <div class="details-content">
                                <p><strong>ID:</strong> <?php echo htmlspecialchars($row['ID'] ?? 'INGEN DATA'); ?></p>
                                <p><strong>Placering:</strong> <?php echo htmlspecialchars($row['Placering'] ?? 'INGEN DATA'); ?></p>
                                <p><strong>Land:</strong> <?php echo countryFlagEmoji($row['Land'] ?? '') . ' (' . htmlspecialchars($row['Land'] ?? 'INGEN DATA') . ')'; ?></p>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Ingen produkter fundet for dette brand.</p>
        <?php endif; ?>
    </div>

    <script>
        function toggleDetails(row) {
            // Find næste søskende element (detaljerækken)
            const nextRow = row.nextElementSibling;
            if (nextRow && nextRow.classList.contains('details-row')) {
                // Skift synlighed
                nextRow.style.display = nextRow.style.display === 'table-row' ? 'none' : 'table-row';
            }
        }
    </script>
</body>
</html>
