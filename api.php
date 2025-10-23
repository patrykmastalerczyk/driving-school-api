<?php

/**
 * API entry point for driving school application
 * 
 * This file handles all API requests sent by frontend.
 * Implements Front Controller pattern for request handling centralization.
 * 
 * Supported endpoints:
 * - GET ?action=get - retrieving lessons list
 * - POST ?action=add - adding new lesson
 * - DELETE ?action=delete&id=X - removing lesson
 */

// Enable error display in development mode
if (($_ENV['APP_ENV'] ?? 'production') === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Load configuration
$config = require __DIR__ . '/config.php';

// Initialize dependency injection container
$container = new \DrivingSchool\Container\ServiceContainer($config);

// Get API controller from container
$apiController = $container->getApiController();

// Handle request
$apiController->handleRequest();
