<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$Servername = $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'];
$Username   = $_ENV['DB_USERNAME'];
$Password   = $_ENV['DB_PASSWORD'];
$Dbname     = $_ENV['DB_NAME'];

// maak verbinding met de database
$conn = new mysqli($Servername, $Username, $Password, $Dbname);
// controleer de verbinding
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
$sql = "SELECT
            `ID`,
            `Bedijf naam`,
            `Voornaam`,
            `Tussenvoegsel`,
            `Achternaam`,
            `Functie`,
            `Email`,
            `Telefoon nummer`,
            `Address`
        FROM `Klanten`";

$result = $conn->query($sql);

if (!$result) {
    die("SQL-fout: " . $conn->error);
}

?>



<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #083c32;
        background-image: repeating-linear-gradient(
            0deg,
            rgba(255,255,255,0.05) 0px,
            rgba(255,255,255,0.05) 1px,
            transparent 1px,
            transparent 15px
        );
    }

    /* Navigatiebalk */
   nav {
    background: #e8f7ee;
    padding: 15px;
    display: flex;
    justify-content: center; /* navbar centreren */
    border-bottom: 3px solid #0a4f42;
}

nav .links a {
    margin: 0 20px;
    color: #000;
    font-weight: bold;
    text-decoration: none;
    border-right: 2px solid #0a4f42;
    padding-right: 15px;
}

nav .links a:last-child {
    border-right: none; /* laatste link zonder lijn */
}

    .searchbar {
        background: white;
        border-radius: 20px;
        padding: 5px 10px;
        border: 2px solid #0a4f42;
        display: flex;
        align-items: center;
    }
    .searchbar input {
        border: none;
        outline: none;
        font-size: 15px;
        padding-left: 5px;
        background: transparent;
    }

    /* Container */
    .container {
        background: #e8f7ee;
        margin: 40px auto;
        width: 80%;
        padding: 30px;
        border-radius: 20px;
        border: 4px solid #0a4f42;
    }

    /* Titel + icoon */
    .title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
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

    /* Tabel */
    table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

table th {
    position: sticky;
    top: 0;
    background: #d7e9dd !important;
    z-index: 2;
    padding: 10px;
    border-bottom: 3px solid #0a4f42;
}
table td {
    padding: 10px;
    border-bottom: 1px solid #cccccc;
}
table tr:hover {
    background: #f1f1f1;
}
@media print {

    /* Verberg elementen die niet in PDF moeten komen */
    nav,
    .searchbar {
        display: none !important;
    }

    /* Zorg dat de container mooi blijft */
    .container {
        margin: 0;
        width: 100%;
        box-shadow: none;
        border: none;
        padding: 0;
    }

    /* Fix tabel-borders & spacing in PDF */
    table {
        border-collapse: collapse !important;
        width: 100% !important;
    }

    table th {
        background: #d7e9dd !important;
        -webkit-print-color-adjust: exact;
        border-bottom: 2px solid #0a4f42 !important;
        position: static !important;  /* <— Belangrijk: sticky uitschakelen in print */
    }

    table td {
        border-bottom: 1px solid #ccc !important;
    }

    /* Pagina-vulling verminderen */
    body {
        margin: 10px;
        background: white !important;
    }
}
.pdf-btn {
    background: #b30000;           /* rood */
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 6px;                      /* ruimte tussen icoon en tekst */
}

.pdf-btn:hover {
    background: #8a0000;          /* donkerder rood */
}
``
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

<!-- Klanten container -->
<div class="container">

    <div class="title-row">
        <h1><span class="title-icon"></span> klanten</h1>
        <button class="pdf-btn" onclick="window.print()">🖨️ Als PDF opslaan</button>

        <div class="searchbar">
            <input type="text" placeholder="zoeken...">
            🔍
        </div>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Bedijf naam</th>
            <th>Voornaam</th>
            <th>Tussenvoegsel</th>
            <th>Achternaam</th>
            <th>Functie</th>
            <th>Email</th>
            <th>Telefoon nummer</th>
            <th>Adres</th>
        </tr>
</table>

<table>

        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['ID']."</td>";
                echo "<td>".$row['Bedijf naam']."</td>";
                echo "<td>".$row['Voornaam']."</td>";
                echo "<td>".$row['Tussenvoegsel']."</td>";
                echo "<td>".$row['Achternaam']."</td>";
                echo "<td>".$row['Functie']."</td>";
                echo "<td>".$row['Email']."</td>";
                echo "<td>".$row['Telefoon nummer']."</td>";
                echo "<td>".$row['Address']."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Geen gegevens gevonden</td></tr>";
        }
        ?>

    </table>
</div>
<script>
    // Zoekfunctie
    const searchInput = document.querySelector('.searchbar input');
    const tableRows = document.querySelectorAll('table tbody tr');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        tableRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(query) ? '' : 'none';
        });
    });
</script>
</body>
</html>

<?php $conn->close(); ?>
