<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('url');
        $this->load->helper('vic_helper');
        $this->load->helper('vic_convert_helper');
        $this->load->library(array('session', 'form_validation', 'mylib'));
        $this->load->model('m_vic');
        if ($this->session->userdata('level') != 99 && $this->session->userdata('level') != 1) {
            redirect(base_url());
        }
    }

    public function index()
    {
        $this->mylib->aview('v_home');
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }
}
