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
    $c13 = (float)$_POST['init_wall'][1]['thickness'];
    $d14 = (float)$_POST['init_wall'][1]['val'];
    $e13 = (float)$_POST['init_wall'][2]['thickness'];
    $f14 = (float)$_POST['init_wall'][2]['val'];
    $g13 = (float)$_POST['init_wall'][3]['thickness'];
    $h14 = (float)$_POST['init_wall'][3]['val'];
    $i13 = (float)$_POST['init_wall'][4]['thickness'];
    $j14 = (float)$_POST['init_wall'][4]['val'];
    $k13 = (float)$_POST['init_wall'][5]['thickness'];
    $l14 = (float)$_POST['init_wall'][5]['val'];
    $m13 = (float)$_POST['init_wall'][6]['thickness'];
    $n14 = (float)$_POST['init_wall'][6]['val'];

    $term1 = ($d14 != 0) ? ($c13 / $d14) : 0;
    $term2 = ($f14 != 0) ? ($e13 / $f14) : 0;
    $term3 = ($h14 != 0) ? ($g13 / $h14) : 0;
    $term4 = ($j14 != 0) ? ($i13 / $j14) : 0;
    $term5 = ($l14 != 0) ? ($k13 / $l14) : 0;
    $term6 = ($n14 != 0) ? ($m13 / $n14) : 0;

    $bq1 = 1 / 8.7 + $term1 + $term2 + $term3 + $term4 + $term5 + $term6 + 1 / 23;
    if ($b11 == 1) {
        $b232 = 0.5 * $bq1;
    } else {
        $b232 = $bq1;
    }
    $b7 = $_POST['floors'];
    $b55 = $_POST['degree_days'];
    $b56 = $_POST['roof_n'];
    $b57 = $_POST['cellar_n'];

    if ($b7 <= 3) {
        if ($b55 < 2000) {
            $c232 = 1.6;
            $c235 = 2.8 * $b56;
            $c236 = 2.6 * $b57;
        } else {
            if ($b55 < 3000) {
                $c232 = 2;
                $c235 = 3.2 * $b56;
                $c236 = 3 * $b57;
            } else {
                $c232 = 2.4;
                $c235 = 3.8 * $b56;
                $c236 = 3.4 * $b57;
            }
        }
    } else {
        if ($b55 < 2000) {
            $c232 = 1.8;
            $c235 = 2.6 * $b56;
            $c236 = 2.4 * $b57;
        } else {
            if ($b55 < 3000) {
                $c232 = 2.2;
                $c235 = 3 * $b56;
                $c236 = 2.8 * $b57;
            } else {
                $c232 = 2.6;
                $c235 = 3.6 * $b56;
                $c236 = 3.2 * $b57;
            }
        }
    }

    $c35 = (float)$_POST['rep_wall'][1]['thickness'];
    $d36 = (float)$_POST['rep_wall'][1]['val'];
    $e35 = (float)$_POST['rep_wall'][2]['thickness'];
    $f36 = (float)$_POST['rep_wall'][2]['val'];
    $g35 = (float)$_POST['rep_wall'][3]['thickness'];
    $h36 = (float)$_POST['rep_wall'][3]['val'];
    $i35 = (float)$_POST['rep_wall'][4]['thickness'];
    $j36 = (float)$_POST['rep_wall'][4]['val'];
    $k35 = (float)$_POST['rep_wall'][5]['thickness'];
    $l36 = (float)$_POST['rep_wall'][5]['val'];
    $m35 = (float)$_POST['rep_wall'][6]['thickness'];
    $n36 = (float)$_POST['rep_wall'][6]['val'];
    // Ta'mirdan keyingi devor qatlamlari uchun hisoblash
    $term_rep1 = ($d36 != 0) ? ($c35 / $d36) : 0;
    $term_rep2 = ($f36 != 0) ? ($e35 / $f36) : 0;
    $term_rep3 = ($h36 != 0) ? ($g35 / $h36) : 0;
    $term_rep4 = ($j36 != 0) ? ($i35 / $j36) : 0;
    $term_rep5 = ($l36 != 0) ? ($k35 / $l36) : 0;
    $term_rep6 = ($n36 != 0) ? ($m35 / $n36) : 0;

    $d232 = $b232 + $term_rep1 + $term_rep2 + $term_rep3 + $term_rep4 + $term_rep5 + $term_rep6;

    $b4 = $_POST['cold_temp'];
    $b52 = $_POST['outside_temp'];
    $e232 = ($b4 - $b52) / (4 * 8.7);

    $b233 = $model->getPermCoeffBySubcatId($_POST['init_window_type']);
    if ($b55 < 2000) {
        $c233 = 0.45;
    } else {
        $c233 = 0.53;
    }
    $d233 = $model->getPermCoeffBySubcatId($_POST['rep_window_type']);
    $b234 = $model->getPermCoeffBySubcatId($_POST['init_door_type']);
    $c234 = $e232 * 0.6;
    $d234 = $model->getPermCoeffBySubcatId($_POST['rep_door_type']);

    $c22 = (float)$_POST['init_roof_layer'][1]['thickness'];
    $d23 = (float)$_POST['init_roof_layer'][1]['val'];
    $e22 = (float)$_POST['init_roof_layer'][2]['thickness'];
    $f23 = (float)$_POST['init_roof_layer'][2]['val'];
    $g22 = (float)$_POST['init_roof_layer'][3]['thickness'];
    $h23 = (float)$_POST['init_roof_layer'][3]['val'];
    $i22 = (float)$_POST['init_roof_layer'][4]['thickness'];
    $j23 = (float)$_POST['init_roof_layer'][4]['val'];
    $k22 = (float)$_POST['init_roof_layer'][5]['thickness'];
    $l23 = (float)$_POST['init_roof_layer'][5]['val'];
    $m22 = (float)$_POST['init_roof_layer'][6]['thickness'];
    $n23 = (float)$_POST['init_roof_layer'][6]['val'];
    $roof_term1 = ($d23 != 0) ? ($c22 / $d23) : 0;
    $roof_term2 = ($f23 != 0) ? ($e22 / $f23) : 0;
    $roof_term3 = ($h23 != 0) ? ($g22 / $h23) : 0;
    $roof_term4 = ($j23 != 0) ? ($i22 / $j23) : 0;
    $roof_term5 = ($l23 != 0) ? ($k22 / $l23) : 0;
    $roof_term6 = ($n23 != 0) ? ($m22 / $n23) : 0;
    $b235 = 1 / 8.7 + $roof_term1 + $roof_term2 + $roof_term3 + $roof_term4 + $roof_term5 + $roof_term6 + 1 / 12;

    $c44 = (float)$_POST['rep_roof_layer'][1]['thickness'];
    $d45 = (float)$_POST['rep_roof_layer'][1]['val'];
    $e44 = (float)$_POST['rep_roof_layer'][2]['thickness'];
    $f45 = (float)$_POST['rep_roof_layer'][2]['val'];
    $g44 = (float)$_POST['rep_roof_layer'][3]['thickness'];
    $h45 = (float)$_POST['rep_roof_layer'][3]['val'];
    $i44 = (float)$_POST['rep_roof_layer'][4]['thickness'];
    $j45 = (float)$_POST['rep_roof_layer'][4]['val'];
    $k44 = (float)$_POST['rep_roof_layer'][5]['thickness'];
    $l45 = (float)$_POST['rep_roof_layer'][5]['val'];
    $m44 = (float)$_POST['rep_roof_layer'][6]['thickness'];
    $n45 = (float)$_POST['rep_roof_layer'][6]['val'];
    $roof_rep_term1 = ($d45 != 0) ? ($c44 / $d45) : 0;
    $roof_rep_term2 = ($f45 != 0) ? ($e44 / $f45) : 0;
    $roof_rep_term3 = ($h45 != 0) ? ($g44 / $h45) : 0;
    $roof_rep_term4 = ($j45 != 0) ? ($i44 / $j45) : 0;
    $roof_rep_term5 = ($l45 != 0) ? ($k44 / $l45) : 0;
    $roof_rep_term6 = ($n45 != 0) ? ($m44 / $n45) : 0;
    $d235 = $b235 + $roof_rep_term1 + $roof_rep_term2 + $roof_rep_term3 + $roof_rep_term4 + $roof_rep_term5 + $roof_rep_term6;


    $c26 = (float)$_POST['init_floor_layer'][1]['thickness'];
    $d27 = (float)$_POST['init_floor_layer'][1]['val'];
    $e26 = (float)$_POST['init_floor_layer'][2]['thickness'];
    $f27 = (float)$_POST['init_floor_layer'][2]['val'];
    $g26 = (float)$_POST['init_floor_layer'][3]['thickness'];
    $h27 = (float)$_POST['init_floor_layer'][3]['val'];
    $i26 = (float)$_POST['init_floor_layer'][4]['thickness'];
    $j27 = (float)$_POST['init_floor_layer'][4]['val'];
    $k26 = (float)$_POST['init_floor_layer'][5]['thickness'];
    $l27 = (float)$_POST['init_floor_layer'][5]['val'];
    $m26 = (float)$_POST['init_floor_layer'][6]['thickness'];
    $n27 = (float)$_POST['init_floor_layer'][6]['val'];

    $floor_term1 = ($d27 != 0) ? ($c26 / $d27) : 0;
    $floor_term2 = ($f27 != 0) ? ($e26 / $f27) : 0;
    $floor_term3 = ($h27 != 0) ? ($g26 / $h27) : 0;
    $floor_term4 = ($j27 != 0) ? ($i26 / $j27) : 0;
    $floor_term5 = ($l27 != 0) ? ($k26 / $l27) : 0;
    $floor_term6 = ($n27 != 0) ? ($m26 / $n27) : 0;
    $b236 = 1 / 8.7 + $floor_term1 + $floor_term2 + $floor_term3 + $floor_term4 + $floor_term5 + $floor_term6 + 1 / 12;

    $c48 = (float)$_POST['rep_floor_layer'][1]['thickness'];
    $d49 = (float)$_POST['rep_floor_layer'][1]['val'];
    $e48 = (float)$_POST['rep_floor_layer'][2]['thickness'];
    $f49 = (float)$_POST['rep_floor_layer'][2]['val'];
    $g48 = (float)$_POST['rep_floor_layer'][3]['thickness'];
    $h49 = (float)$_POST['rep_floor_layer'][3]['val'];
    $i48 = (float)$_POST['rep_floor_layer'][4]['thickness'];
    $j49 = (float)$_POST['rep_floor_layer'][4]['val'];
    $k48 = (float)$_POST['rep_floor_layer'][5]['thickness'];
    $l49 = (float)$_POST['rep_floor_layer'][5]['val'];
    $m48 = (float)$_POST['rep_floor_layer'][6]['thickness'];
    $n49 = (float)$_POST['rep_floor_layer'][6]['val'];
    $floor_rep_term1 = ($d49 != 0) ? ($c48 / $d49) : 0;
    $floor_rep_term2 = ($f49 != 0) ? ($e48 / $f49) : 0;
    $floor_rep_term3 = ($h49 != 0) ? ($g48 / $h49) : 0;
    $floor_rep_term4 = ($j49 != 0) ? ($i48 / $j49) : 0;
    $floor_rep_term5 = ($l49 != 0) ? ($k48 / $l49) : 0;
    $floor_rep_term6 = ($n49 != 0) ? ($m48 / $n49) : 0;
    $d236 = $b236 + $floor_rep_term1 + $floor_rep_term2 + $floor_rep_term3 + $floor_rep_term4 + $floor_rep_term5 + $floor_rep_term6;

    $b8 = (float)$_POST['wall_area'];
    $b9 = (float)$_POST['window_area'];
    $b10 = (float)$_POST['door_area'];
    $b6 = (float)$_POST['heated_area'];
    $b53 = (float)$_POST['avg_below10_temp'];
    $b54 = (float)$_POST['duration_below10'];

    // Dastlabki holat uchun issiqlik yo'qotishlari
    $b238 = ($b232 != 0) ? ($b8 * ($b4 - $b53) * 24 * $b54 / $b232) : 0;
    $b239 = ($b233 != 0) ? ($b9 * ($b4 - $b53) * 24 * $b54 / $b233) : 0;
    $b240 = ($b234 != 0) ? ($b10 * ($b4 - $b53) * 24 * $b54 / $b234) : 0;
    $b241 = ($b235 != 0) ? ($b6 * ($b4 - $b53) * 24 * $b54 / $b235) : 0;
    $b242 = ($b236 != 0) ? ($b6 * ($b4 - $b53) * 24 * $b54 / $b236) : 0;

