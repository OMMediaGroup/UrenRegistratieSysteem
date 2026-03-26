<?php
$host = '192.168.11.30:3306'; // IP van je Ubuntu server
$db   = 'userstory_bedrijfsgegevens';
$user = 'medewerker';
$pass = 'Luckiness-Zebra-Carefully8'; 

$rijen = []; 

try {
    // Verbinding maken met de database
    $options = [PDO::ATTR_TIMEOUT => 5, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    // Let op: :3306 hoeft meestal niet in de host string als het standaard is, maar mag wel.
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$db;charset=utf8mb4", $user, $pass, $options);

    $stmt = $pdo->query("SELECT * FROM Werkzaamheden");
    $rijen = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<div class='alert alert-danger no-print'>Fout: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Werkzaamheden Overzicht</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Zorgt dat de zoekbalk en knoppen niet op de PDF komen */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
            .container {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body class="p-5">
    <div class="container">
        <h1 class="mb-4">Werkzaamheden Lijst</h1>

        <div class="mb-3 no-print">
            <input type="text" id="zoekInput" class="form-control" placeholder="Zoek op medewerker, opdracht of omschrijving...">
        </div>

        <div class="mb-3 no-print">
            <button onclick="window.print()" class="btn btn-danger">Opslaan als PDF</button>
        </div>

        <table class="table table-striped border mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Medewerker</th>
                    <th>Opdracht</th>
                    <th>Omschrijving</th>
                </tr>
            </thead>
            <tbody id="werkTabel">
                <?php foreach($rijen as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['ID']); ?></td>
                        <td><?= htmlspecialchars($r['Voornaam'] . " " . $r['Achternaam']); ?></td>
                        <td><?= htmlspecialchars($r['Opdracht titel']); ?></td>
                        <td><?= htmlspecialchars($r['Omschrijving werkzaamheden']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if(empty($rijen)): ?>
                    <tr><td colspan="4" class="text-center">Geen gegevens gevonden.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('zoekInput').addEventListener('keyup', function() {
            const waarde = this.value.toLowerCase();
            const rijen = document.querySelectorAll('#werkTabel tr');

            rijen.forEach(rij => {
                const tekst = rij.innerText.toLowerCase();
                if (tekst.includes(waarde)) {
                    rij.style.display = '';
                } else {
                    rij.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
