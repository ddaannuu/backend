<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$hook['post_system'][] = array(
    'class'    => 'SetCookieHeader',
    'function' => 'fix_cookie_header',
    'filename' => 'SetCookieHeader.php',
    'filepath' => 'hooks'
);

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/
