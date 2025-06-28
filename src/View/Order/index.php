<!DOCTYPE html>
<html lang="en">

<head>
    <?php require __DIR__ . '/../Components/header.php'; ?>
    <title>Order | <?= htmlspecialchars($restaurant['name']) ?></title>
    <link rel="stylesheet" href="/styles/order.css">
</head>

<body>
    <div class="container">
        <h1>-- Welcome to <?= htmlspecialchars($restaurant['name']) ?>! --</h1>
        <?php require __DIR__ . '/../Components/category_menu.php'; ?>
        <?php require __DIR__ . '/menu_items.php'; ?>
        <?php require __DIR__ . '/../Components/footer.php'; ?>
        <a href="/restaurant" class="back-link">Back to Restaurant Settings</a>
    </div>
</body>

</html>