<?php

/**
 * Application configuration
 * 
 * Contains database settings and other
 * application configuration parameters
 */

return [
    'database' => [
        'host' => $_ENV['DB_HOST'] ?? 'mysql',
        'database' => $_ENV['DB_NAME'] ?? 'planjazd',
        'username' => $_ENV['DB_USER'] ?? 'planjazd_user',
        'password' => $_ENV['DB_PASS'] ?? 'planjazd_password',
    ],
    'app' => [
        'name' => 'Driving School',
        'version' => '1.0.0',
        'environment' => $_ENV['APP_ENV'] ?? 'production',
    ]
];
