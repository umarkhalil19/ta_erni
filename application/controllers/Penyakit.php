<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit extends CI_Controller
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
        $data['penyakit'] = $this->m_vic->get_data('tbl_penyakit');
        $this->mylib->aview('v_penyakit', $data);
    }

    public function penyakit_add()
    {
        $this->mylib->aview('v_penyakit_add');
    }

    public function penyakit_add_act()
    {
        $this->form_validation->set_rules('penyakit', 'Nama Penyakit', 'required');
        $this->form_validation->set_rules('kode', 'Kode Penyakit', 'required');
        if ($this->form_validation->run() != true) {
            $this->penyakit_add();
        } else {
            $data = [
                'penyakit_nama' => $this->input->post('penyakit'),
                'penyakit_kode' => $this->input->post('kode')
            ];
            $this->m_vic->insert_data($data, 'tbl_penyakit');
            $last = $this->db->insert_id();
            $gejala = $this->m_vic->get_data('tbl_gejala');
            foreach ($gejala->result() as $g) {
                $dampster = [
                    'gejala_id' => $g->gejala_id,
                    'penyakit_id' => $last,
                    'dempster_nilai' => 0
                ];
                $this->m_vic->insert_data($dampster, 'tbl_dempster');
            }
            $this->session->set_flashdata('suces', 'Data Penyakit Berhasil Ditambah');
            redirect('Penyakit?notif=suces');
        }
    }

    public function penyakit_edit($id = 0)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data Penyakit tidak ditemukan');
            redirect('Penyakit?notif=error');
        } else {
            $w = [
                'penyakit_id' => $id
            ];
            $data['penyakit'] = $this->m_vic->edit_data($w, 'tbl_penyakit')->row();
            $this->mylib->aview('v_penyakit_edit', $data);
        }
    }

    public function penyakit_update()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('penyakit', 'Nama Penyakit', 'required');
        $this->form_validation->set_rules('kode', 'Kode Penyakit', 'required');
        if ($this->form_validation->run() != true) {
            $this->penyakit_edit($id);
        } else {
            $w = ['penyakit_id' => $id];
            $data = [
                'penyakit_nama' => $this->input->post('penyakit'),
                'penyakit_kode' => $this->input->post('kode')
            ];
            $this->m_vic->update_data($w, $data, 'tbl_penyakit');
            $this->session->set_flashdata('suces', 'Data Penyakit Berhasil Diubah');
            redirect('Penyakit?notif=suces');
        }
    }

    public function penyakit_delete($id = 0)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data Penyakit tidak ditemukan');
            redirect('Penyakit?notif=error');
        } else {
            $w = ['penyakit_id' => $id];
            $this->m_vic->delete_data($w, 'tbl_penyakit');
            $this->session->set_flashdata('suces', 'Data Penyakit berhasil dihapus');
            redirect('Penyakit?notif=suces');
        }
    }
}
