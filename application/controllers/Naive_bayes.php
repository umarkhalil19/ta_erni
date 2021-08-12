<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Naive_bayes extends CI_Controller
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
        $data['pp'] = $this->m_vic->get_data('tbl_prior_probability');
        $this->mylib->aview('v_naive_bayes', $data);
    }

    public function prior_probability()
    {
        $penyakit = $this->m_vic->get_data('tbl_penyakit');
        $tot = $this->db->query("SELECT COUNT(pasien_id) as total FROM tbl_pasien")->row();
        foreach ($penyakit->result() as $p) {
            $j = $this->db->query("SELECT COUNT(pasien_id) as nilai FROM tbl_pasien WHERE penyakit_kode='$p->penyakit_kode'")->row();
            $nilai_pp = $j->nilai / $tot->total;
            $w = [
                'penyakit_id' => $p->penyakit_id
            ];
            $cek = $this->m_vic->edit_data($w, 'tbl_prior_probability');
            if ($cek->row()) {
                $data = [
                    'pp_nilai' => $nilai_pp
                ];
                $this->m_vic->update_data($w, $data, 'tbl_prior_probability');
            } else {
                $data = [
                    'penyakit_id' => $p->penyakit_id,
                    'pp_nilai' => $nilai_pp
                ];
                $this->m_vic->insert_data($data, 'tbl_prior_probability');
            }
        }
        redirect('Naive_bayes');
    }

    public function likelihood()
    {
        $penyakit = $this->m_vic->get_data('tbl_penyakit');
        $gejala = $this->m_vic->get_data('tbl_gejala');
        foreach ($penyakit->result() as $p) {
            $a = $this->db->query("SELECT COUNT(pasien_id) as a FROM tbl_pasien WHERE penyakit_kode='$p->penyakit_kode'")->row();
            foreach ($gejala->result() as $gj) {
                $b = $this->db->query("SELECT COUNT(diagnosa_id) as b FROM tbl_diagnosa WHERE gejala_id='$gj->gejala_id' AND gejala_nilai='1' AND penyakit_kode='$p->penyakit_kode'")->row();
                $w = [
                    'penyakit_kode' => $p->penyakit_kode,
                    'gejala_id' => $gj->gejala_id
                ];
                $cek = $this->m_vic->edit_data($w, 'tbl_likelihood');
                if ($cek->row()) {
                    $data = [
                        'lh_nilai' => $b->b / $a->a
                    ];
                    $this->m_vic->update_data($w, $data, 'tbl_likelihood');
                } else {
                    $data = [
                        'penyakit_kode' => $p->penyakit_kode,
                        'gejala_id' => $gj->gejala_id,
                        'lh_nilai' => $b->b / $a->a
                    ];
                    $this->m_vic->insert_data($data, 'tbl_likelihood');
                }
            }
        }
        redirect('Naive_bayes');
    }

    // public function cek()
    // {
    //     $a = array("P01", "P03");
    //     $b = array("P01", "P03");
    //     if ($a == $b) {
    //         echo '1';
    //     } else {
    //         echo '0';
    //     }
    // }
}
