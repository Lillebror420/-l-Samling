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
    <title>🍻 Øl fra <?php echo htmlspecialchars($brand); ?> 🍻</title>
    <link rel="icon" type="image/x-icon" href="assets/favicons/brand.png">
    <link rel="stylesheet" href="assets/css/brand.css?v=<?php echo time(); ?>">
    <script src="brandModal.js"></script>
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
                            <img src="<?php echo htmlspecialchars($row['Img'] ?? 'assets/Billede-på-vej.png'); ?>" 
                                alt=" <?php echo htmlspecialchars($row['Collection'] ?? 'produkt'); ?>">
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
    <!-- Modal -->
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modalImage">
        <div id="caption"></div>
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
