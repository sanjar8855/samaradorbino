<h1>Asosiy sahifa</h1>
<?php if (!empty($items)): ?>
    <ul class="list-group">
        <?php foreach($items as $it): ?>
            <li class="list-group-item"><?= htmlspecialchars($it['name']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Hech narsa topilmadi.</p>
<?php endif; ?>
