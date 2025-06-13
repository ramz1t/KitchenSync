<!-- View/Components/breadcrumbs.php -->
<nav class="breadcrumbs">
    <?php foreach ($breadcrumbs as $index => $crumb): ?>
        <?php
        $name = $crumb[0];
        $url = $crumb[1];
        $isLast = ($index === array_key_last($breadcrumbs));
        ?>
        <?php if ($url && !$isLast): ?>
            <a href="<?= htmlspecialchars($url) ?>">
                <?= htmlspecialchars($name) ?>
            </a>
        <?php else: ?>
            <span class="current"><?= htmlspecialchars($name) ?></span>
        <?php endif; ?>

        <?php if (!$isLast): ?>
            &raquo;
        <?php endif; ?>
    <?php endforeach; ?>
</nav>