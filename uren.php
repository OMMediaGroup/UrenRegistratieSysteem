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

$sql = "SELECT
            `ID`,
            `Voornaam`,
            `Tussenvoegsel`,
            `Achternaam`,
            `Aantal gewerkte uren`
        FROM `Uren`";

$result = $conn->query($sql);

if (!$result) {
    die("SQL-fout: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title>Uren</title>

<style>

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #0a4f42; /* ✔ effen achtergrondkleur */
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
    margin: 0;
    padding-right: 15px;
    padding-left: 15px;
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

/* Koptekst */

.title-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.title-icon {
    font-size: 35px;
    margin-right: 10px;
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
    padding: 10px;
    text-align: left;
}

table td {
    padding: 10px;
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
    margin-bottom: 8px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
}

.pdf-btn:hover {
    background: #8a0000;
}

/* Styling voor het afdrukken / opslaan als PDF */

@media print {

    nav,
    .searchbar,
    .pdf-btn {
        display: none !important;
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
        <h1>Uren</h1>

        <div class="searchbar">
            <input type="text" id="search" placeholder="zoeken..."> 🔍
        </div>
    </div>

    <button class="pdf-btn" onclick="window.print()">Opslaan als PDF</button>

    <table id="dataTable">
        <tr>
            <th>ID</th>
            <th>Voornaam</th>
            <th>Tussenvoegsel</th>
            <th>Achternaam</th>
            <th>Aantal gewerkte uren</th>
        </tr>

        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['ID']}</td>";
                echo "<td>{$row['Voornaam']}</td>";
                echo "<td>{$row['Tussenvoegsel']}</td>";
                echo "<td>{$row['Achternaam']}</td>";
                echo "<td>{$row['Aantal gewerkte uren']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Geen uren gevonden</td></tr>";
        }
        ?>
    </table>

</div>

<script>
// Zoekfunctie
document.getElementById("search").addEventListener("input", function () {
    const val = this.value.toLowerCase();
    document.querySelectorAll("#dataTable tr").forEach((row, i) => {
        if (i === 0) return;
        row.style.display = row.textContent.toLowerCase().includes(val) ? "" : "none";
    });
});
</script>

</body>
</html>

<?php $conn->close(); ?>