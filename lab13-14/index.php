<?php
session_start();

/* =========================
   DEFAULT PAGE
   ========================= */
$page = $_GET['page'] ?? 'user/list';

/* =========================
   WHITELIST PAGE
   ========================= */
$allowed = [
    'user/list',
    'user/add',
    'user/edit',
    'user/delete',
    'user/profile',
    'auth/login',
    'auth/logout',
    'auth/register',
    'auth/forgot-password',
    'auth/reset-password'
];

if (!in_array($page, $allowed)) {
    http_response_code(404);
    die('Halaman tidak ditemukan.');
}

/* =========================
   PROTEKSI LOGIN
   ========================= */
$publicPages = ['auth/login', 'auth/register', 'auth/forgot-password', 'auth/reset-password'];
if (!isset($_SESSION['is_login']) && !in_array($page, $publicPages)) {
    header('Location: index.php?page=auth/login');
    exit;
}

/* =========================
   PROTEKSI ROLE ADMIN
   ========================= */
$adminPages = ['user/add', 'user/edit', 'user/delete'];
if (
    in_array($page, $adminPages) &&
    ($_SESSION['role'] ?? '') !== 'admin'
) {
    die('Akses ditolak');
}

/* =========================
   LOAD MODULE
   ========================= */
[$folder, $file] = explode('/', $page);
$modulePath = __DIR__ . "/modules/$folder/$file.php";

if (!file_exists($modulePath)) {
    http_response_code(404);
    die('File modul tidak ditemukan.');
}

/* =========================
   LAYOUT (INI KUNCI)
   ========================= */
require __DIR__ . '/views/header.php';
require $modulePath;