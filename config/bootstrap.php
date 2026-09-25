<?php
$path = __DIR__ . '/config.local.php';
if (!is_file($path)) {
    http_response_code(503);
    exit('Copy config/config.example.php to config/config.local.php and configure your local database and admin account.');
}
return require $path;
