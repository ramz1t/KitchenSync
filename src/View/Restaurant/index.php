<!DOCTYPE html>
<html lang="en">

<head>
    <?php require __DIR__ . '/../Components/header.php'; ?>
    <title><?= htmlspecialchars($restaurantName) ?> | KitchenSync</title>
    <link rel="stylesheet" href="styles/restaurant-menu.css">
</head>

<body>
    <div class="container">
        <h1>-- <?= htmlspecialchars($restaurantName) ?> | KitchenSync --</h1>
        <p class="info-p">-- Please choose one of the following options --</p>
        <div class="restaurant-nav">
            <a href="/restaurant/kitchen">For Kitchen</a>
            <a href="/restaurant/order">Ordering</a>
            <a href="/restaurant/settings">Settings</a>
        </div>
        <p class="info-p">Or go back to the mainpage</p>
        <form action="/logout" method="post">
            <button type="submit" data-role="destructive">Logout</button>
        </form>
    </div>
</body>

</html>