<?php
require('db.php');

// Aktivér fejldebugging (fjern i produktion)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Håndter både brand og fejl
$brand = isset($_GET['brand']) ? $conn->real_escape_string($_GET['brand']) : null;
$fejl = isset($_GET['fejl']) ? (int)$_GET['fejl'] : null;

// Hvis hverken brand eller fejl er angivet, vis fejlbesked
if (!$brand && !$fejl) {
    die("Fejl: Ingen brand valgt.");
}

// Byg SQL-forespørgsel baseret på om vi filtrerer fejlflasker
if ($fejl === 1) {
    $query = "SELECT * FROM samler_vanvid WHERE rigtig_emballage = 0"; 
} else {
    $query = "SELECT * FROM samler_vanvid WHERE Brand = '$brand'";
}

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
    <title>Øl fra <?php echo htmlspecialchars($brand ?: 'Fejl Flasker'); ?> 🍻</title>
    <link rel="icon" type="image/x-icon" href="assets/media/favicons/brand.png">
    <link rel="stylesheet" href="assets/css/brand.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <h1><?php echo $result->num_rows; ?> øl fra <?php echo htmlspecialchars($brand ?: 'Flasker med fejl'); ?></h1>
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
                            <img src="<?php echo htmlspecialchars($row['Img'] ?? 'assets/media/Billede-på-vej.png'); ?>" 
                                alt=" <?php echo htmlspecialchars($row['Collection'] ?? 'produkt'); ?>">
                        </td>
                    </tr>
                    <tr class="details-row">
                        <td colspan="4">
                            <div class="details-content">
                                <p><strong>ID:</strong> <?php echo htmlspecialchars($row['ID'] ?? 'INGEN DATA'); ?></p>
                                <p><strong>Placering:</strong> <?php echo htmlspecialchars($row['Placering'] ?? 'INGEN DATA'); ?></p>
                                <p><strong>Land:</strong> <?php echo countryFlagEmoji($row['Land'] ?? '') . ' (' . htmlspecialchars($row['Land'] ?? 'INGEN DATA') . ')'; ?></p>
                                <p><strong>Korrekt Emballage:</strong> <?php echo $row['rigtig_emballage'] == 0 ? "❌" : "✅"; ?></p>
                                <p><strong>Beskrivelse af fejl:</strong> <?php echo htmlspecialchars($row['fejl_note'] ?? 'INGEN DATA'); ?></p>
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
        
    // Modal elementer
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");
    const captionText = document.getElementById("caption");
    const closeModal = document.querySelector(".close");

    // Åbn modal, når man klikker på billedet
    document.querySelectorAll(".image-cell img").forEach(img => {
        img.addEventListener("click", function(event) {
            // Forhindre række-foldning
            event.stopPropagation();

            // Åbn modal
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt; // Brug billedets alt-tekst som caption
        });
    });

    // Luk modal, når man klikker på luk-knappen
    closeModal.addEventListener("click", function() {
        modal.style.display = "none";
    });

    // Luk modal, når man klikker uden for billedet
    modal.addEventListener("click", function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    // Fold detaljer ud, når man klikker på en række
    function toggleDetails(row) {
        const nextRow = row.nextElementSibling;
        if (nextRow && nextRow.classList.contains('details-row')) {
            nextRow.style.display = nextRow.style.display === 'table-row' ? 'none' : 'table-row';
        }
    }
</script>

</body>
</html>

</body>
</html>