// Ta'mirdan keyingi holat uchun issiqlik yo'qotishlari
    $c238 = ($d232 != 0) ? ($b8 * ($b4 - $b53) * 24 * $b54 / $d232) : 0;
    $c239 = ($d233 != 0) ? ($b9 * ($b4 - $b53) * 24 * $b54 / $d233) : 0;
    $c240 = ($d234 != 0) ? ($b10 * ($b4 - $b53) * 24 * $b54 / $d234) : 0;
    $c241 = ($d235 != 0) ? ($b6 * ($b4 - $b53) * 24 * $b54 / $d235) : 0;
    $c242 = ($d236 != 0) ? ($b6 * ($b4 - $b53) * 24 * $b54 / $d236) : 0;

    $b243 = $b238 + $b239 + $b240 + $b241 + $b242;
    $c243 = $c238 + $c239 + $c240 + $c241 + $c242;

    $b28 = $_POST['shaft_area'];
    $b29 = $_POST['shaft_count'];
    $b30 = $_POST['shaft_speed'];
    $a245 = 1.2 * 1005 * $b28 * $b29 * $b30 * ($b4 - $b53) * 24 * 132;

    $a247 = $b243 + $a245;
    $b247 = $c243 + $a245;

    $denominator = $b6 * $b7;
    $a249 = ($denominator != 0) ? ($a247 / $denominator / 1000) : 0;
    $b249 = ($denominator != 0) ? ($b247 / $denominator / 1000) : 0;

    $bounds = $model->getBoundingStandardHeats($b55);
    $lower = $bounds['lower'];
    $upper = $bounds['upper'];

    $col = 'v' . $b7;

    if ($lower && $upper && $lower['degrees_per_day'] != $upper['degrees_per_day']) {
        $t = ($b55 - $lower['degrees_per_day'])
            / ($upper['degrees_per_day'] - $lower['degrees_per_day']);

        $valLower = (float)$lower[$col];
        $valUpper = (float)$upper[$col];
        $a251 = $valLower + $t * ($valUpper - $valLower);
    } else {
        $a251 = $lower[$col] ?? $upper[$col] ?? null;
    }

    function getCategoryWithPercent($a249, $a251): string
    {
        if ($a251 == 0) {
            return '–';
        }

        $ratio = ($a249 - $a251) / $a251;

        if ($ratio < -0.40) {
            $category = 'A';
        } elseif ($ratio < -0.26) {
            $category = 'B';
        } elseif ($ratio < -0.11) {
            $category = 'C';
        } elseif ($ratio <= 0.04) {
            $category = 'D';
        } elseif ($ratio <= 0.14) {
            $category = 'E';
        } elseif ($ratio <= 0.25) {
            $category = 'F';
        } else {
            $category = 'G';
        }

        $percentText = number_format($ratio * 100, 2, ',', '') . '%';

        return sprintf('%s (%s)', $category, $percentText);
    }

    $a253 = getCategoryWithPercent($a249, $a251);
    $b253 = getCategoryWithPercent($b249, $a251);
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
    <div class="row">
        <div class="col-12">
            <img src="/assets/images/header-image.png" class="container-fluid" alt="Baner">
        </div>
    </div>
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

            <div class="col-6 col-md-6">
                <label for="roof_n" class="form-label small">Tom qoplamasi uchun n qiymati</label>
                <input type="number" class="form-control form-control-sm" id="roof_n" name="roof_n" value="3"
                       step="0.01">
            </div>

            <div class="col-6 col-md-6">
                <label for="cellar_n" class="form-label small">Devorida yorug’lik oralig’lari boʻlgan isitilmaydigan
                    yertoʻla qoplamalari uchun</label>
                <input type="number" class="form-control form-control-sm" id="cellar_n" name="cellar_n" value="0.7"
                       step="0.01">
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
                    <td class="text-center"><?= $b232 ?? 0 ?></td>
                    <td class="text-center"><?= $c232 ?? 0 ?></td>
                    <td class="text-center"><?= $d232 ?? 0 ?></td>
                    <td class="text-center"><?= $e232 ?? 0 ?></td>
                </tr>
                <tr>
                    <td>Tashqi deraza</td>
                    <td class="text-center"><?= $b233 ?? 0 ?></td>
                    <td class="text-center"><?= $c233 ?? 0 ?></td>
                    <td class="text-center"><?= $d233 ?? 0 ?></td>
                    <td class="text-center">—</td>
                </tr>
                <tr>
                    <td>Tashqi eshik</td>
                    <td class="text-center"><?= $b234 ?? 0 ?></td>
                    <td class="text-center"><?= $c234 ?? 0 ?></td>
                    <td class="text-center"><?= $d234 ?? 0 ?></td>
                    <td class="text-center">—</td>
                </tr>
                <tr>
                    <td>Tom qoplamasi</td>
                    <td class="text-center"><?= $b235 ?? 0 ?></td>
                    <td class="text-center"><?= $c235 ?? 0 ?></td>
                    <td class="text-center"><?= $d235 ?? 0 ?></td>
                    <td class="text-center">—</td>
                </tr>
                <tr>
                    <td>Birinchi qavat pol</td>
                    <td class="text-center"><?= $b236 ?? 0 ?></td>
                    <td class="text-center"><?= $c236 ?? 0 ?></td>
                    <td class="text-center"><?= $d236 ?? 0 ?></td>
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
                    <td class="text-end"><?= $b238 ?? 0 ?></td>
                    <td class="text-end"><?= $c238 ?? 0 ?></td>
                </tr>
                <tr>
                    <td>Tashqi derazalar</td>
                    <td class="text-end"><?= $b239 ?? 0 ?></td>
                    <td class="text-end"><?= $c239 ?? 0 ?></td>
                </tr>
                <tr>
                    <td>Tashqi eshiklar</td>
                    <td class="text-end"><?= $b240 ?? 0 ?></td>
                    <td class="text-end"><?= $c240 ?? 0 ?></td>
                </tr>
                <tr>
                    <td>Tom yopmasi</td>
                    <td class="text-end"><?= $b241 ?? 0 ?></td>
                    <td class="text-end"><?= $c241 ?? 0 ?></td>
                </tr>
                <tr>
                    <td>Yerto‘la yopmasi</td>
                    <td class="text-end"><?= $b242 ?? 0 ?></td>
                    <td class="text-end"><?= $c242 ?? 0 ?></td>
                </tr>
                <tr class="fw-bold">
                    <td>Jami</td>
                    <td class="text-end"><?= $b243 ?? 0 ?></td>
                    <td class="text-end"><?= $c243 ?? 0 ?></td>
                </tr>
                </tbody>
            </table>
            <h2 class="mb-3">Qo‘shimcha hisoblar</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                    <tr class="table-light">
                        <th colspan="4" class="text-center">
                            Ventilyatsiyadan yo‘qolayotgan issiqlik miqdori: Vt.
                        </th>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center">
                            <?= $a245 ?? 0 ?>
                        </td>
                    </tr>

                    <tr class="table-light">
                        <th colspan="2">Mavjud holatdagi jami yo‘qotish: Vt.</th>
                        <th colspan="2">Izolyatsiyadan keyingi jami yo‘qotish: Vt.</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center"><?= $a247 ?? 0 ?></td>
                        <td colspan="2" class="text-center"><?= $b247 ?? 0 ?></td>
                    </tr>

                    <tr class="table-light">
                        <th colspan="2">Mavjud holatdagi solishtirma issiqlik: kVt/m²·yil</th>
                        <th colspan="2">Izolyatsiyadan keyingi solishtirma issiqlik: kVt/m²·yil</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center"><?= $a249 ?? 0 ?></td>
                        <td colspan="2" class="text-center"><?= $b249 ?? 0 ?></td>
                    </tr>

                    <tr class="table-light">
                        <th colspan="4" class="text-center">
                            Bino uchun me'yoriy yillik solishtirma issiqlik sarfi: kVt/m²·yil<br>
                            <small>
                                (issiqlik taʼminoti va ventilyatsiyadan yo‘qotilayotgan issiqlik miqdori uchun)
                            </small>
                        </th>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center"><?= $a251 ?? 0 ?></td>
                    </tr>

                    <tr class="table-light">
                        <th colspan="2">Mavjud holatdagi energiya samaradorlik toifasi</th>
                        <th colspan="2">Taʼmirdan keyingi energiya samaradorlik toifasi</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center"><?= $a253 ?? 0 ?></td>
                        <td colspan="2" class="text-center"><?= $b253 ?? 0 ?></td>
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
