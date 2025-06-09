<?php
session_start();

function checkLogin() {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }
}

function checkAdmin() {
    checkLogin();
    if ($_SESSION['rol'] !== 'admin') {
        header('Location: access-denied.php');
        exit;
    }
}

function checkUser() {
    checkLogin();
    if ($_SESSION['rol'] !== 'usuario') {
        header('Location: access-denied.php');
        exit;
    }
}

function getCurrentUser() {
    return [
        'id' => $_SESSION['usuario_id'],
        'nombre' => $_SESSION['nombre'],
        'rol' => $_SESSION['rol']
    ];
}
?> 