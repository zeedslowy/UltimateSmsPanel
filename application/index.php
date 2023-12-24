<?php
$valid = true;
if (!version_compare(PHP_VERSION, '5.5.9', '>=')) {
    echo "ERROR: PHP 5.5.9 or higher is required.<br />";
    exit(0);
}
if (!extension_loaded('mbstring')) {
    echo "ERROR: The requested PHP Mbstring extension is missing from your system.<br />";
    exit(0);
}
if (!empty(ini_get('open_basedir'))) {
    echo "ERROR: Please disable the <strong>open_basedir</strong> setting to continue.<br />";
    exit(0);
}

if (!function_exists('proc_open')) {
    echo "ERROR: Please enable <strong>proc_open</strong> php function setting to continue.<br />";
    exit(0);
}

if (!function_exists('base64_decode')) {
    echo "ERROR: Please enable <strong>base64_decode</strong> php function setting to continue.<br />";
    exit(0);
}

if (!(file_exists('application/storage/app') && is_dir('application/storage/app') && (is_writable('application/storage/app')))) {
    echo "ERROR: The directory [application/storage/app] must be writable by the web server.<br />";
    $valid = false;
}
if (!(file_exists('application/storage/framework') && is_dir('application/storage/framework') && (is_writable('application/storage/framework')))) {
    echo "ERROR: The directory [application/storage/framework] must be writable by the web server.<br />";
    $valid = false;
}
if (!(file_exists('application/storage/logs') && is_dir('application/storage/logs') && (is_writable('application/storage/logs')))) {
    echo "ERROR: The directory [application/storage/logs] must be writable by the web server.<br />";
    $valid = false;
}
if (!(file_exists('application/bootstrap/cache') && is_dir('application/bootstrap/cache') && (is_writable('application/bootstrap/cache')))) {
    echo "ERROR: The directory [application/bootstrap/cache] must be writable by the web server.<br />";
    $valid = false;
}

if($valid) {
    require 'main.php';
}
