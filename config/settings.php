<?php declare(strict_types=1);

// Set sane timezone for backend processes.
date_default_timezone_set('UTC');

// Initialize configuration array.
$settings = [];

// Register configurations.
$settings['path']   = require __DIR__ . '/path.php';
$settings['error']  = require __DIR__ . '/error.php';
$settings['logger'] = require __DIR__ . '/logger.php';

// Return array to container.
return $settings;
