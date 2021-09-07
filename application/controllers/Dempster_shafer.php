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
        if ($this->session->userdata('level') != 99) {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data['penyakit'] = $this->m_vic->get_data('tbl_penyakit');
        $data['gejala'] = $this->m_vic->get_data('tbl_gejala');
        $this->mylib->aview('v_dempster', $data);
    }

    public function dempster_edit($id = 0)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Dempster_shafer?notif=error');
        } else {
            $data['nama'] = $this->db->query("SELECT gejala_nama,gejala_id,gejala_kepercayaan,gejala_ketidakpastian FROM tbl_gejala WHERE gejala_id='$id'")->row();
            $data['penyakit'] = $this->m_vic->get_data('tbl_penyakit');
            $this->mylib->aview('v_dempster_edit', $data);
        }
    }

    public function dempster_update()
    {
        $id = $this->input->post('id');
        $a_penyakit = "";
        $penyakit = $this->m_vic->get_data('tbl_penyakit');
        $a = 0; //total_nilai_pakar
        $b = 0; //pembagi_nilai_pakar
        foreach ($penyakit->result() as $p) {
            $cek = $this->m_vic->edit_data(['gejala_id' => $id, 'penyakit_id' => $p->penyakit_id], 'tbl_dempster');
            if ($this->input->post($p->penyakit_id . 'gejala') != 0) {
                $a = $a + $this->input->post($p->penyakit_id . 'gejala');
                $b = $b + 1;
                $a_penyakit .= $p->penyakit_kode . ',';
                $nilai_1 = $a / $b;
                $nilai_2 = 1 - $nilai_1;
            }
            if ($cek->num_rows() > 0) {
                $c = $cek->row();
                $w = [
                    'dempster_id' => $c->dempster_id
                ];
                $d = [
                    'dempster_nilai' => $this->input->post($p->penyakit_id . 'gejala')
                ];
                $this->m_vic->update_data($w, $d, 'tbl_dempster');
            } else {
                $d = [
                    'gejala_id' => $id,
                    'penyakit_id' => $p->penyakit_id,
                    'dempster_nilai' => $this->input->post($p->penyakit_id . 'gejala')
                ];
                $this->m_vic->insert_data($d, 'tbl_dempster');
            }
        }
        $data = [
            'gejala_kepercayaan' => $nilai_1,
            'gejala_ketidakpastian' => $nilai_2,
            'gejala_string' => substr($a_penyakit, 0, -1)
        ];
        $this->m_vic->update_data(['gejala_id' => $id], $data, 'tbl_gejala');
        $this->session->set_flashdata('suces', 'Data nilai berhasil diubah');
        redirect('Dempster_shafer?notif=suces');
    }
}
