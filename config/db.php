<?php declare(strict_types=1);

$db = [];

$db['connections'] = [];

$db['connections']['mysql'] = [
    'driver'    => 'pdo_mysql',
    'host'      => 'localhost',
    'port'      => 3306,
    'dbname'    => 'example',
    'user'      => 'root',
    'password'  => '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'driverOptions' => [
        PDO::ATTR_PERSISTENT            => false,
        PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES      => true,
        PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND    => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
    ],
];

// Grab connections from environment config
$connections = appEnv('db', []);

// Add connections to array.
foreach ($connections as $name => $config) {
    $db['connections'][$name] = $config;
}

return $db;
