<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_auth_controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Administrator_model', 'administrator');
    }

    public function index() {
        if ($this->session->userdata('admin_login')) {
            redirect('admin/dashboard');
            return;
        }
        $data['title'] = 'Login Administrator | Toko Online';
        $this->load->view('administrator/login', $data);
    }

    public function auth() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Username dan password wajib diisi.');
            redirect('admin/login');
            return;
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', FALSE);
        $admin = $this->administrator->check_login($username, $password);
        if ($admin) {
            $this->session->set_userdata(array(
                'admin_login' => TRUE,
                'admin_id' => $admin['id_admin'],
                'username' => $admin['username'],
                'full_name' => $admin['full_name']
            ));
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah!');
            redirect('admin/login');
        }
    }

    public function logout() {
        $this->session->unset_userdata(array('admin_login', 'admin_id', 'username', 'full_name'));
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}
