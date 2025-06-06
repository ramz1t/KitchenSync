<?php
loadEnv(__DIR__ . '/../.env');

function requireRestaurant(PDO $pdo): array
{
    $restaurantCookie = verifySignedCookie('restaurant_id');
    if (isset($restaurantCookie)) {
        $restaurant = RestaurantModel::getRestaurantById($pdo, (int) $restaurantCookie);
        if ($restaurant) {
            return $restaurant;
        }
    }
    header('Location: /?error=session_expired');
    exit;
}

function createSignedCookie(string $name, string $value)
{
    $signature = hash_hmac('sha256', $value, $_ENV['SECRET'] ?? 'default_secret');
    $signedValue = base64_encode($value . '|' . $signature);
    setcookie($name, $signedValue, time() + 3600, '/', httponly: true, secure: true);
}

function verifySignedCookie(string $name): ?string
{
    if (!isset($_COOKIE[$name])) {
        return null;
    }

    $signedValue = base64_decode($_COOKIE[$name]);
    [$value, $signature] = explode('|', $signedValue);

    $expectedSignature = hash_hmac('sha256', $value, $_ENV['SECRET'] ?? 'default_secret');

    if (hash_equals($expectedSignature, $signature)) {
        return $value; // valid
    } else {
        setcookie($name, '', time() - 3600, '/', httponly: true, secure: true);
        return null; // tampered
    }
}

function loadEnv($path)
{
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0)
            continue;
        list($key, $value) = explode('=', $line, 2);
        putenv(sprintf('%s=%s', $key, $value));
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}