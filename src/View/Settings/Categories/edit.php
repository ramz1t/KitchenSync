<!DOCTYPE html>
<html lang="en">

<head>
    <?php require __DIR__ . '/../../Components/header.php'; ?>
    <title>Edit</title>
    <link rel="stylesheet" href="/styles/settings.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>-- Edit #<?= htmlspecialchars($categoryPk) ?> | Categories --</h1>
        <?php require __DIR__ . '/../../Components/breadcrumbs.php'; ?>
        <form action="/restaurant/settings/categories/edit?pk=<?= htmlspecialchars($categoryPk) ?>" method="post"
            class="bordered-form">
            <div class="input-group">
                <label for="categoryName">Category Name</label>
                <input value="<?= $category['name'] ?>" type="text" id="categoryName" name="name" required>
            </div>
            <div class="input-group">
                <label for="categoryPosition">Category Position</label>
                <input value="<?= $category['position'] ?>" type="number" id="categoryPosition" name="position">
                <p>Position is used to order categories on the order screen</p>
            </div>
            <div class="button-group">
                <button id="updateBtn" type="submit" name="action" value="create">Update</button>
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