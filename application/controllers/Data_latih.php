<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_latih extends CI_Controller
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
        // if ($this->session->userdata('level') != 99) {
        //     redirect(base_url());
        // }
    }

    public function index()
    {
        $data['pasien'] = $this->m_vic->get_data('tbl_pasien');
        // $data['diagnosa'] = $this->m_vic->get_data('tbl_diagnosa');
        $this->mylib->aview('v_pasien', $data);
    }
}
