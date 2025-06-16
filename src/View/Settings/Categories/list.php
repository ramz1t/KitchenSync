<!DOCTYPE html>
<html lang="en">

<head>
    <?php require __DIR__ . '/../../Components/header.php'; ?>
    <title><?= htmlspecialchars($restaurant['name']) ?> | Categories --</title>
    <link rel="stylesheet" href="/styles/settings.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>-- Categories | Settings--</h1>
        <?php require __DIR__ . '/../../Components/breadcrumbs.php'; ?>
        <ul class="settings-list">
            <?php foreach ($categories as $category): ?>
                <li class="category-item">
                    <span>Position: <?= $category['position'] ?> |</span>
                    <p><?= htmlspecialchars($category['name']) ?></p>
                    <a class="button"
                        href="/restaurant/settings/categories/edit?pk=<?= htmlspecialchars($category['pk']) ?>">Edit</a>
                    <button class="delete-category" data-pk="<?= htmlspecialchars($category['pk']) ?>"
                        data-name="<?= htmlspecialchars($category['name']) ?>">Delete</button>
                </li>
            <?php endforeach; ?>
        </ul>
        <form action="/restaurant/settings/categories" method="post" class="bordered-form">
            <div class="input-group">
                <label for="category-name">Category Name</label>
                <input type="text" id="category-name" name="name" required>
            </div>
            <div class="button-group">
                <button type="submit" name="action" value="create">Add Category</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('.delete-category').click(function () {
                var categoryPk = $(this).data('pk');
                var categoryName = $(this).data('name');

                if (confirm(`Are you sure you want to delete this category (${categoryName})?`)) {
                    $.post({
                        url: '/restaurant/settings/categories',
                        data: { pk: categoryPk, action: 'delete' },
                        success: function (response) {
                            window.location.reload();
                        },
                        error: function (xhr, status, error) {
                            alert('Error deleting category: ' + xhr.responseText);
                        }
                    });

                }
            });
        });
    </script>
</body>

</html>