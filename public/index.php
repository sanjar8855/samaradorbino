<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Models\ExampleModel;

$model = new ExampleModel;
$regions = $model->getAllRegions();
$wall_layer = $model->getAllWithCatId(1);
$window_layer = $model->getAllWithCatId(2);
$doorMaterials = $model->getAllWithCatId(3);
$doorMaterials2 = $model->getAllWithCatId(4);
$roofMaterials = $model->getAllWithCatId(5);

$report = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $b11 = $_POST['init_wall_type'];
    $c13 = $_POST['init_wall[1][thickness]'];
    $d14 = $_POST['init_wall[1][val]'];
    $e13 = $_POST['init_wall[2][thickness]'];
    $f14 = $_POST['init_wall[2][val]'];
    $g13 = $_POST['init_wall[3][thickness]'];
    $h14 = $_POST['init_wall[3][val]'];
    $i13 = $_POST['init_wall[4][thickness]'];
    $j14 = $_POST['init_wall[4][val]'];
    $k13 = $_POST['init_wall[5][thickness]'];
    $l14 = $_POST['init_wall[5][val]'];
    $m13 = $_POST['init_wall[6][thickness]'];
    $n14 = $_POST['init_wall[6][val]'];
    $bq1 = 1 / 8.7 + $c13 / $d14 + $e13 / $f14 + $g13 / $h14 + $i13 / $j14 + $k13 / $l14 + $m13 / $n14 + 1 / 23;
    if ($b11 == 1) {
        $b232 = 0.5 * $bq1;
    } else {
        $b232 = $bq1;
    }
    $b7 = $_POST['floors'];
    $b55 = $_POST['degree_days'];
    if ($b7 <= 3) {
        if ($b55 < 2000) {
            $c232 = 1.6;
        } else {
            if ($b55 < 3000) {
                $c232 = 2;
            } else {
                $c232 = 2.4;
            }
        }
    } else {
        if ($b55 < 2000) {
            $c232 = 1.8;
        } else {
            if ($b55 < 3000) {
                $c232 = 2.2;
            } else {
                $c232 = 2.6;
            }
        }
    }
    $c35=0;
    $d36=0;
    $e35=0;
    $f36=0;
    $g35=0;
    $h36=0;
    $i35=0;
    $j36=0;
    $k35=0;
    $l36=0;
    $m35=0;
    $n36=0;
    $d232=$b232+$c35/$d36+$e35/$f36+$g35/$h36+$i35/$j36+$k35/$l36+$m35/$n36;


    // 1) POST ma’lumotlarini o‘qish
