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
        <?php require __DIR__ . '/../Components/breadcrumbs.php'; ?>
        <p class="info-p">Please choose one of the following options</p>
        <div class="restaurant-nav">
            <a href="/restaurant/order">Ordering</a>
            <a href="/restaurant/kitchen">For Kitchen</a>
            <a href="/restaurant/settings">Settings</a>
            <a href="/restaurant/logs">Logs</a>
        </div>
        <p class="info-p">Or go back to the mainpage</p>
        <button id="logout-btn" type="submit" data-role="destructive">Logout</button>

        <script>
            function logout() {
                if (confirm("Are you sure you want to log out?")) {
                    document.cookie = "restaurant_pk=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                    window.location.href = "/";
                }
            }
            $(document).ready(function () {
                $('#logout-btn').on('click', logout);
            });
        </script>
    </div>
</body>

</html>