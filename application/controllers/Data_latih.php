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
        $this->load->helper('my_helper');
        $this->load->library(array('session', 'form_validation', 'mylib'));
        $this->load->model('m_vic');
        if ($this->session->userdata('level') != 99) {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data['pasien'] = $this->m_vic->get_data('tbl_pasien');
        // $data['diagnosa'] = $this->db->query("SELECT * FROM tbl_diagnosa");
        // $diagnosa = $this->m_vic->get_data('tbl_diagnosa');
        $this->mylib->aview('v_pasien', $data);
        // echo '<pre>';
        // print_r($diagnosa->result());
        // echo '</pre>';
    }

    public function data_latih_add()
    {
        $data['gejala'] = $this->m_vic->get_data('tbl_gejala');
        $data['penyakit'] = $this->m_vic->get_data('tbl_penyakit');
        $this->mylib->aview('v_data_latih_add', $data);
    }

    public function data_latih_add_act()
    {
        $this->form_validation->set_rules('pasien', 'Nama Pasien', 'required');
        if ($this->form_validation->run() == false) {
            $this->data_latih_add();
        } else {
            $data = [
                'pasien_nama' => $this->input->post('pasien'),
                'penyakit_kode' => $this->input->post('penyakit')
            ];
            // echo $this->input->post('pasien');
            // die;
            $this->m_vic->insert_data($data, 'tbl_pasien');
            $id = $this->db->insert_id();
            $gejala = $this->db->query("SELECT gejala_id FROM tbl_gejala");
            foreach ($gejala->result() as $g) {
                $nilai = $this->input->post($g->gejala_id . 'gejala');
                // if ($nilai == 1) {
                $data_uji = [
                    'pasien_id' => $id,
                    'gejala_id' => $g->gejala_id,
                    'gejala_nilai' => $nilai,
                    'penyakit_kode' => $this->input->post('penyakit')
                ];
                $this->m_vic->insert_data($data_uji, 'tbl_diagnosa');
                // }
            }
            $this->session->set_flashdata('suces', 'Data Latih berhasil ditambah');
            redirect('Data_latih?notif=suces');
        }
    }

    public function data_latih_edit($id = 0)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data Latih tidak ditemukan');
            redirect('Data_latih?notif=error');
        } else {
            $data['latih'] = $this->m_vic->edit_data(['pasien_id' => $id], 'tbl_pasien')->row();
            $data['gejala'] = $this->m_vic->get_data('tbl_gejala');
            $data['penyakit'] = $this->m_vic->get_data('tbl_penyakit');
            $this->mylib->aview('v_data_latih_edit', $data);
        }
    }

    public function data_latih_update()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('pasien', 'Nama Pasien', 'required');
        if ($this->form_validation->run() != true) {
            $this->data_latih_edit($id);
        } else {
            $w = ['pasien_id' => $id];
            $data = [
                'pasien_nama' => $this->input->post('pasien'),
                'penyakit_kode' => $this->input->post('penyakit')
            ];
            $this->m_vic->update_data($w, $data, 'tbl_pasien');
            $this->m_vic->delete_data($w, 'tbl_diagnosa');
            $gejala = $this->db->query("SELECT gejala_id FROM tbl_gejala");
            foreach ($gejala->result() as $g) {
                $nilai = $this->input->post($g->gejala_id . 'gejala');
                // if ($nilai == 1) {
                $data_uji = [
                    'pasien_id' => $id,
                    'gejala_id' => $g->gejala_id,
                    'gejala_nilai' => $nilai,
                    'penyakit_kode' => $this->input->post('penyakit')
                ];
                $this->m_vic->insert_data($data_uji, 'tbl_diagnosa');
                // }
            }
            $this->session->set_flashdata('suces', 'Data Latih berhasil diubah');
            redirect('Data_latih?notif=suces');
        }
    }

    public function data_latih_delete($id = 0)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan');
            redirect('Data_latih?notif=error');
        } else {
            $w = [
                'pasien_id' => $id
            ];
            $this->m_vic->delete_data($w, 'tbl_diagnosa');
            $this->m_vic->delete_data($w, 'tbl_pasien');
            $this->session->set_flashdata('suces', 'Data pasien berhasil dihapus');
            redirect('Data_latih?notif=suces');
        }
    }
}
