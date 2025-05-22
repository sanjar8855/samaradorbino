<h1>Asosiy hisoblash sahifasi</h1>
<div class="container my-5">
    <h5 class="mb-2">Boshlang‘ich ma’lumotlar</h5>
    <form action="" method="POST" class="row g-1">

        <!-- Qurilish hududi + tashqi harorat -->
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
            <label for="heated_area" class="form-label small">Bir qavatdagi isitiladigan xonalar maydoni (m²)</label>
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

        <!-- 1) Tashqi devor turi -->
        <div class="col-12">
            <h3 class="mt-5">Tashqi devor turi</h3>
            <select id="wall_type" name="wall_type" class="form-select" required>
                <option value="">Tanlang...</option>
                <option value="3 qatlamli yig'ma temirbeton panelli">3 qatlamli yig'ma temirbeton panelli</option>
                <option value="Pishgan g‘isht">Pishgan g‘isht</option>
                <option value="Gazoblok">Gazoblok</option>
                <option value="Monolit temirbeton">Monolit temirbeton</option>
                <option value="1 qatlamli yig'ma temirbeton panelli">1 qatlamli yig'ma temirbeton panelli</option>
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
                               name="wall_layer[<?= $i ?>][thickness]"
                               step="0.001"
                               class="form-control"
                               value="<?= $i * 0.1 ?>"
                               placeholder="0.000"/>
                    </td>
                    <td>
                        <select name="wall_layer[<?= $i ?>][type]" class="form-select">
                            <option value="">Tanlang...</option>
                            <?php foreach ($wall_layer as $wl): ?>
                                <option value="<?= $wl['id'] ?>"><?= htmlspecialchars($wl['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number"
                               name="wall_layer[<?= $i ?>][type_v]"
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
            <select id="window_layer" name="window_layer"
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
            <select id="door_layer2" name="door_layer2" class="form-select" required>
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
                               name="door_layer[<?= $i ?>][thickness]"
                               step="0.001"
                               class="form-control"
                               value="<?= $i * 0.1 ?>"
                               placeholder="0.000"/>
                    </td>
                    <td>
                        <select name="door_layer[<?= $i ?>][type]" class="form-select">
                            <option value="">Tanlang...</option>
                            <?php foreach ($doorMaterials as $dm): ?>
                                <option value="<?= $dm['id'] ?>"><?= htmlspecialchars($dm['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number"
                               name="door_layer[<?= $i ?>][type_v]"
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
            <select id="roof_type" name="roof_type" class="form-select" required>
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
                               name="roof_layer[<?= $i ?>][thickness]"
                               step="0.001"
                               class="form-control"
                               value="<?= $i * 0.1 ?>"
                               placeholder="0.000"/>
                    </td>
                    <td>
                        <select name="roof_layer[<?= $i ?>][type]" class="form-select">
                            <option value="">Tanlang...</option>
                            <?php foreach ($roofMaterials as $r): ?>
                                <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number"
                               name="roof_layer[<?= $i ?>][type_v]"
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
                               name="floor_layer[<?= $i ?>][thickness]"
                               step="0.001"
                               class="form-control"
                               value="<?= $i * 0.1 ?>"
                               placeholder="0.000"/>
                    </td>
                    <td>
                        <select name="floor_layer[<?= $i ?>][type]" class="form-select">
                            <option value="">Tanlang...</option>
                            <?php foreach ($roofMaterials as $f): ?>
                                <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number"
                               name="floor_layer[<?= $i ?>][type_v]"
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

        <button type="submit" class="btn btn-primary">Hisoblash</button>

    </form>
    <?php if ($report): ?>
        <hr>
        <h5>Natija hisobot</h5>
        <table class="table table-sm table-bordered">
            <thead class="table-light">
            <tr>
                <th>Kontruksiya</th>
                <th>R (hozirgi)</th>
                <th>Yillik Q yo‘qotish (Vt·soat)</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Display all sections, 'vent' ham null bo‘lmasin deyapmiz:
            foreach ([
                         'wall' => 'Tashqi devor',
                         'window' => 'Tashqi deraza',
                         'door' => 'Tashqi eshik',
                         'roof' => 'Tom',
                         'floor' => 'Pol',
                         'vent' => 'Ventilyatsiya',
                     ] as $key => $label):
                ?>
                <tr>
                    <td><?= $label ?></td>
                    <!-- R bo'lmasa 0 -->
                    <td><?= number_format(($report['R'][$key] ?? 0), 2, '.', ',') ?></td>
                    <!-- Q bo'lmasa 0 -->
                    <td><?= number_format(($report['Q'][$key] ?? 0), 2, '.', ',') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="fw-bold">
                <td>Jami</td>
                <td>-</td>
                <!-- total_current endi Q ichidan olinadi -->
                <td><?= number_format(($report['Q']['total_current'] ?? 0), 2, '.', ',') ?></td>
            </tr>
            </tbody>
        </table>

        <table class="table table-sm">
            <tr>
                <th>Me'yoriy solishtirma sarf</th>
                <td><?= number_format($report['compare_norm'], 2) ?> KWh/m²·yil</td>
            </tr>
            <tr>
                <th>Amaldagi solishtirma sarf</th>
                <td><?= number_format($report['compare_current'], 2) ?> KWh/m²·yil</td>
            </tr>
            <tr>
                <th>Samaradorlik o‘sishi (%)</th>
                <td><?= $report['G'] ?>%</td>
            </tr>
        </table>
    <?php endif; ?>

</div>

<script>
    const regionsData = <?= json_encode(
        array_reduce($regions, function ($carry, $r) {
            $carry[$r['id']] = [
                'cold_temp' => $r['cold_temp'],
                'avg_temp' => $r['average_temp'],
                'duration' => $r['duration'],
            ];
            return $carry;
        }, []),
        JSON_UNESCAPED_UNICODE
    ); ?>;

    const regionSelect = document.getElementById('region');

    // har safar tanlov o'zgarganda
    regionSelect.addEventListener('change', () => {
        const id = regionSelect.value;
        const data = regionsData[id] || {};

        // to‘g‘ri input id’lariga qiymat qo‘yamiz
        document.getElementById('outside_temp').value = data.cold_temp ?? '';
        document.getElementById('avg_below10_temp').value = data.avg_temp ?? '';
        document.getElementById('duration_below10').value = data.duration ?? '';
        document.getElementById('degree_days').value = data.degree_days ?? '';
    });

    // Sahifa yuklanganda (agar oldindan qiymat bo'lsa) avtomatik to'ldirish:
    window.addEventListener('DOMContentLoaded', () => {
        if (regionSelect.value) {
            regionSelect.dispatchEvent(new Event('change'));
        }
    });

    const inputA = document.getElementById('cold_temp');            // A: ichki havo harorati
    const inputB = document.getElementById('avg_below10_temp');     // B: o'rtacha harorat ≤10°C
    const inputC = document.getElementById('duration_below10');     // C: davomiylik (sutka)
    const inputG = document.getElementById('degree_days');          // G: gradus-sutka soni

    // 2) Hisoblash funksiyasi
    function calculateG() {
        const A = parseFloat(inputA.value) || 0;
        const B = parseFloat(inputB.value) || 0;
        const C = parseFloat(inputC.value) || 0;

        const G = (A - B) * C;
        // G ni type="number" inputga kiriting (uch xonalik aniqlik bilan)
        inputG.value = G.toFixed(3);
    }

    // 3) Har uch maydon o'zgarganda hisoblash
    [inputA, inputB, inputC].forEach(el => {
        el.addEventListener('input', calculateG);
    });

    // 4) Sahifa yuklanganda oldindan to'ldirilgan bo'lsa avtomatik hisoblash
    window.addEventListener('DOMContentLoaded', () => {
        calculateG();
    });

    const wallCoeffs = <?= json_encode(
        array_column($wall_layer, 'perm_coeff', 'id'),
        JSON_UNESCAPED_UNICODE
    ) ?>;

    const doorCoeffs = <?= json_encode(
        array_column($doorMaterials, 'perm_coeff', 'id'),
        JSON_UNESCAPED_UNICODE
    ); ?>;

    const roofCoeffs = <?= json_encode(
        array_column($roofMaterials, 'perm_coeff', 'id'),
        JSON_UNESCAPED_UNICODE
    ) ?>;

    const floorCoeffs = <?= json_encode(
        array_column($roofMaterials, 'perm_coeff', 'id'),
        JSON_UNESCAPED_UNICODE
    )?>;
</script>
<script>
    document.querySelectorAll('select[name^="wall_layer"][name$="[type]"]').forEach(select => {
        select.addEventListener('change', () => {
            const id = select.value;
            const coeff = wallCoeffs[id] ?? '';
            // mos qatorni topib, type_v input’ni tanlaymiz
            const row = select.closest('tr');
            const inputV = row.querySelector('input[name$="[type_v]"]');
            inputV.value = coeff;
        });
    });

    document.querySelectorAll('select[name^="door_layer"][name$="[type]"]').forEach(select => {
        select.addEventListener('change', () => {
            const id = select.value;
            const coeff = doorCoeffs[id] ?? '';
            // Shu select turgan qatorni topib, type_v input’ga yozamiz
            const row = select.closest('tr');
            const input = row.querySelector('input[name$="[type_v]"]');
            input.value = coeff;
        });
    });

    document.querySelectorAll('select[name^="roof_layer"][name$="[type]"]').forEach(select => {
        select.addEventListener('change', () => {
            const id = select.value;
            const coeff = roofCoeffs[id] ?? '';
            const row = select.closest('tr');
            row.querySelector('input[name$="[type_v]"]').value = coeff;
        });
    });

    // Floor layer select’lari uchun
    document.querySelectorAll('select[name^="floor_layer"][name$="[type]"]').forEach(select => {
        select.addEventListener('change', () => {
            const id = select.value;
            const coeff = floorCoeffs[id] ?? '';
            const row = select.closest('tr');
            row.querySelector('input[name$="[type_v]"]').value = coeff;
        });
    });
</script>
