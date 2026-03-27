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
    <title>Werkzaamheden Overzicht</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* DE ACHTERGROND (MATRIX STIJL) */
        body {
            margin: 0;
            padding: 0;
            background-color: #003d29;
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        /* NAVIGATIE BALK STIJLING */
        .custom-nav {
            background-color: #fff;
            border: 3px solid #000;
            border-radius: 50px;
            margin: 20px auto;
            max-width: 1100px;
            padding: 10px 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap; /* Voor als het scherm klein is */
        }

        .nav-link-custom {
            color: #000;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 25px;
            transition: 0.3s;
            border: 2px solid transparent;
        }

        .nav-link-custom:hover {
            background-color: #e9ecef;
            border: 2px solid #000;
        }

        /* De actieve pagina (werkzaamheden) krijgt een zwarte achtergrond */
        .nav-link-custom.active {
            background-color: #000;
            color: #fff;
            border: 2px solid #000;
        }

        /* CONTENT KAART */
        .content-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 50px;
        }

        .main-card {
            background-color: rgba(247, 255, 249, 0.95); 
            width: 95%;
            max-width: 1100px;
            border-radius: 50px 50px 0 0; 
            border: 3px solid #000;
            padding: 40px;
            box-shadow: 0px 0px 40px rgba(0, 0, 0, 0.6);
        }

        /* HEADER ONDERDELEN */
        .header-row { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; }
        .logo { width: 70px; height: 70px; border: 2px solid #7a5dfa; background: white; display: flex; justify-content: center; align-items: center; }
        h1 { font-weight: 900; font-size: 3rem; margin: 0; flex-grow: 1; letter-spacing: -1px; text-transform: lowercase; }
        .search-bar { border-radius: 50px; border: 2px solid #000; padding: 10px 25px; width: 250px; outline: none; }

        .table-container { border: 2px solid #000; background: #fff; border-radius: 10px; overflow: hidden; }

        @media print { .no-print { display: none !important; } body { background: white !important; } }
    </style>
</head>
<body>

    <div class="content-wrapper">
        
        <nav class="custom-nav no-print">
            <a href="index.php" class="nav-link-custom">home</a>
            <a href="klanten.php" class="nav-link-custom">klanten</a>
            <a href="medewerkers.php" class="nav-link-custom">medewerkers</a>
            <a href="opdrachten.php" class="nav-link-custom">opdrachten</a>
            <a href="uren.php" class="nav-link-custom">uren</a>
            <a href="werkgevers.php" class="nav-link-custom">werkgevers</a>
            <a href="werkzaamheden.php" class="nav-link-custom active">werkzaamheden</a>
        </nav>

        <div class="main-card">
            <div class="header-row no-print">
                <div class="logo">
                    <img src="https://cdn-icons-png.flaticon.com/512/2666/2666505.png" width="45" alt="logo">
                </div>
                <h1>werkzaamheden</h1>
                <input type="text" id="zoekInput" class="search-bar" placeholder="Zoeken...">
            </div>

            <button onclick="window.print()" class="btn btn-dark mb-4 no-print">Opslaan als PDF</button>

            <div class="table-container">
                <table class="table table-hover m-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Medewerker</th>
                            <th>Opdracht</th>
                            <th>Omschrijving</th>
                        </tr>
                    </thead>
                    <tbody id="werkTabel">
                        <?php if(!empty($rijen)): ?>
                            <?php foreach($rijen as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['ID']); ?></td>
                                <td><?= htmlspecialchars($r['Voornaam'] . " " . $r['Achternaam']); ?></td>
                                <td><?= htmlspecialchars($r['Opdracht titel']); ?></td>
                                <td><?= htmlspecialchars($r['Omschrijving werkzaamheden']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Zoekfunctie
        document.getElementById('zoekInput').onkeyup = function() {
            let waarde = this.value.toLowerCase();
            document.querySelectorAll('#werkTabel tr').forEach(rij => {
                rij.style.display = rij.innerText.toLowerCase().includes(waarde) ? '' : 'none';
            });
        };
    </script>
</body>
</html>