<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dempster_shafer extends CI_Controller
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
        $data['penyakit'] = $this->m_vic->get_data('tbl_penyakit');
        $data['gejala'] = $this->m_vic->get_data('tbl_gejala');
        $this->mylib->aview('v_dempster', $data);
    }

    public function hapus()
    {
    }
}