//    $outsideTemp = (float)($_POST['outside_temp'] ?? 0);
//    $coldTemp = (float)($_POST['cold_temp'] ?? 0);
//    $degreeDays = (float)($_POST['degree_days'] ?? 0);
//    $areas = [
//        'wall' => (float)($_POST['wall_area'] ?? 0),
//        'window' => (float)($_POST['window_area'] ?? 0),
//        'door' => (float)($_POST['door_area'] ?? 0),
//        'roof' => (float)($_POST['building_area'] ?? 0),
//        'floor' => (float)($_POST['building_area'] ?? 0),
//        'shaft' => (float)($_POST['shaft_area'] ?? 0),
//    ];
//
//    // 2) R qiymatlarini hisoblash
//    $R = [
//        'wall' => 0, 'window' => 0, 'door' => 0, 'roof' => 0, 'floor' => 0
//    ];
//    // devor qatlamlari
//    foreach ($_POST['init_wall'] as $L) {
//        $t = (float)$L['thickness'];
//        $k = (float)$L['val'];
//        if ($k > 0) $R['wall'] += $t / $k;
//    }
//    // deraza — modeldan kelgan coeff
//    $winCoeffs = array_column($window_layer, 'perm_coeff', 'id');
//    $selWin = $_POST['init_window_type'] ?? null;
//    $R['window'] = $winCoeffs[$selWin] ?? 0;
//    // eshik
//    foreach ($_POST['init_door_layer'] as $L) {
//        $t = (float)$L['thickness'];
//        $k = (float)$L['val'];
//        if ($k > 0) $R['door'] += $t / $k;
//    }
//    // tom
//    foreach ($_POST['init_roof_layer'] as $L) {
//        $t = (float)$L['thickness'];
//        $k = (float)$L['val'];
//        if ($k > 0) $R['roof'] += $t / $k;
//    }
//    // pol
//    foreach ($_POST['init_floor_layer'] as $L) {
//        $t = (float)$L['thickness'];
//        $k = (float)$L['val'];
//        if ($k > 0) $R['floor'] += $t / $k;
//    }
//
//    // 3) Q qiymatlari
//    $dT = abs($outsideTemp - $coldTemp);
//    $Q = [];
//    foreach (['wall', 'window', 'door', 'roof', 'floor'] as $key) {
//        $Q[$key] = $R[$key] > 0
//            ? $areas[$key] * $dT * $degreeDays / $R[$key]
//            : 0;
//    }
//    // ventilyatsiya
//    $Q['vent'] = $areas['shaft'] * 1.0 * $dT * 0.34 * 24 * 365;
//
//    // jami
//    $Q['total'] = array_sum($Q);
//
//    // solishtirma sarf (kVt/m2 y)
//    $cmp_current = $areas['roof'] > 0
//        ? $Q['total'] / $areas['roof'] / 1000
//        : 0;
//    $cmp_norm = 67.16; // me’yoriy
//    $G = $cmp_norm > 0
//        ? round(100 * ($cmp_norm - $cmp_current) / $cmp_norm, 2)
//        : 0;
//
//    $report = compact('R', 'Q', 'cmp_current', 'cmp_norm', 'G');
}

?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Energiya samarador bino</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="?page=home">Bosh sahifa</a>
    <a class="navbar-brand" href="?page=main">Hisoblash</a>
