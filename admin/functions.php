<?php
ob_start();
session_start();
include './config.php';

/**
 * Var_dump and die() data using single function
 */
function dd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}

function redirect($url)
{
    header("Location: {$url}");
}

function get_all_rows($table)
{
    global $conn;

    $result = $conn->query("SELECT * FROM $table")->fetchAll();
    return $result;
}

function admin_url()
{
    return home_url() . '/admin';
}

function home_url()
{
    global $site_url_suffix;
    return sprintf(
        "%s://%s/%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $site_url_suffix
    );
}

function is_user_logged_in()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    }
    return false;
}

function get_current_filename()
{
    $name = basename($_SERVER["SCRIPT_FILENAME"]);
    return $name;
}

function nav_active_class($filename)
{
    if (get_current_filename() == $filename) {
        return "active";
    }
    return '';
}