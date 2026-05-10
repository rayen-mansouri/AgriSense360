<?php
$url = "https://localhost:8000/management/workers";
$context = stream_context_create([
    'http' => ['ignore_errors' => true],
    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
]);

$response = @file_get_contents($url, false, $context);
if ($response === false) {
    echo "Failed to connect\n";
    print_r($http_response_header);
} else {
    echo "HTTP Status: " . ($http_response_header[0] ?? 'Unknown') . "\n";
    echo substr($response, 0, 500);
}
