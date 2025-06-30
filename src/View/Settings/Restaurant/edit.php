<!DOCTYPE html>
<html lang="en">

<head>
    <?php require __DIR__ . '/../../Components/header.php'; ?>
    <title>Edit restaurant | KitchenSync</title>
    <link rel="stylesheet" href="/styles/settings.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container restaurant-settings">
        <h1>-- "<?= $restaurant['name'] ?>" | Settings --</h1>
        <?php require __DIR__ . '/../../Components/breadcrumbs.php'; ?>
        <?php require __DIR__ . '/../../Components/info-messages.php'; ?>
        <h2>Update restaurant info</h2>
        <form action="/restaurant/settings/restaurant" method="post" class="bordered-form">
            <div class="input-group">
                <label for="categoryName">Restaurant Name</label>
                <input value="<?= $restaurant['name'] ?>" type="text" id="categoryName" name="name" required>
            </div>
            <div class="input-group">
                <label for="currency">Restaurant Currency</label>
                <input value="<?= $restaurant['currency'] ?>" type="text" id="currency" name="currency" required>
            </div>
            <div class="button-group">
                <button type="submit" name="action" value="update">Update</button>
            </div>
        </form>

        <h2>Change password</h2>
        <form action="/restaurant/settings/restaurant" method="post" class="bordered-form">
            <div class="input-group">
                <label for="oldPassword">Old Password</label>
                <input type="password" id="oldPassword" name="oldPassword" required>
            </div>
            <div class="input-group">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="newPassword" required>
            </div>
            <div class="button-group">
                <button type="submit" name="action" value="change-password">Update Password</button>
            </div>
        </form>

        <h2>Delete restaurant</h2>
        <form action="/restaurant/settings/restaurant" method="post" class="bordered-form" id="delete-form">
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="hidden" name="action" value="delete">
            <div class="button-group">
                <button type="submit">Delete Restaurant</button>
            </div>
        </form>


    </div>

    <script>
        $(document).ready(function () {
            $('#delete-form').on("submit", function (e) {
                e.preventDefault();
                if (confirm("Are you sure you want to delete this restaurant?")) {
                    e.target.submit();
                }
            });
        });
    </script>
</body>

</html>