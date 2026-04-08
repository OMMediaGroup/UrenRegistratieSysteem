<?php
// 1. Laden van de database variabelen via Dotenv
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$Servername = $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'];
$Username   = $_ENV['DB_USERNAME'];
$Password   = $_ENV['DB_PASSWORD'];
$Dbname     = $_ENV['DB_NAME'];

// 2. Verbinding maken met mysqli
$conn = new mysqli($Servername, $Username, $Password, $Dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Query specifiek voor Werkzaamheden
$sql = "SELECT 
            `ID`, 
            `Voornaam`, 
            `Achternaam`, 
            `Opdracht titel`, 
            `Omschrijving werkzaamheden` 
        FROM `Werkzaamheden`";

$result = $conn->query($sql);

if (!$result) {
    die("SQL-fout: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Werkzaamheden Overzicht</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* ACHTERGROND & BASIS */
        body {
            margin: 0;
            padding: 0;
            background-color: #003d29; 
            background-image: linear-gradient(rgba(0, 61, 41, 0.9), rgba(0, 61, 41, 0.9)), 
                              url('https://www.transparenttextures.com/patterns/matrix.png');
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

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


        /* DE WITTE KAART */
        .container-main {
            display: flex;
            justify-content: center;
            padding: 40px 0;
        }

        .main-card {
            background-color: #e8f7ee; 
            width: 90%;
            max-width: 1100px;
            border-radius: 40px; 
            border: 4px solid #083c32;
            padding: 40px;
            box-shadow: 0px 10px 30px rgba(0,0,0,0.5);
        }

        /* HEADER RIJ */
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            font-weight: 900;
            font-size: 35px;
            margin: 0;
            text-transform: lowercase;
        }

        /* ZOEKBALK */
        .searchbar {
            background: white;
            border-radius: 50px;
            padding: 8px 20px;
            border: 2px solid #083c32;
            display: flex;
            align-items: center;
            width: 300px;
        }

        .searchbar input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 16px;
        }

        /* PDF KNOP */
        .pdf-btn {
            background: #b30000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        /* TABEL STIJL */
        .table-container {
            border: 2px solid #083c32;
            background: #fff;
            border-radius: 5px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #d7e9dd;
            border-bottom: 3px solid #083c32;
            padding: 12px;
            text-align: left;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
        }

        /* PRINT SETTINGS */
        @media print {
            nav, .searchbar, .pdf-btn { display: none !important; }
            body { background: white !important; }
            .main-card { border: none; width: 100%; box-shadow: none; padding: 0; }
        }
    </style>
</head>
<body>

<nav class="no-print">
    <div class="links">
        <a href="index.php">home</a>
        <a href="medewerkers.php">medewerkers</a>
        <a href="klanten.php">klanten</a>
        <a href="werkzaamheden.php" class="active">werkzaamheden</a>
        <a href="uren.php">uren</a>
        <a href="werkgevers.php">werkgevers</a>
        <a href="opdrachten.php">opdrachten</a>
    </div>
</nav>

<div class="container-main">
    <div class="main-card">
        
        <div class="header-row no-print">
            <h1>werkzaamheden</h1>
            
            <button class="pdf-btn" onclick="window.print()">Opslaan als PDF</button>

            <div class="searchbar">
                <input type="text" id="search" placeholder="zoeken..."> 🔍
            </div>
        </div>

        <div class="table-container">
            <table id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Medewerker</th>
                        <th>Opdracht</th>
                        <th>Omschrijving</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Voornaam'] . " " . $row['Achternaam']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Opdracht titel']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Omschrijving werkzaamheden']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Geen werkzaamheden gevonden</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
// Zoekfunctie
document.getElementById("search").addEventListener("input", function () {
    const val = this.value.toLowerCase();
    const rows = document.querySelectorAll("#dataTable tbody tr");
    
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(val) ? "" : "none";
    });
});
</script>

</body>
</html>

<?php 
$conn->close(); 
?>