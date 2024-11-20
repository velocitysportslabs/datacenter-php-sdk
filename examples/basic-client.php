<?php


use VelocitySportsLabs\DataCenter\Client;
use VelocitySportsLabs\DataCenter\HttpClient\Options;

require_once __DIR__ . '/../vendor/autoload.php';

$options = new Options([
    'auth_token' => 'tvlA6SHgk8veTGLPD6CC11ZyyTo5yLDPaThxTFd7',
    'origin' => 'http://vsl-proteams.test',
]);

$client = new Client($options);
$response = $client->countries()->list();

dump($response);
