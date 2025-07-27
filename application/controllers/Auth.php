<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    private $max_failed_attempts = 5;  
    private $lockout_time = 60;  

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('User_model');
    }

    public function login_api() {

		header("Access-Control-Allow-Origin: https://nice-flower-0c59cd800.1.azurestaticapps.net");
		header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Authorization");
		header("Access-Control-Allow-Credentials: true");
		header("Content-Type: application/json");


        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("Access-Control-Allow-Origin: https://nice-flower-0c59cd800.1.azurestaticapps.net");
            header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Authorization");
            header("Access-Control-Allow-Credentials: true");
            exit(0);
        }
		$data_raw = file_get_contents("php://input");
		log_message('debug', 'DATA RAW: ' . $data_raw);
		$data = json_decode($data_raw, true);

        // $data = json_decode(file_get_contents("php://input"), true);

        $username = trim($data['username'] ?? '');
        $password = trim($data['password'] ?? '');

        if (empty($username) || empty($password)) {
            echo json_encode(['status' => false, 'message' => 'Username dan password wajib diisi']);
            return;
        }

        if ($this->isLockedOut($username)) {
            $remaining = $this->getLockoutRemaining($username);
            echo json_encode([
                'status' => false,
                'message' => "Terlalu banyak percobaan login gagal. Silakan coba lagi setelah {$remaining} detik."
            ]);
            return;
        }

        $user = $this->User_model->get_by_username($username);

        if ($user && password_verify($password, $user['password'])) {
            $this->clearFailedAttempts($username);

            $this->session->set_userdata([
                'user_id'      => $user['id'],
                'username'     => $user['username'],
                'nama_lengkap' => $user['nama_lengkap'],
                'role'         => $user['role']
            ]);

            echo json_encode([
                'status' => true,
                'message' => 'Login berhasil',
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'role' => $user['role']
                ]
            ]);
        } else {
            $this->addFailedAttempt($username);

            $remaining_attempts = $this->max_failed_attempts - $this->getFailedAttempts($username);

            $msg = "Username atau password salah.";
            if ($remaining_attempts <= 0) {
                $msg .= " Anda harus menunggu 1 menit sebelum mencoba lagi.";
            } else {
                $msg .= " Anda memiliki sisa {$remaining_attempts} percobaan lagi.";
            }

            echo json_encode(['status' => false, 'message' => $msg]);
        }
    }

    private function isLockedOut($username) {
        $attempts = $this->session->userdata('failed_attempts_' . $username);
        $last_failed_time = $this->session->userdata('last_failed_time_' . $username);

        if ($attempts && $attempts >= $this->max_failed_attempts) {
            $elapsed = time() - $last_failed_time;
            return $elapsed < $this->lockout_time;
        }

        return false;
    }

    private function getLockoutRemaining($username) {
        $last_failed_time = $this->session->userdata('last_failed_time_' . $username);
        return max(0, $this->lockout_time - (time() - $last_failed_time));
    }

    private function addFailedAttempt($username) {
        $attempts = $this->session->userdata('failed_attempts_' . $username) ?? 0;
        $attempts++;

        $this->session->set_userdata('failed_attempts_' . $username, $attempts);
        $this->session->set_userdata('last_failed_time_' . $username, time());
    }

    private function clearFailedAttempts($username) {
        $this->session->unset_userdata('failed_attempts_' . $username);
        $this->session->unset_userdata('last_failed_time_' . $username);
    }

    private function getFailedAttempts($username) {
        return $this->session->userdata('failed_attempts_' . $username) ?? 0;
    }
}
