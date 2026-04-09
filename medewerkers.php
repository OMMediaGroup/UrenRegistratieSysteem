<?php
require __DIR__ . '/vendor/autoload.php';

// Laden van .env variabelen
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Haal variabelen op uit .env
$Host     = $_ENV['DB_HOST'];
$Username = $_ENV['DB_USERNAME'];
$Password = $_ENV['DB_PASSWORD'];
$Dbname   = $_ENV['DB_NAME'];
$Port     = $_ENV['DB_PORT'] ?? 3306; // Gebruik 3306 als er geen poort is ingevuld

// Verbinding maken (Poort als 5e argument is stabieler)
$conn = @new mysqli($Host, $Username, $Password, $Dbname, $Port);

// Check verbinding
if ($conn->connect_error) {
    // Tip: Controleer of je DB_HOST in .env op '127.0.0.1' staat als je lokaal werkt
    die("Connectie mislukt: " . $conn->connect_error);
}

// SQL voor medewerkers-tabel
$sql = "SELECT `ID`, `Voornaam`, `Achternaam`, `Email`, `Telefoonnummer`, `Functie`, `Afdeling` FROM `Medewerkers`";
$result = $conn->query($sql);

if (!$result) {
    die("SQL-fout: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerkers</title>
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
            width: 85%;
            padding: 30px;
            border-radius: 20px;
            border: 4px solid #083c32;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
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
        }
        /* Zoekveld */
        .searchbar {
            background: white;
            border-radius: 20px;
            padding: 8px 15px;
            border: 2px solid #083c32;
            display: flex;
            align-items: center;
        }
        .searchbar input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 15px;
            margin-right: 5px;
        }
        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            text-align: left;
            background: #d7e9dd;
            border-bottom: 3px solid #083c32;
            padding: 12px;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
        }
        table tr:hover {
            background: #f1f8f3;
        }
        /* PDF knop */
        .pdf-btn {
            background: #b30000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        .pdf-btn:hover {
            background: #8a0000;
        }
        /* Print-specifieke styling */
        @media print {
            nav, .searchbar, .pdf-btn { display: none !important; }
            body { background: white !important; }
            .container { border: none; width: 100%; margin: 0; padding: 0; }
            table th { background: #d7e9dd !important; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body>

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
        <h1>Medewerkers</h1>
        <button class="pdf-btn" onclick="window.print()">Opslaan als PDF</button>
        <div class="searchbar">
            <input type="text" id="search" placeholder="Zoeken..."> 🔍
        </div>
    </div>

    <table id="dataTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Email</th>
                <th>Telefoonnummer</th>
                <th>Functie</th>
                <th>Afdeling</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Voornaam']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Achternaam']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Telefoonnummer']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Functie']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Afdeling']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Geen medewerkers gevonden</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
// Zoekfunctie die alleen in de tbody zoekt
document.getElementById("search").addEventListener("input", function () {
    const val = this.value.toLowerCase();
    const rows = document.querySelectorAll("#dataTable tbody tr");
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(val) ? "" : "none";
    });
});
</script>

</body>
</html>
<?php 
$conn->close(); 
?>