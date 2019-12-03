<?php

require 'includes/db.php';

function p($name, $default = '') {
    if (!isset($_POST[$name])) {
        return $default;
    }

    $value = $_POST[$name];
    return sanitize($value);
}

function g($name, $default = '') {
    if (!isset($_GET[$name])) {
        return $default;
    }

    $value = $_GET[$name];
    return sanitize($value);
}

function sanitize($value) {
    return filter_var($value, FILTER_SANITIZE_STRING);
}