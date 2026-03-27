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
        justify-content: space-between;
        border-bottom: 3px solid #0a4f42;
    }

    nav .links a {
        margin-right: 25px;
        color: #000;
        font-weight: bold;
        text-decoration: none;
        border-right: 2px solid #0a4f42;
        padding-right: 15px;
    }
    nav .links a:last-child {
        border-right: none;
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
        margin-top: 25px;
        border-collapse: collapse;
        background: white;
    }

    table th {
        background: #d7e9dd;
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
</style>

</head>
<body>

<!-- Navigatie -->
<nav>
    <div class="links">
        <a href="#">home</a>
        <a href="#">medewerkers</a>
        <a href="#">klanten</a>
        <a href="#">werkzaamheden</a>
        <a href="#">uren</a>
        <a href="#">werkgevers</a>
        <a href="#">opdrachten</a>
    </div>

    <div class="searchbar">
        <input type="text" placeholder="zoeken...">
        🔍
    </div>
</nav>

<!-- Klanten container -->
<div class="container">

    <div class="title-row">
        <h1><span class="title-icon">👥</span> klanten</h1>

        <div class="searchbar">
            <input type="text" placeholder="zoeken...">
            🔍
        </div>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Bedrijf naam</th>
            <th>Voornaam</th>
            <th>Tussenvoegsel</th>
            <th>Achternaam</th>
            <th>Functie</th>
            <th>Email</th>
            <th>Telefoon nummer</th>
            <th>Adres</th>
        </tr>

        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['ID']."</td>";
                echo "<td>".$row['Bedrijf naam']."</td>";
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

</body>
</html>

<?php $conn->close(); ?>
