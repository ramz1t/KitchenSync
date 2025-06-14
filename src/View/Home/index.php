<!DOCTYPE html>
<html lang="en">

<head>
    <?php require __DIR__ . '/../Components/header.php'; ?>
    <title>KitchenSync</title>
    <link rel="stylesheet" href="styles/home.css">
</head>

<body>
    <div class="container">
        <div id="welcome-block">
            <h1>-- Welcome to KitchenSync --</h1>
            <p>
                KitchenSync is a simple and efficient KDS designed to help restaurant teams manage orders in real
                time.
                <br><br>
                It allows staff to place orders, view them on different kitchen screens (grill, beverages, snacks,
                etc.),
                and customize which orders are visible on which screen.
                <br><br>
                Whether you're running a fast-paced kitchen or a small cafe, KitchenSync helps keep your workflow
                organized
                and synchronized.
            </p>
        </div>
        <h2>Please find your restaurant or register a new one to continue</h2>
        <form action="/restaurant" method="post" class="bordered-form">
            <div class="input-group">
                <label for="restaurant-name">Restaurant name</label>
                <input type="text" id="restaurant-name" name="name" required>
            </div>
            <div class="input-group">
                <label for="restaurant-pass">Password</label>
                <input type="password" id="restaurant-pass" name="pass" required>
            </div>
            <div class="button-group">
                <button type="submit" name="action" value="find">Find</button>
                <button type="submit" name="action" value="create">Create</button>
            </div>
        </form>
        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php
                switch ($_GET['error']) {
                    case 'session_expired':
                        echo 'Your session has expired. Please log in again.';
                        break;
                    case 'invalid':
                        echo 'Invalid restaurant name or password.';
                        break;
                    case 'empty_fields':
                        echo 'Please fill in all fields.';
                        break;
                    case 'invalid_action':
                        echo 'Invalid action. Please try again.';
                        break;
                    case 'duplicate_name':
                        echo 'A restaurant with this name already exists. Please choose a different name.';
                        break;
                    case 'creation_failed':
                        echo 'Failed to create the restaurant. Please try again later.';
                        break;
                    default:
                        echo 'An unknown error occurred.';
                }
                ?>
            </div>
        <?php endif; ?>
        <?php require __DIR__ . '/../Components/footer.php'; ?>
    </div>
</body>

</html>