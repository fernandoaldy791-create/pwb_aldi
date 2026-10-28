<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator_model extends CI_Model {
    private $_table = 'administrator';

    public function check_login($username, $password) {
        return $this->db->get_where($this->_table, array(
            'username' => $username,
            'password' => md5($password)
        ))->row_array();
    }
}
