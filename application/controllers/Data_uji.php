<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_uji extends CI_Controller
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
        $data['uji'] = $this->m_vic->get_data('tbl_pasien_uji');
        $this->mylib->aview('v_pasien_uji', $data);
    }

    public function data_uji_add()
    {
        $data['gejala'] = $this->m_vic->get_data('tbl_gejala');
        $this->mylib->aview('v_data_uji_add', $data);
    }

    public function data_uji_add_act()
    {
        $this->form_validation->set_rules('pasien', 'Nama Pasien', 'required');
        if ($this->form_validation->run() == false) {
            $this->data_uji_add();
        } else {
            $data = [
                'pasien_uji_nama' => $this->input->post('pasien'),
                'penyakit_kode_nb' => "",
                'penyakit_kode_ds' => "",
            ];
            // echo $this->input->post('pasien');
            // die;
            $this->m_vic->insert_data($data, 'tbl_pasien_uji');
            $id = $this->db->insert_id();
            $gejala = $this->db->query("SELECT gejala_id FROM tbl_gejala");
            foreach ($gejala->result() as $g) {
                $nilai = $this->input->post($g->gejala_id . 'gejala');
                if ($nilai == 1) {
                    $data_uji = [
                        'pasien_uji_id' => $id,
                        'gejala_id' => $g->gejala_id,
                        'gejala_uji_nilai' => $nilai
                    ];
                    $this->m_vic->insert_data($data_uji, 'tbl_gejala_uji');
                }
            }
            redirect('Data_uji');
        }
    }

    public function naive_bayes($id = 0)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data Uji Tidak Ditemukan!');
            redirect('Data_uji?notif=error');
        } else {
            $sick = $this->m_vic->get_data('tbl_penyakit');
            $a_poin = [];
            foreach ($sick->result() as $s) {
                $pp_poin =  $this->db->query("SELECT pp_nilai FROM tbl_prior_probability WHERE penyakit_id='$s->penyakit_id'")->row();
                $poin_lh = 1.0;
                $gjl = $this->db->query("SELECT gejala_id FROM tbl_gejala_uji WHERE pasien_uji_id='$id'");
                foreach ($gjl->result() as $g) {
                    $poin = $this->db->query("SELECT lh_nilai FROM tbl_likelihood WHERE penyakit_kode='$s->penyakit_kode' AND gejala_id='$g->gejala_id'")->row();
                    $poin_lh = $poin_lh * $poin->lh_nilai;
                }
                $hasil = $pp_poin->pp_nilai * $poin_lh;
                array_push($a_poin, $hasil);
            }
            $data['hasil'] = $a_poin;
            $data['max'] = max($a_poin);
            $data['key'] = array_search(max($a_poin), $a_poin) + 1;
            $key = array_search(max($a_poin), $a_poin) + 1;
            // echo $key;
            $this->m_vic->update_data(['pasien_uji_id' => $id], ['penyakit_kode_nb' => "P0" . "$key"], 'tbl_pasien_uji');
            redirect('Data_uji');
        }
    }

    public function dempster_shafer($id = 0)
    {
        # code...
    }
}
