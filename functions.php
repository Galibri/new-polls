<?php
ob_start();
session_start();
include './admin/config.php';

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

function get_answers_by_question_id($id)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM answers WHERE question_id=:question_id");
    $stmt->execute(['question_id' => $id]);

    return $stmt->fetchAll();
}

function get_current_filename()
{
    $name = basename($_SERVER["SCRIPT_FILENAME"]);
    return $name;
}

function nav_active_class($filename, $className = 'active')
{
    if (get_current_filename() == $filename) {
        return $className;
    }
    return '';
}

function count_global_answers($id)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM user_answers WHERE answer_id=:answer_id");
    $stmt->execute(['answer_id' => $id]);

    return $stmt->rowCount();
}