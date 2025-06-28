<ul class="categories">
    <a href="?category=-1" class="<?= ($currentCategory == -1) ? 'active' : '' ?>">
        All
    </a>
    <?php foreach ($categories as $category): ?>
        <a href="?category=<?= $category['pk'] ?>" class="<?= ($currentCategory == $category['pk']) ? 'active' : '' ?>">
            <?= htmlspecialchars($category['name']) ?>
        </a>
    <?php endforeach; ?>
</ul>