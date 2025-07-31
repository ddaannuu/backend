<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploads extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index($filename = '') {
        $path = FCPATH . 'uploads/' . $filename;

        if (!file_exists($path)) {
            show_404();
        }

        $mime = mime_content_type($path);
        header("Content-Type: $mime");
        readfile($path);
    }
}
