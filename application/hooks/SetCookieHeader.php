<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SetCookieHeader {
    public function fix_cookie_header() {
        if (headers_sent()) return;

        foreach (headers_list() as $header) {
            if (stripos($header, 'Set-Cookie: ci_session=') !== false) {
                $cookie = explode(';', $header)[0]; // ambil ci_session=xxx
                header_remove('Set-Cookie');
                header("Set-Cookie: $cookie; Path=/; Secure; HttpOnly; SameSite=None", false);
                break;
            }
        }
    }
}
