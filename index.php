<?php
require_once 'controllers.php';

$requestUri = strtok($_SERVER['REQUEST_URI'], '?');

if ($requestUri === '/' || $requestUri === '/home') {
    home_action();
} elseif (preg_match('/^\/booking\/(\d+)$/', $requestUri, $matches)) {
    booking_action((int)$matches[1]);
} else {
    http_response_code(404);
    echo "Page non trouvée.";
}
?>