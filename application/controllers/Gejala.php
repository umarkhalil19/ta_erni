<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gejala extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('url');
        $this->load->helper('vic_helper');
        $this->load->helper('vic_convert_helper');
        $this->load->helper('my_helper');
        $this->load->library(array('session', 'form_validation', 'mylib'));
        $this->load->model('m_vic');
        if ($this->session->userdata('level') != 99) {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data['gejala'] = $this->m_vic->get_data('tbl_gejala');
        $this->mylib->aview('v_gejala', $data);
    }

    public function gejala_add()
    {
        $this->mylib->aview('v_gejala_add');
    }

    public function gejala_add_act()
    {
        $this->form_validation->set_rules('gejala', 'Nama Gejala', 'required');
        $this->form_validation->set_rules('kode', 'Kode Gejala', 'required');
        if ($this->form_validation->run() != true) {
            $this->gejala_add();
        } else {
            $data = [
                'gejala_nama' => $this->input->post('gejala'),
                'gejala_kode' => $this->input->post('kode')
            ];
            $this->m_vic->insert_data($data, 'tbl_gejala');
            $this->session->set_flashdata('suces', 'Data Gejala Berhasil Ditambah');
            redirect('Gejala?notif=suces');
        }
    }

    public function gejala_edit($id = 0)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data Gejala tidak ditemukan');
            redirect('Gejala?notif=error');
        } else {
            $w = [
                'gejala_id' => $id
            ];
            $data['gejala'] = $this->m_vic->edit_data($w, 'tbl_gejala')->row();
            $this->mylib->aview('v_gejala_edit', $data);
        }
    }

    public function gejala_update()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('gejala', 'Nama Gejala', 'required');
        $this->form_validation->set_rules('kode', 'Kode Gejala', 'required');
        if ($this->form_validation->run() != true) {
            $this->gejala_edit($id);
        } else {
            $w = ['gejala_id' => $id];
            $data = [
                'gejala_nama' => $this->input->post('gejala'),
                'gejala_kode' => $this->input->post('kode')
            ];
            $this->m_vic->update_data($w, $data, 'tbl_gejala');
            $this->session->set_flashdata('suces', 'Data Gejala Berhasil Diubah');
            redirect('Gejala?notif=suces');
        }
    }

    public function gejala_delete($id = 0)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data Gejala tidak ditemukan');
            redirect('Gejala?notif=error');
        } else {
            $w = ['gejala_id' => $id];
            $this->m_vic->delete_data($w, 'tbl_gejala');
            $this->session->set_flashdata('suces', 'Data Gejala berhasil dihapus');
            redirect('Gejala?notif=suces');
        }
    }
}
