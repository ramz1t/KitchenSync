<!DOCTYPE html>
<html lang="en">

<head>
    <?php require __DIR__ . '/../Components/header.php'; ?>
    <title>Order | <?= htmlspecialchars($restaurantName) ?></title>
    <link rel="stylesheet" href="/styles/order.css">
</head>

<body>
    <div class="container">
        <h1>-- Welcome to <?= htmlspecialchars($restaurantName) ?>! --</h1>
        <ul class="categories">
            <a href="">Burgers</a>
            <a href="">Pizzas</a>
            <a href="">Salads</a>
            <a href="">Drinks</a>
            <a href="">Desserts</a>
        </ul>
        <?php require __DIR__ . '/../Components/footer.php'; ?>
    </div>
</body>

</html>