<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$Servername = $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'];
$Username   = $_ENV['DB_USERNAME'];
$Password   = $_ENV['DB_PASSWORD'];
$Dbname     = $_ENV['DB_NAME'];

$conn = new mysqli($Servername, $Username, $Password, $Dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// === GEVONDEN SQL-FOUT: trailing comma verwijderd ===
$sql = "SELECT
            `ID`,
            `Klant naam`,
            `Titel`,
            `Omschrijving`,
            `Aanvraag datum`,
            `Benodigde kennis`
        FROM `Opdrachten`";     // ← hier stond een komma te veel

$result = $conn->query($sql);

if (!$result) {
    die("SQL-fout: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Opdrachten</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #0a4f42;
        }

        /* Navigatie */
        nav {
            background: #e8f7ee;
            padding: 15px;
            display: flex;
            justify-content: center;
            border-bottom: 3px solid #083c32;
        }
        nav .links a {
            margin: 0 18px;
            padding-right: 15px;
            color: #000;
            font-weight: bold;
            text-decoration: none;
            border-right: 2px solid #083c32;
        }
        nav .links a:last-child {
            border-right: none;
        }

        .container {
            background: #e8f7ee;
            margin: 40px auto;
            width: 80%;
            padding: 30px;
            border-radius: 20px;
            border: 4px solid #083c32;
        }

        .title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0;
            font-size: 30px;
            display: flex;
            align-items: center;
        }

        /* Zoekveld */
        .searchbar {
            background: white;
            border-radius: 20px;
            padding: 5px 10px;
            border: 2px solid #083c32;
            display: flex;
            align-items: center;
        }
        .searchbar input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 15px;
            width: 250px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        table th {
            position: sticky;
            top: 0;
            background: #d7e9dd;
            border-bottom: 3px solid #083c32;
            padding: 12px 10px;
            text-align: left;
        }
        table td {
            padding: 12px 10px;
            border-bottom: 1px solid #ccc;
        }
        table tr:hover {
            background: #f6f6f6;
        }

        /* PDF knop */
        .pdf-btn {
            background: #b30000;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        .pdf-btn:hover {
            background: #8a0000;
        }

        /* Print styling */
        @media print {
            nav, .searchbar, .pdf-btn { display: none !important; }
            body { background: white !important; margin: 10px; }
            .container {
                border: none;
                margin: 0;
                width: 100%;
                padding: 0;
            }
            table th {
                background: #d7e9dd !important;
                -webkit-print-color-adjust: exact;
                border-bottom: 2px solid #083c32 !important;
            }
        }
    </style>
</head>
<body>

<!-- Navigatie -->
<nav>
    <div class="links">
        <a href="index.php">home</a>
        <a href="medewerkers.php">medewerkers</a>
        <a href="klanten.php">klanten</a>
        <a href="werkzaamheden.php">werkzaamheden</a>
        <a href="uren.php">uren</a>
        <a href="werkgevers.php">werkgevers</a>
        <a href="opdrachten.php">opdrachten</a>
    </div>
</nav>

<div class="container">
    <div class="title-row">
        <h1>Opdrachten</h1>
        <button class="pdf-btn" onclick="window.print()">Opslaan als PDF</button>
        <div class="searchbar">
            <input type="text" id="search" placeholder="zoeken..."> 🔍
        </div>
    </div>

    <table id="dataTable">
        <tr>
            <th>ID</th>
            <th>Klant naam</th>
            <th>Titel</th>
            <th>Omschrijving</th>
            <th>Aanvraag datum</th>
            <th>Benodigde kennis</th>
        </tr>

        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['ID']}</td>";
                echo "<td>{$row['Klant naam']}</td>";
                echo "<td>{$row['Titel']}</td>";
                echo "<td>{$row['Omschrijving']}</td>";
                echo "<td>{$row['Aanvraag datum']}</td>";
                echo "<td>{$row['Benodigde kennis']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Geen opdrachten gevonden</td></tr>";
        }
        ?>
    </table>
</div>

<script>
// Zoekfunctie
document.getElementById("search").addEventListener("input", function () {
    const val = this.value.toLowerCase();
    document.querySelectorAll("#dataTable tr").forEach((row, i) => {
        if (i === 0) return; // header overslaan
        row.style.display = row.textContent.toLowerCase().includes(val) ? "" : "none";
    });
});
</script>

</body>
</html>

<?php $conn->close(); ?>