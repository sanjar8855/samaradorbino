<?php
spl_autoload_register(function($class){
    // Namespace separator → papka separator
    $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
use App\Models\ExampleModel;
// Sahifani aniqlaymiz
$page = $_GET['page'] ?? 'main';

if ($page === 'main') {

    $model = new ExampleModel;
    $regions          = $model->getAllRegions();
    $wall_layer       = $model->getAllWithCatId(1);
    $window_layer     = $model->getAllWithCatId(2);
    $doorMaterials    = $model->getAllWithCatId(3);
    $doorMaterials2   = $model->getAllWithCatId(4);
    $roofMaterials    = $model->getAllWithCatId(5);

    $report = null;

    // 2) Agar form submit qilingan bo‘lsa, hisob-kitob qilamiz
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Formadagi maydonlarni o‘qiymiz
        $outsideTemp   = (float)($_POST['outside_temp'] ?? 0);
        $coldTemp      = (float)($_POST['cold_temp']    ?? 0);
        $degreeDays    = (float)($_POST['degree_days']  ?? 0);
        $buildingArea  = (float)($_POST['building_area'] ?? 0);
        $wallArea      = (float)($_POST['wall_area']     ?? 0);
        $windowArea    = (float)($_POST['window_area']   ?? 0);
        $doorArea      = (float)($_POST['door_area']     ?? 0);
        $shaftArea     = (float)($_POST['shaft_area']    ?? 0);

        // 3) Qismlarga qarshilik R ni hisoblaymiz
        $R = [];

        // – Devors
        $R['wall'] = 0;
        foreach ($_POST['wall_layer'] as $layer) {
            $t = (float)$layer['thickness'];
            $k = (float)$layer['type_v'];
            if ($k > 0) $R['wall'] += $t / $k;
        }

        // – Deraza (bitta ID)
        $windowCoeffs = array_column($window_layer, 'perm_coeff', 'id');
        $winId        = $_POST['window_layer'] ?? null;
        $R['window']  = isset($windowCoeffs[$winId]) ? (float)$windowCoeffs[$winId] : 0;

        // – Eshik
        $R['door'] = 0;
        foreach ($_POST['door_layer'] as $layer) {
            $t = (float)$layer['thickness'];
            $k = (float)$layer['type_v'];
            if ($k > 0) $R['door'] += $t / $k;
        }

        // – Tom
        $R['roof'] = 0;
        foreach ($_POST['roof_layer'] as $layer) {
            $t = (float)$layer['thickness'];
            $k = (float)$layer['type_v'];
            if ($k > 0) $R['roof'] += $t / $k;
        }

        // – Pol
        $R['floor'] = 0;
        foreach ($_POST['floor_layer'] as $layer) {
            $t = (float)$layer['thickness'];
            $k = (float)$layer['type_v'];
            if ($k > 0) $R['floor'] += $t / $k;
        }

        // 4) Issiqlik yo‘qotishni Q formulasi
        $dT = abs($outsideTemp - $coldTemp);
        $Q  = [];

        $Q['wall']   = $R['wall']   > 0 ? $wallArea   * $dT * $degreeDays / $R['wall']   : 0;
        $Q['window'] = $R['window'] > 0 ? $windowArea * $dT * $degreeDays / $R['window'] : 0;
        $Q['door']   = $R['door']   > 0 ? $doorArea   * $dT * $degreeDays / $R['door']   : 0;
        $roofArea    = $buildingArea;
        $Q['roof']   = $R['roof']   > 0 ? $roofArea    * $dT * $degreeDays / $R['roof']   : 0;
        $floorArea   = $buildingArea;
        $Q['floor']  = $R['floor']  > 0 ? $floorArea   * $dT * $degreeDays / $R['floor']  : 0;

        // – Ventilyatsiya (misol)
        $airChangeRate = 1.0;
        $Q['vent'] = $shaftArea * $airChangeRate * $dT * 0.34 * 24 * 365;

        // 5) Jami yillik yo‘qotish
        $Q['total_current'] = array_sum($Q);

        // 6) KWh/m2·yil ga o‘tkazish
        $compare_current = $buildingArea > 0
            ? $Q['total_current'] / $buildingArea / 1000
            : 0;

        // 7) Normativ sarf va samaradorlik
        $compare_norm = 67.16;
        $G = $compare_norm > 0
            ? round(100 * ($compare_norm - $compare_current) / $compare_norm, 2)
            : 0;

        $report = compact('R','Q','compare_current','compare_norm','G');
    }
}

include __DIR__ . '/../app/views/header.php';
include __DIR__ . "/../app/views/{$page}.php";
include __DIR__ . '/../app/views/footer.php';
