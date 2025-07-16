<?php defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'           => '',
    'hostname'      => 'mysql-technologia.mysql.database.azure.com', // ← GANTI jika hostname MySQL-mu berbeda
    'username'      => 'admintechnologia',         // ← FORMAT BENAR: username@hostname
    'password'      => '4kUc4hb4g03S',                          // ← GANTI dengan password MySQL kamu
    'database'      => 'db_technologia',                             // ← GANTI jika nama DB berbeda
    'dbdriver'      => 'mysqli',
    'dbprefix'      => '',
    'pconnect'      => FALSE,
    'db_debug'      => (ENVIRONMENT !== 'production'),
    'cache_on'      => FALSE,
    'cachedir'      => '',
    'char_set'      => 'utf8',
    'dbcollat'      => 'utf8_general_ci',
    'swap_pre'      => '',
    'encrypt'       => TRUE,    // ← WAJIB: Azure butuh koneksi SSL
    'ssl_verify'    => FALSE,   // ← FALSE untuk dev/testing, TRUE untuk production
    'compress'      => FALSE,
    'stricton'      => FALSE,
    'failover'      => array(),
    'save_queries'  => TRUE
);