</nav>
<main class="container mt-4">
    <h1>Asosiy hisoblash sahifasi</h1>
    <div class="container my-5">
        <h5 class="mb-2">Boshlang‘ich ma’lumotlar</h5>
        <form action="" method="POST" class="row g-1">

            <div class="col-12 col-md-12">
                <label for="region" class="form-label small">Qurilish hududi</label>
                <select id="region" name="region" class="form-select form-select-sm" required>
                    <option value="">Tanlang...</option>
                    <?php foreach ($regions as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= $r['id'] == 38 ? 'selected' : '' ?>>
                            <?= htmlspecialchars($r['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-12 col-md-4">
                <label for="outside_temp" class="form-label small">Tashqi havo hisobiy harorati (°C)</label>
                <input type="number" id="outside_temp" name="outside_temp" step="0.1"
                       class="form-control form-control-sm" value="-14">
            </div>

            <div class="col-6 col-md-4">
                <label for="avg_below10_temp" class="form-label small">
                    Kunlik oʻrtacha harorati 10°C yoki undan past boʻlgan davrning oʻrtacha harorati
                </label>
                <input type="number" id="avg_below10_temp" name="avg_below10_temp" step="0.01"
                       class="form-control form-control-sm" value="3.35">
            </div>

            <div class="col-6 col-md-4">
                <label for="duration_below10" class="form-label small">
                    Kunlik oʻrtacha harorati 10°C yoki undan past boʻlgan davrning davomiyligi: sutka
                </label>
                <input type="number" id="duration_below10" name="duration_below10" step="0.1"
                       class="form-control form-control-sm" value="147.5">
            </div>

            <div class="col-6 col-md-4">
                <label for="cold_temp" class="form-label small">
                    Sovuq mavsumda ichki havo hisobiy o‘rtacha harorati: (°C)
                </label>
                <input type="number" id="cold_temp" name="cold_temp" step="0.1"
                       class="form-control form-control-sm" value="20" required>
            </div>

            <div class="col-6 col-md-4">
                <label for="degree_days" class="form-label small">
                    Gradus-sutka soni
                </label>
                <input type="number" id="degree_days" name="degree_days" step="0.001"
                       class="form-control form-control-sm" value="2455.875">
            </div>

            <div class="col-6 col-md-4">
                <label for="building_area" class="form-label small">Bino maydoni (m²)</label>
                <input type="number" id="building_area" name="building_area" step="0.1"
                       class="form-control form-control-sm" value="605.5" required>
            </div>

            <div class="col-6 col-md-4">
                <label for="heated_area" class="form-label small">Bir qavatdagi isitiladigan xonalar maydoni
                    (m²)</label>
                <input type="number" id="heated_area" name="heated_area" step="0.1"
                       class="form-control form-control-sm" value="491.8" required>
            </div>
            <div class="col-6 col-md-4">
                <label for="floors" class="form-label small">Qavatlar soni</label>
                <input type="number" id="floors" name="floors"
                       class="form-control form-control-sm" value="4" required>
            </div>
            <div class="col-6 col-md-4">
                <label for="wall_area" class="form-label small">Tashqi devorlar maydoni (m²)</label>
                <input type="number" id="wall_area" name="wall_area" step="0.01"
                       class="form-control form-control-sm" value="957.92" required>
            </div>
            <div class="col-6 col-md-4">
                <label for="window_area" class="form-label small">Yorug‘lik tushuvchi yuzalar maydoni (m²)</label>
                <input type="number" id="window_area" name="window_area" step="0.01"
                       class="form-control form-control-sm" value="316.25" required>
            </div>
            <div class="col-6 col-md-4">
                <label for="door_area" class="form-label small">Tashqi eshiklar yuzasi (m²)</label>
                <input type="number" id="door_area" name="door_area" step="0.01"
                       class="form-control form-control-sm" value="9.45" required>
            </div>

            <div class="col-12">
                <h3 class="mt-5">Tashqi devor turi</h3>
                <select id="init_wall_type" name="init_wall_type" class="form-select" required>
                    <option value="">Tanlang...</option>
                    <option value="1">3 qatlamli yig'ma temirbeton panelli</option>
                    <option value="2">Pishgan g‘isht</option>
                    <option value="3">Gazoblok</option>
                    <option value="4">Monolit temirbeton</option>
                    <option value="5">1 qatlamli yig'ma temirbeton panelli</option>
                </select>
                <div class="row mb-3">
                </div>
            </div>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Qatlam</th>
                    <th>Qalinligi (m)</th>
                    <th>Turi</th>
                    <th>Qiymati</th>
                </tr>
                </thead>
                <tbody>

                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <tr>
                        <td><?= $i ?>-</td>
                        <td>
                            <input type="number"
                                   name="init_wall[<?= $i ?>][thickness]"
                                   step="0.001"
                                   class="form-control"
                                   value="<?= $i * 0.1 ?>"
                                   placeholder="0.000"/>
                        </td>
                        <td>
                            <select name="init_wall[<?= $i ?>][type]" class="form-select">
                                <option value="">Tanlang...</option>
                                <?php foreach ($wall_layer as $wl): ?>
                                    <option value="<?= $wl['id'] ?>"><?= htmlspecialchars($wl['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number"
                                   name="init_wall[<?= $i ?>][val]"
                                   step="0.001"
                                   class="form-control"
                                   placeholder="0.000"/>
                        </td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>

            <div class="col-12">
                <h3>Tashqi deraza turi</h3>
                <select id="init_window_type" name="init_window_type"
                        class="form-select form-select-sm">
                    <option value="">Tanlang...</option>
                    <?php foreach ($window_layer as $wl): ?>
                        <option value="<?= $wl['id'] ?>">
                            <?= htmlspecialchars($wl['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-12">
                <h3>Tashqi eshik turi</h3>
                <select id="init_door_type" name="init_door_type" class="form-select" required>
                    <option value="">Tanlang...</option>
                    <?php foreach ($doorMaterials2 as $dm): ?>
                        <option value="<?= $dm['id'] ?>"><?= htmlspecialchars($dm['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Qatlam</th>
                    <th>Qalinligi (m)</th>
                    <th>Turi</th>
                    <th>Qiymati</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <tr>
                        <td><?= $i ?>-</td>
                        <td>
                            <input type="number"
                                   name="init_door_layer[<?= $i ?>][thickness]"
                                   step="0.001"
                                   class="form-control"
                                   value="<?= $i * 0.1 ?>"
                                   placeholder="0.000"/>
                        </td>
                        <td>
                            <select name="init_door_layer[<?= $i ?>][type]" class="form-select">
                                <option value="">Tanlang...</option>
                                <?php foreach ($doorMaterials as $dm): ?>
                                    <option value="<?= $dm['id'] ?>"><?= htmlspecialchars($dm['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number"
                                   name="init_door_layer[<?= $i ?>][val]"
                                   step="0.001"
                                   class="form-control"
                                   placeholder="0.000"/>
                        </td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>

            <div class="col-12">
                <h3>Tom yopma turi</h3>
                <select id="init_roof_type" name="init_roof_type" class="form-select" required>
                    <option value="">Tanlang...</option>
                    <option value="1">Chordoqli</option>
                    <option value="2">Tekis</option>
                </select>
            </div>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Qatlam</th>
                    <th>Qalinligi (m)</th>
                    <th>Turi</th>
                    <th>Qiymati</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <tr>
                        <td><?= $i ?>-</td>
                        <td>
                            <input type="number"
                                   name="init_roof_layer[<?= $i ?>][thickness]"
                                   step="0.001"
                                   class="form-control"
                                   value="<?= $i * 0.1 ?>"
                                   placeholder="0.000"/>
                        </td>
                        <td>
                            <select name="init_roof_layer[<?= $i ?>][type]" class="form-select">
                                <option value="">Tanlang...</option>
                                <?php foreach ($roofMaterials as $r): ?>
                                    <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number"
                                   name="init_roof_layer[<?= $i ?>][val]"
                                   step="0.001"
                                   class="form-control"
                                   placeholder="0.000"/>
                        </td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>

            <h3 class="mt-4">Pol qoplamasi qatlamlari</h3>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Qatlam</th>
                    <th>Qalinligi (m)</th>
                    <th>Turi</th>
                    <th>Qiymati</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <tr>
                        <td><?= $i ?>-</td>
                        <td>
                            <input type="number"
                                   name="init_floor_layer[<?= $i ?>][thickness]"
                                   step="0.001"
                                   class="form-control"
                                   value="<?= $i * 0.1 ?>"
                                   placeholder="0.000"/>
                        </td>
                        <td>
                            <select name="init_floor_layer[<?= $i ?>][type]" class="form-select">
                                <option value="">Tanlang...</option>
                                <?php foreach ($roofMaterials as $f): ?>
                                    <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number"
                                   name="init_floor_layer[<?= $i ?>][val]"
                                   step="0.001"
                                   class="form-control"
                                   placeholder="0.000"/>
                        </td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>

            <div class="col-6 col-md-4">
                <label for="shaft_area" class="form-label small">Ventilyatsiya shaxta maydoni (m²)</label>
                <input type="number" id="shaft_area" name="shaft_area" step="0.0001" value="0.0144"
                       class="form-control form-control-sm">
            </div>
            <div class="col-6 col-md-4">
                <label for="shaft_count" class="form-label small">Ventilyatsiya shaxtalar soni</label>
                <input type="number" id="shaft_count" name="shaft_count" value="88"
                       class="form-control form-control-sm">
            </div>
            <div class="col-6 col-md-4">
                <label for="shaft_speed" class="form-label small">Ventilyatsiya shaxta tezligi (m/s)</label>
                <input type="number" id="shaft_speed" name="shaft_speed" step="0.01" value="0.5"
                       class="form-control form-control-sm">
            </div>

            <h3 class="mt-5">Ta’mirlangandagi o‘zgarishlar</h3>

            <h5 class="mt-4">Qo‘shimcha tashqi devor qatlamlari</h5>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Qatlam</th>
                    <th>Qalinligi (m)</th>
                    <th>Turi</th>
                    <th>Qiymati</th>
                </tr>
                </thead>
                <tbody>

                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <tr>
                        <td><?= $i ?>-</td>
                        <td>
                            <input type="number"
                                   name="rep_wall[<?= $i ?>][thickness]"
                                   step="0.001"
                                   class="form-control"
                                   value="<?= $i * 0.1 ?>"
                                   placeholder="0.000"/>
                        </td>
                        <td>
                            <select name="rep_wall[<?= $i ?>][type]" class="form-select">
                                <option value="">Tanlang...</option>
                                <?php foreach ($wall_layer as $wl): ?>
                                    <option value="<?= $wl['id'] ?>"><?= htmlspecialchars($wl['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number"
                                   name="rep_wall[<?= $i ?>][val]"
                                   step="0.001"
                                   class="form-control"
                                   placeholder="0.000"/>
                        </td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>

            <div class="col-12">
                <h3>Tashqi deraza turi</h3>
                <select id="rep_window_type" name="rep_window_type" class="form-select form-select-sm">
                    <option value="">Tanlang...</option>
                    <?php foreach ($window_layer as $wl): ?>
                        <option value="<?= $wl['id'] ?>">
                            <?= htmlspecialchars($wl['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-12">
                <h3>Tashqi eshik turi</h3>
                <select id="rep_door_type" name="rep_door_type" class="form-select" required>
                    <option value="">Tanlang...</option>
                    <?php foreach ($doorMaterials2 as $dm): ?>
                        <option value="<?= $dm['id'] ?>"><?= htmlspecialchars($dm['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Qatlam</th>
                    <th>Qalinligi (m)</th>
                    <th>Turi</th>
                    <th>Qiymati</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <tr>
                        <td><?= $i ?>-</td>
                        <td>
                            <input type="number"
                                   name="rep_door_layer[<?= $i ?>][thickness]"
                                   step="0.001"
                                   class="form-control"
                                   value="<?= $i * 0.1 ?>"
                                   placeholder="0.000"/>
                        </td>
                        <td>
                            <select name="rep_door_layer[<?= $i ?>][type]" class="form-select">
                                <option value="">Tanlang...</option>
                                <?php foreach ($doorMaterials as $dm): ?>
                                    <option value="<?= $dm['id'] ?>"><?= htmlspecialchars($dm['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number"
                                   name="rep_door_layer[<?= $i ?>][val]"
                                   step="0.001"
                                   class="form-control"
                                   placeholder="0.000"/>
                        </td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>

            <div class="col-12">
                <h3>Tom yopma turi</h3>
                <select id="rep_roof_type" name="rep_roof_type" class="form-select" required>
                    <option value="">Tanlang...</option>
                    <option value="1">Chordoqli</option>
                    <option value="2">Tekis</option>
                </select>
            </div>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Qatlam</th>
                    <th>Qalinligi (m)</th>
                    <th>Turi</th>
                    <th>Qiymati</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <tr>
                        <td><?= $i ?>-</td>
                        <td>
                            <input type="number"
                                   name="rep_roof_layer[<?= $i ?>][thickness]"
                                   step="0.001"
                                   class="form-control"
                                   value="<?= $i * 0.1 ?>"
                                   placeholder="0.000"/>
                        </td>
                        <td>
                            <select name="rep_roof_layer[<?= $i ?>][type]" class="form-select">
                                <option value="">Tanlang...</option>
                                <?php foreach ($roofMaterials as $r): ?>
                                    <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number"
                                   name="rep_roof_layer[<?= $i ?>][val]"
                                   step="0.001"
                                   class="form-control"
                                   placeholder="0.000"/>
                        </td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>

            <h3 class="mt-4">Pol qoplamasi qatlamlari</h3>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Qatlam</th>
                    <th>Qalinligi (m)</th>
                    <th>Turi</th>
                    <th>Qiymati</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <tr>
                        <td><?= $i ?>-</td>
                        <td>
                            <input type="number"
                                   name="rep_floor_layer[<?= $i ?>][thickness]"
                                   step="0.001"
                                   class="form-control"
                                   value="<?= $i * 0.1 ?>"
                                   placeholder="0.000"/>
                        </td>
                        <td>
                            <select name="rep_floor_layer[<?= $i ?>][type]" class="form-select">
                                <option value="">Tanlang...</option>
                                <?php foreach ($roofMaterials as $f): ?>
                                    <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number"
                                   name="rep_floor_layer[<?= $i ?>][val]"
                                   step="0.001"
                                   class="form-control"
                                   placeholder="0.000"/>
                        </td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Hisoblash</button>

        </form>

        <?php //if ($report): ?>
        <hr>
        <h3>Natija hisobot</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>To‘siq konstruksiyalar nomi</th>
                    <th class="text-center">Mavjud holatdagi R&nbsp;(m²·°C)/Vt</th>
                    <th class="text-center">Me'yoriy R&nbsp;(m²·°C)/Vt</th>
                    <th class="text-center">Izolatsiyadan keyingi R&nbsp;(m²·°C)/Vt</th>
                    <th class="text-center">Normativ R&nbsp;(m²·°C)/Vt</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Tashqi devor</td>
                    <td class="text-center" id="b232">b232</td>
                    <td class="text-center">2,20</td>
                    <td class="text-center">3,34</td>
                    <td class="text-center">0,98</td>
                </tr>
                <tr>
                    <td>Tashqi deraza</td>
                    <td class="text-center">0,15</td>
                    <td class="text-center">0,53</td>
                    <td class="text-center">0,36</td>
                    <td class="text-center">—</td>
                </tr>
                <tr>
                    <td>Tashqi eshik</td>
                    <td class="text-center">0,16</td>
                    <td class="text-center">0,59</td>
                    <td class="text-center">0,94</td>
                    <td class="text-center">—</td>
                </tr>
                <tr>
                    <td>Tom qoplamasi</td>
                    <td class="text-center">1,60</td>
                    <td class="text-center">9,00</td>
                    <td class="text-center">3,16</td>
                    <td class="text-center">—</td>
                </tr>
                <tr>
                    <td>Birinchi qavat pol</td>
                    <td class="text-center">0,60</td>
                    <td class="text-center">1,96</td>
                    <td class="text-center">2,17</td>
                    <td class="text-center">—</td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- 2‐jadval: Yillik issiqlik yo‘qotish -->
        <h2 class="mt-5 mb-3">Yillik issiqlik yo‘qotish (Vt)</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>To‘siq konstruksiyalar nomi</th>
                    <th class="text-end">Mavjud holatdagi yo‘qotish (Vt)</th>
                    <th class="text-end">Izolatsiyadan keyingi yo‘qotish (Vt)</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Tashqi devorlar</td>
                    <td class="text-end">31 718 913,65</td>
                    <td class="text-end">16 891 601,75</td>
                </tr>
                <tr>
                    <td>Tashqi derazalar</td>
                    <td class="text-end">124 267 275,00</td>
                    <td class="text-end">51 778 031,25</td>
                </tr>
                <tr>
                    <td>Tashqi eshiklar</td>
                    <td class="text-end">3 514 757,46</td>
                    <td class="text-end">592 731,00</td>
                </tr>
                <tr>
                    <td>Tom yopmasi</td>
                    <td class="text-end">18 149 277,77</td>
                    <td class="text-end">9 174 165,19</td>
                </tr>
                <tr>
                    <td>Yerto‘la yopmasi</td>
                    <td class="text-end">48 035 122,38</td>
                    <td class="text-end">13 383 076,88</td>
                </tr>
                <tr class="fw-bold">
                    <td>Jami</td>
                    <td class="text-end">225 685 346,26</td>
                    <td class="text-end">91 819 606,07</td>
                </tr>
                </tbody>
            </table>
            <h2 class="mb-3">Qo‘shimcha hisoblar</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                    <!-- 1. Ventilyatsiya yo‘qotishi -->
                    <tr class="table-light">
                        <th colspan="4" class="text-center">
                            Ventilyatsiyadan yo‘qolayotgan issiqlik miqdori: Vt.
                        </th>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center">
                            40 305 274,86
                        </td>
                    </tr>

                    <!-- 2. Umumiy yo‘qotishlar -->
                    <tr class="table-light">
                        <th colspan="2">Mavjud holatdagi jami yo‘qotish: Vt.</th>
                        <th colspan="2">Izolyatsiyadan keyingi jami yo‘qotish: Vt.</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-end">265 990 621,10</td>
                        <td colspan="2" class="text-end">132 124 880,90</td>
                    </tr>

                    <!-- 3. Solishtirma issiqlik miqdori -->
                    <tr class="table-light">
                        <th>Mavjud holatdagi solishtirma issiqlik: kVt/m²·yil</th>
                        <th class="text-end">135,21</th>
                        <th>Izolyatsiyadan keyingi solishtirma issiqlik: kVt/m²·yil</th>
                        <th class="text-end">67,16</th>
                    </tr>

                    <!-- 4. Me'yoriy yillik solishtirma sarf -->
                    <tr class="table-light">
                        <th colspan="4" class="text-center">
                            Bino uchun me'yoriy yillik solishtirma issiqlik sarfi: kVt/m²·yil<br>
                            <small>(issiqlik taʼminoti va ventilyatsiyadan yo‘qotilayotgan issiqlik miqdori
                                uchun)</small>
                        </th>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center">68,31</td>
                    </tr>

                    <!-- 5. Energiya samaradorlik toifalari -->
                    <tr class="table-light">
                        <th>Mavjud holatdagi energiya samaradorlik toifasi</th>
                        <th class="text-center">G (97,94%)</th>
                        <th>Taʼmirdan keyingi energiya samaradorlik toifasi</th>
                        <th class="text-center">D (-1,68%)</th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php //endif; ?>

    </div>

    <script>
        const regionsData = <?php
            $regionsDataArray = array_reduce($regions, function ($carry, $r) {
                $carry[$r['id']] = [
                    'cold_temp' => $r['cold_temp'] ?? null,
                    'avg_temp' => $r['average_temp'] ?? null,
                    'duration' => $r['duration'] ?? null,
                    'degree_days' => $r['degree_days'] ?? null
                ];
                return $carry;
            }, []);
            echo json_encode($regionsDataArray, JSON_UNESCAPED_UNICODE);
            ?>;

        const regionSelect = document.getElementById('region');

        regionSelect.addEventListener('change', () => {
            const data = regionsData[regionSelect.value] || {};

            document.getElementById('outside_temp').value = data.cold_temp ?? '';
            document.getElementById('avg_below10_temp').value = data.avg_temp ?? '';
            document.getElementById('duration_below10').value = data.duration ?? '';
            document.getElementById('degree_days').value = data.degree_days ?? '';
        });

        window.addEventListener('DOMContentLoaded', () => {
            if (regionSelect.value) {
                regionSelect.dispatchEvent(new Event('change'));
            }
        });

        const inputA = document.getElementById('cold_temp');
        const inputB = document.getElementById('avg_below10_temp');
        const inputC = document.getElementById('duration_below10');
        const inputG = document.getElementById('degree_days');

        function calculateG() {
            const A = parseFloat(inputA.value) || 0;
            const B = parseFloat(inputB.value) || 0;
            const C = parseFloat(inputC.value) || 0;

            inputG.value = ((A - B) * C).toFixed(3);
        }

        [inputA, inputB, inputC].forEach(el => {
            el.addEventListener('input', calculateG);
        });

        window.addEventListener('DOMContentLoaded', () => {
            calculateG();
        });

        const wallCoeffs = <?= json_encode(array_column($wall_layer, 'perm_coeff', 'id'), JSON_UNESCAPED_UNICODE) ?>;
        const doorCoeffs = <?= json_encode(array_column($doorMaterials, 'perm_coeff', 'id'), JSON_UNESCAPED_UNICODE) ?>;
        const roofCoeffs = <?= json_encode(array_column($roofMaterials, 'perm_coeff', 'id'), JSON_UNESCAPED_UNICODE) ?>;
        const floorCoeffs = <?= json_encode(array_column($roofMaterials, 'perm_coeff', 'id'), JSON_UNESCAPED_UNICODE) ?>;

        document.querySelectorAll('select[name^="init_wall\\["][name$="[type]"]').forEach(select => {
            select.addEventListener('change', () => {
                const id = select.value;
                const coeff = wallCoeffs[id] ?? '';
                const row = select.closest('tr');
                const inputV = row.querySelector('input[name$="[val]"]');
                inputV.value = coeff;
            });
        });

        document.querySelectorAll('select[name^="init_door_layer\\["][name$="[type]"]').forEach(select => {
            select.addEventListener('change', () => {
                const id = select.value;
                const coeff = doorCoeffs[id] ?? '';
                const row = select.closest('tr');
                const input = row.querySelector('input[name$="[val]"]');
                input.value = coeff;
            });
        });

        document.querySelectorAll('select[name^="init_roof_layer\\["][name$="[type]"]').forEach(select => {
            select.addEventListener('change', () => {
                const id = select.value;
                const coeff = roofCoeffs[id] ?? '';
                const row = select.closest('tr');
                row.querySelector('input[name$="[val]"]').value = coeff;
            });
        });

        document.querySelectorAll('select[name^="init_floor_layer\\["][name$="[type]"]').forEach(select => {
            select.addEventListener('change', () => {
                const id = select.value;
                const coeff = floorCoeffs[id] ?? '';
                const row = select.closest('tr');
                row.querySelector('input[name$="[val]"]').value = coeff;
            });
        });

        document.querySelectorAll('select[name^="rep_wall\\["][name$="[type]"]').forEach(select => {
            select.addEventListener('change', () => {
                const id = select.value;
                const coeff = wallCoeffs[id] ?? '';
                const row = select.closest('tr');
                const inputV = row.querySelector('input[name$="[val]"]');
                inputV.value = coeff;
            });
        });

        document.querySelectorAll('select[name^="rep_door_layer\\["][name$="[type]"]').forEach(select => {
            select.addEventListener('change', () => {
                const id = select.value;
                const coeff = doorCoeffs[id] ?? '';
                const row = select.closest('tr');
                const input = row.querySelector('input[name$="[val]"]');
                input.value = coeff;
            });
        });

        document.querySelectorAll('select[name^="rep_roof_layer\\["][name$="[type]"]').forEach(select => {
            select.addEventListener('change', () => {
                const id = select.value;
                const coeff = roofCoeffs[id] ?? '';
                const row = select.closest('tr');
                row.querySelector('input[name$="[val]"]').value = coeff;
            });
        });

        document.querySelectorAll('select[name^="rep_floor_layer\\["][name$="[type]"]').forEach(select => {
            select.addEventListener('change', () => {
                const id = select.value;
                const coeff = floorCoeffs[id] ?? '';
                const row = select.closest('tr');
                row.querySelector('input[name$="[val]"]').value = coeff;
            });
        });
    </script>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
