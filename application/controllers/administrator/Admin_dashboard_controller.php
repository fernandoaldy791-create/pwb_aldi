<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard_controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        is_admin_logged_in();
    }

    public function index() {
        $data['title'] = 'Dashboard | Toko Online';
        $data['full_name'] = $this->session->userdata('full_name');
        $this->load->view('administrator/templates/header', $data);
        $this->load->view('administrator/templates/sidebar', $data);
        $this->load->view('administrator/dashboard', $data);
        $this->load->view('administrator/templates/footer');
    }
}
