<?php

$patientBcn = $_GET['rc'] ?? '';
$action = $_GET['action'] ?? '';
$data = null;
$connectionError = false;

if ($action === 'search' && $patientBcn !== '') {
    $apiUrl = "http://localhost/api/api.php?rc=" . urlencode($patientBcn);
} elseif ($action === 'all') {
    $apiUrl = "http://localhost/api/api.php";
}

if (isset($apiUrl)) {
    $jsonResponse = @file_get_contents($apiUrl);

    if ($jsonResponse === false) {
        $connectionError = true;
    } else {
        $data = json_decode($jsonResponse, true);
    }

    if ($data === null) {
        die("<h3 style='color:red'>Kritická chyba: API nevrátilo JSON!</h3><p>Odpověď API:</p><pre style='background:#eee;padding:10px;'>" . htmlspecialchars($jsonResponse) . "</pre>");
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>IS ČSSZ</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #e9ecef; }
        .hlavicka { background: #0056b3; color: white; padding: 15px; border-radius: 8px 8px 0 0; }
        .karta { background: white; padding: 20px; border-radius: 0 0 8px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;}
        .nemocny { color: #d9534f; font-weight: bold; }
        .zdravy { color: #5cb85c; font-weight: bold; }
        .form-group { margin-bottom: 15px; }
        input[type="text"] { padding: 8px; width: calc(100% - 15px); box-sizing: border-box; margin-bottom: 10px; }
        button { padding: 9px 15px; background: #0056b3; color: white; border: none; cursor: pointer; border-radius: 4px; }
        button:hover { background: #004494; }
        .btn-secondary { background: #4da3ff; }
        .btn-secondary:hover { background: #1a8cff; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #f8f9fa; }
    </style>
</head>
<body>
<div style="max-width: 600px; margin: 0 auto;">
    <div class="hlavicka">
        <h2 style="margin: 0;">Informační systém ČSSZ</h2>
        <small>Modul: Správa pracovních neschopností (DPN)</small>
    </div>
    <div class="karta">
        <form method="GET" action="">
            <div class="form-group">
                <label for="rc">Zadejte rodné číslo pojištěnce (pro konkrétní dotaz):</label><br>
                <input type="text" id="rc" name="rc" value="<?= htmlspecialchars($patientBcn) ?>" placeholder="např. 0010195636">
            </div>
            <div>
                <button type="submit" name="action" value="search">Lustrovat osobu</button>
                <button type="submit" name="action" value="all" class="btn-secondary" style="float: right;">Zobrazit všechny aktivní</button>
            </div>
        </form>

        <?php if ($connectionError): ?>
            <hr style="margin-top: 25px;">
            <p style="color: red;"><strong>Chyba sítě:</strong> Nelze se spojit s API registru (Chirurgická ambulance).</p>

        <?php elseif ($data !== null): ?>
            <hr style="margin-top: 25px;">
            <h3>Výsledek dotazu:</h3>

            <?php if (isset($data['status']) && $data['status'] === 'success'): ?>

                <?php if ($action === 'all'): ?>
                    <p>Nalezeno aktivních neschopenek v evidenci: <strong><?= $data['count'] ?></strong></p>
                    <?php if ($data['count'] > 0): ?>
                        <table>
                            <tr>
                                <th>Rodné číslo</th>
                                <th>Počátek neschopnosti</th>
                            </tr>
                            <?php foreach ($data['data'] as $zaznam): ?>
                                <tr>
                                    <td><?= htmlspecialchars($zaznam['patient_id']) ?></td>
                                    <td><?= date("d.m.Y", strtotime($zaznam['start_date'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>

                <?php elseif ($action === 'search'): ?>
                    <p>Pojištěnec RČ: <strong><?= htmlspecialchars($patientBcn) ?></strong></p>
                    <?php if ($data['count'] > 0): ?>
                        <p>Stav DPN: <span class="nemocny">Aktivní neschopnost</span></p>
                        <p>Počátek neschopnosti: <strong><?= date("d.m.Y", strtotime($data['data'][0]['start_date'])) ?></strong></p>
                    <?php else: ?>
                        <p>Stav DPN: <span class="zdravy">Neaktivní (práce schopný)</span></p>
                    <?php endif; ?>
                <?php endif; ?>

            <?php else: ?>
                <p style="color: red;">Chyba datové struktury API.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
