<?php
// 1. Database verbinding
$host = '192.168.11.30'; 
$db   = 'userstory_bedrijfsgegevens';
$user = 'medewerker';
$pass = 'Luckiness-Zebra-Carefully8'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    $rijen = $pdo->query("SELECT * FROM Werkzaamheden")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $fout = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Werkzaamheden</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* De donkergroene achtergrond (Matrix stijl) */
        body {
            background-color: #003d29; 
            background-image: linear-gradient(rgba(0, 61, 41, 0.9), rgba(0, 61, 41, 0.9)), 
                              url('https://www.transparenttextures.com/patterns/matrix.png');
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
        }

        /* Het witte vlak in het midden */
        .main-card {
            background-color: #f0fdf4; /* Heel lichtgroen/wit */
            width: 90%;
            max-width: 1000px;
            border-radius: 40px 40px 0 0; /* Ronde hoeken bovenop */
            border: 2px solid #000;
            padding: 30px;
            min-height: 80vh;
        }

        /* Header met logo, titel en zoekbalk op één lijn */
        .header-row {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
            border: 2px solid #7a5dfa; /* Paarse rand uit je plaatje */
            padding: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            font-family: sans-serif;
            font-weight: bold;
            font-size: 3rem;
            margin: 0;
            flex-grow: 1;
        }

        /* De zoekbalk stijl uit je plaatje */
        .search-container {
            position: relative;
            width: 300px;
        }

        .search-bar {
            border-radius: 25px;
            border: 2px solid #000;
            padding: 10px 20px;
            width: 100%;
        }

        /* De tabelstijl */
        .table-container {
            border: 2px solid #000;
            background: #fff;
        }

        .table thead {
            background-color: #e9e9e9;
        }

        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>

    <div class="main-card">
        <div class="header-row no-print">
            <div class="logo">
                <img src="https://cdn-icons-png.flaticon.com/512/2666/2666505.png" width="60" alt="logo">
            </div>
            <h1>werkzaamheden</h1>
            <div class="search-container">
                <input type="text" id="zoekInput" class="search-bar" placeholder="Zoeken...">
            </div>
        </div>

        <button onclick="window.print()" class="btn btn-outline-dark mb-3 no-print">Opslaan als PDF</button>

        <div class="table-container">
            <table class="table table-bordered m-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Medewerker</th>
                        <th>Opdracht</th>
                        <th>Omschrijving</th>
                    </tr>
                </thead>
                <tbody id="werkTabel">
                    <?php if(isset($rijen)): ?>
                        <?php foreach($rijen as $r): ?>
                        <tr>
                            <td><?= $r['ID']; ?></td>
                            <td><?= $r['Voornaam'] . " " . $r['Achternaam']; ?></td>
                            <td><?= $r['Opdracht titel']; ?></td>
                            <td><?= $r['Omschrijving werkzaamheden']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // De zoekfunctie
        document.getElementById('zoekInput').onkeyup = function() {
            let waarde = this.value.toLowerCase();
            document.querySelectorAll('#werkTabel tr').forEach(rij => {
                rij.style.display = rij.innerText.toLowerCase().includes(waarde) ? '' : 'none';
            });
        };
    </script>
</body>
</html>
