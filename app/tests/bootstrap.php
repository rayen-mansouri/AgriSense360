<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__, 2).'/app/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__, 2).'/app/.env');
}

if ($_SERVER['APP_DEBUG'] ?? false) {
    umask(0000);
}
