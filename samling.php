<!DOCTYPE html>
<html>
<head>
    <title>Øl Samling</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        .container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    /* overflow-x: auto; */
}

table {
    width: auto;
    table-layout: auto;
    max-width: 100%;
    margin: 0 auto; /* Add this line to center the table */
    border-collapse: collapse;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-height: 80%; /* Set a maximum height to allow scrolling */
    overflow-y: auto; /* Enable vertical scrolling if content overflows */
}

/* Style the scrollbar */
table::-webkit-scrollbar {
    width: 10px; /* Width of the scrollbar */
}

table::-webkit-scrollbar-track {
    background-color: #f1f1f1; /* Track color */
}

table::-webkit-scrollbar-thumb {
    background-color: #888; /* Thumb color */
    border-radius: 5px; /* Rounded corners */
}

table::-webkit-scrollbar-thumb:hover {
    background-color: #555; /* Hover state */
}

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
            color: #333;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .image-cell {
            width: 120px;
            height: 120px;
            overflow: hidden;
            border-radius: 10px;
            background-color: #f5f5f5;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .image-cell img {
            width: 100%;
            height: auto;
        }
        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-input {
            padding: 8px;
            width: 300px;
            border-radius: 5px;
            border: none;
            background-color: #fff;
            font-size: 14px;
        }
        .search-buttons {
            margin-top: 10px;
        }
        .search-buttons button {
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            background-color: #333;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
        }
        h1, h2 {
            color: #333;
            margin-bottom: 20px;
        }
        /* Adjusted width for Udløb column */
        .udlob-cell {
            width: 120px;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .details-row {
            display: none;
            background-color: #f0f0f0;
        }
        .show-details {
            display: table-row;
        }
        .main-row:hover {
            cursor: pointer;
        }
        .search-dropdown {
            padding: 8px;
            border-radius: 5px;
            border: none;
            background-color: #fff;
            font-size: 14px;
            width: 300px;
            color: #333;
        }
        .filter-button {
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            background-color: #333;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
        }
        .modal {
    display: none;
    position: fixed; /* Change to fixed */
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

/* Style the modal content */
.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    border-radius: 10px;
    width: 60%;
    max-height: 80%; /* Set a maximum height to allow scrolling */
    overflow-y: auto; /* Enable vertical scrolling if content overflows */
}

/* Style the scrollbar */
.modal-content::-webkit-scrollbar {
    width: 10px; /* Width of the scrollbar */
}

.modal-content::-webkit-scrollbar-track {
    background-color: #f1f1f1; /* Track color */
}

.modal-content::-webkit-scrollbar-thumb {
    background-color: #888; /* Thumb color */
    border-radius: 5px; /* Rounded corners */
}

.modal-content::-webkit-scrollbar-thumb:hover {
    background-color: #555; /* Hover state */
}



.close-button {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close-button:hover,
.close-button:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.brand-count h3,
.date-range h3 {
    margin-top: 0;
}

.brand-count p,
.date-range p {
    margin: 5px 0;
}

    </style>
</head>
<body>
    <header>
        <h1 style="color: #fff;">🍺 Øl Samling 🍺</h1>
    </header>
    <!-- Link to trigger the loading screen -->
    <!-- <a href="loading.html">Open Loading Screen</a> -->
    <div class="container">
    <div class="search-container">
    <h2>Søg efter en bestemt øl</h2>
    <form method="GET">
        <input type="text" name="search" class="search-input" placeholder="Søg efter en øl... 🍺">
        <div class="search-buttons">
            <button type="submit">Søg</button>
            <button type="reset" onclick="window.location.href = window.location.pathname;">Nulstil</button>
            
        </div>
    </form>
    <div style="margin-top: 40px;"></div> <!-- Add some spacing here -->
    <form method="GET">
        <select name="brand" class="search-dropdown">
            <option value="">Vælg Brand 🍺</option>
       <?php
            require('db.php');

            // Retrieve distinct brands from the database
            $brandQuery = "SELECT DISTINCT Brand FROM samler_vanvid";
            $brandResult = $conn->query($brandQuery);

            while ($brandRow = $brandResult->fetch_assoc()) {
                $brand = $brandRow['Brand'];
                echo '<option value="' . $brand . '">' . $brand . '</option>';
            }

            $conn->close();
            ?>
        </select>
        <button type="submit" class="filter-button">Filtrer Brand</button>
    </form>
</div>
<button id="stats-button" class="filter-button">Vis Statistik</button>
<div id="stats-modal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Statistik</h2>
            <div class="brand-count">
                <h3>Antal af hver øl mærke:</h3>
                <?php
                require('db.php');

                $brandQuery = "SELECT DISTINCT Brand, COUNT(*) AS Count FROM samler_vanvid GROUP BY Brand";
                $brandResult = $conn->query($brandQuery);

                while ($brandRow = $brandResult->fetch_assoc()) {
                    $brand = $brandRow['Brand'];
                    $count = $brandRow['Count'];
                    echo "<p>$brand: $count</p>";
                }

                $conn->close();
                ?>
            </div>
            <div class="total-count">
                <h3>Total antal øl:</h3>
                <?php
                require('db.php');

                $totalCountQuery = "SELECT COUNT(*) AS TotalCount FROM samler_vanvid";
                $totalCountResult = $conn->query($totalCountQuery);
                $totalCountRow = $totalCountResult->fetch_assoc();
                $totalCount = $totalCountRow['TotalCount'];

                echo "<p>$totalCount</p>";

                $conn->close();
                ?>
            </div>
        </div>
        
    </div>
</div>

<?php
function countryFlagEmoji($countryCode) {
    if (!$countryCode) return 'INGEN DATA'; // Hvis der ikke er en landekode

    // Sørg for, at landekoden er to bogstaver og store bogstaver
    $countryCode = strtoupper($countryCode);

    // Omregn landekoden til flag-emoji ved at omdanne hvert bogstav til et Unicode-regional indikator symbol
    $flag = '';
    foreach (str_split($countryCode) as $letter) {
        $flag .= mb_chr(ord($letter) + 127397);
    }
    
    return $flag;
}

require('db.php');

$search = isset($_GET['search']) ? $_GET['search'] : '';
$selectedBrand = isset($_GET['brand']) ? $_GET['brand'] : '';

$sql = "SELECT * FROM samler_vanvid";
$whereClause = "";
if ($search !== '') {
   $whereClause .= " WHERE Brand LIKE '%$search%' OR Collection LIKE '%$search%'";
}
if ($selectedBrand !== '') {
   $whereClause .= ($whereClause !== '' ? ' AND ' : ' WHERE ') . "Brand = '$selectedBrand'";
}

if ($whereClause !== '') {
   $sql .= $whereClause;
}
$sql .= " ORDER BY Brand, Udlob";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr><th>Bryghus 🍺 </th><th>Collection 📝</th><th class="udlob-cell">Udløb 📅</th><th>Billede 📸</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr class="main-row">';
        echo '<td>' . ($row['Brand'] ?? 'INGEN DATA') . '</td>';
        echo '<td>' . ($row['Collection'] ?? 'INGEN DATA') . '</td>';
        echo '<td>' . ($row['Udlob'] ? date('d-m-Y', strtotime($row['Udlob'])) : 'Uden dato 📅') . '</td>';
        echo '<td class="image-cell"><img src="' . ($row['Img'] ?? 'assets/Billede-på-vej.png') . '" alt="Image"></td>';
        echo '</tr>';

        echo '<tr class="details-row">';
        echo '<td colspan="4">';
        echo '<div class="details-content">';
        echo '<p><strong>ID:</strong> ' . ($row['ID'] ?? 'INGEN DATA') . '</p>';
        echo '<p><strong>Placering:</strong> ' . ($row['Placering'] ?? 'INGEN DATA') . '</p>';
        echo '<p><strong>Land:</strong> ' . countryFlagEmoji($row['Land']) . ' (' . ($row['Land'] ?? 'INGEN DATA') . ')</p>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'Ingen data fundet.';
}

$conn->close();
?>

    </div>
    <script>
        // JavaScript code for effects
        const mainRows = document.querySelectorAll('.main-row');

        // Row expansion effect
        mainRows.forEach(row => {
            row.addEventListener('click', () => {
                const detailsRow = row.nextElementSibling;
                detailsRow.classList.toggle('show-details');
            });
        });

            // JavaScript code for modal behavior
    const statsButton = document.getElementById('stats-button');
    const modal = document.getElementById('stats-modal');
    const closeButton = document.querySelector('.close-button');

    statsButton.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    closeButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    </script>
</body>
</html>