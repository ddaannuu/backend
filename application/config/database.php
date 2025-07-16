<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'         => '',
    'hostname'    => 'mysql-technologia.mysql.database.azure.com', // Ganti jika berbeda
    'username'    => 'admintechnologia',         // Format: user@host
    'password'    => '4kUc4hb4g03S',                                  // Ganti dengan password kamu
    'database'    => 'db_technologia',
    'dbdriver'    => 'mysqli',
    'dbprefix'    => '',
    'pconnect'    => FALSE,
    'db_debug'    => (ENVIRONMENT !== 'production'),
    'cache_on'    => FALSE,
    'cachedir'    => '',
    'char_set'    => 'utf8',
    'dbcollat'    => 'utf8_general_ci',
    'swap_pre'    => '',
    'encrypt'     => [
        'ssl_verify' => FALSE
    ],
    'compress'    => FALSE,
    'stricton'    => FALSE,
    'failover'    => array(),
    'save_queries'=> TRUE
);
