<?php if (isset($_GET['error'])): ?>
    <div class="error-message message-container">
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
            case 'wrong-pass':
                echo 'Wrong password';
                break;
            default:
                echo 'An unknown error occurred.';
        }
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    <div class="success-message message-container">
        <?php
        switch ($_GET['success']) {
            case 'deleted':
                echo 'Restaurant has been successfully deleted';
                break;
            case 'password-changed':
                echo 'Password has been succesfully changed';
                break;
            default:
                echo 'Success';
        }
        ?>
    </div>
<?php endif; ?>