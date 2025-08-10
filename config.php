<?php
// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set Timezone
ini_set('date.timezone', 'Asia/Manila');
date_default_timezone_set('Asia/Manila');

// Include required files (Fix incorrect paths)
require_once __DIR__ . '/initialize.php';  // Ensure this file exists
require_once __DIR__ . '/classes/DBConnection.php';
require_once __DIR__ . '/classes/SystemSettings.php';

// Establish database connection
$db = new DBConnection;
$conn = $db->conn;

/**
 * Redirects to a specified URL.
 */
function redirect($url = '') {
    if (!empty($url)) {
        echo '<script>location.href="' . base_url . $url . '"</script>';
    }
}

/**
 * Validate image path.
 */
function validate_image($file) {
    global $_settings;
    if (!empty($file)) {
        $ex = explode("?", $file);
        $file = $ex[0];
        $ts = isset($ex[1]) ? "?" . $ex[1] : '';

        if (is_file(__DIR__ . '/' . $file)) {
            return base_url . $file . $ts;
        } else {
            return base_url . $_settings->info('logo');
        }
    } else {
        return base_url . $_settings->info('logo');
    }
}