<!DOCTYPE html>
<html lang="en">

<head>
    <?php require __DIR__ . '/../Components/header.php'; ?>
    <title><?= htmlspecialchars($restaurant['name']) ?> | Settings --</title>
    <link rel="stylesheet" href="/styles/settings.css">
</head>

<body>
    <div class="container">
        <h1>-- <?= htmlspecialchars($restaurant['name']) ?> | Settings --</h1>
        <?php require __DIR__ . '/../Components/breadcrumbs.php'; ?>
        <ul class="settings-list">
            <li class="settings-item">
                <a class="setting-title" href="/restaurant/settings/restaurant">Restaurant</a>
                <p>Manage your restaurant info or delete it.</p>
            </li>
            <li class="settings-item">
                <a class="setting-title" href="/restaurant/settings/categories">Categories</a>
                <p>Manage categories you have at your menu.</p>
            </li>
            <li class="settings-item">
                <a class="setting-title" href="/restaurant/settings/items">Items</a>
                <p>Add, edit, or remove menu items and their variants.</p>
            </li>
            <li class="settings-item">
                <a class="setting-title" href="/restaurant/settings/addons">Addons</a>
                <p>Manage addons, select what goes with what.</p>
            </li>
        </ul>
    </div>
</body>

</html>