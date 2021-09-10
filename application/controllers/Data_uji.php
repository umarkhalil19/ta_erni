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
        $this->load->helper('my_helper');
        $this->load->library(array('session', 'form_validation', 'mylib'));
        $this->load->model('m_vic');
        if ($this->session->userdata('level') != 99 && $this->session->userdata('level') != 1) {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data['uji'] = $this->m_vic->get_data('tbl_pasien_uji');
        if ($this->session->userdata('level') == 1) {
            $data['title_sub'] = "Screening";
        } elseif ($this->session->userdata('level') == 99) {
            $data['title_sub'] = "Data Uji";
        }
        $this->mylib->aview('v_pasien_uji', $data);
    }

    public function data_uji_add()
    {
        $data['gejala'] = $this->m_vic->get_data('tbl_gejala');
        if ($this->session->userdata('level') == 1) {
            $data['title_sub'] = "Screening";
        } elseif ($this->session->userdata('level') == 99) {
            $data['title_sub'] = "Data Uji";
        }
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
            $this->session->set_flashdata('suces', 'Data pasien berhasil ditambah');
            redirect('Data_uji?notif=suces');
        }
    }

    public function data_uji_edit($id = 0)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data uji tidak ditemukan');
            redirect('Data_uji?notif=error');
        } else {
            $w = [
                'pasien_uji_id' => $id
            ];
            $data['pasien'] = $this->m_vic->edit_data($w, 'tbl_pasien_uji')->row();
            if ($this->session->userdata('level') == 1) {
                $data['title_sub'] = "Screening";
            } elseif ($this->session->userdata('level') == 99) {
                $data['title_sub'] = "Data Uji";
            }
            // $data['gejala_uji'] = $this->m_vic->edit_data($w, 'tbl_gejala_uji');
            $data['gejala'] = $this->m_vic->get_data('tbl_gejala');
            $this->mylib->aview('v_data_uji_edit', $data);
        }
    }

    public function data_uji_update($id = 0)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan');
            redirect('Data_uji?notif=error');
        } else {
            $this->form_validation->set_rules('pasien', 'Nama Pasien', 'required');
            if ($this->form_validation->run() == false) {
                redirect('Data_uji/data_uji_edit/' . $id);
            } else {
                $data = [
                    'pasien_uji_nama' => $this->input->post('pasien'),
                ];
                $w = [
                    'pasien_uji_id' => $id
                ];
                $this->m_vic->delete_data($w, 'tbl_gejala_uji');
                $this->m_vic->update_data($w, $data, 'tbl_pasien_uji');
                // $id = $this->db->insert_id();
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
                $this->session->set_flashdata('suces', 'Data pasien berhasil diubah');
                redirect('Data_uji?notif=suces');
            }
        }
    }

    public function data_uji_delete($id = 0)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan');
            redirect('Data_uji?notif=error');
        } else {
            $w = [
                'pasien_uji_id' => $id
            ];
            $this->m_vic->delete_data($w, 'tbl_gejala_uji');
            $this->m_vic->delete_data($w, 'tbl_pasien_uji');
            $this->session->set_flashdata('suces', 'Data pasien berhasil dihapus');
            redirect('Data_uji?notif=suces');
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
            // echo "<pre>";
            // print_r($a_poin);
            // echo "</pre>";
            $data['id'] = $id;
            $data['max'] = max($a_poin);
            $data['key'] = array_search(max($a_poin), $a_poin) + 1;
            $key = array_search(max($a_poin), $a_poin) + 1;
            // echo $key;
            $this->m_vic->update_data(['pasien_uji_id' => $id], ['penyakit_kode_nb' => "P0" . "$key"], 'tbl_pasien_uji');
            // redirect('Data_uji');
            $this->mylib->aview('v_hasil_nb', $data);
        }
    }

    public function dempster_shafer($id = 0)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data Uji tidak ditemukan');
            redirect('Data_uji?notif=error');
        }
        $string = $this->db->query("SELECT gejala_id FROM tbl_gejala_uji WHERE pasien_uji_id='$id'");
        $no = 1;
        $array_himpunan = [];
        $array_value = [];
        $teta = 0;
        foreach ($string->result() as $s) {
            $data = $this->db->query("SELECT gejala_string,gejala_kepercayaan,gejala_ketidakpastian FROM tbl_gejala WHERE gejala_id='$s->gejala_id'")->row();
            if ($no == 1) {
                array_push($array_himpunan, $data->gejala_string);
                array_push($array_value, $data->gejala_kepercayaan);
                $teta = $data->gejala_ketidakpastian;
            } else {
                for ($i = 0; $i < count($array_himpunan); $i++) {
                    $array_cek = explode(",", $array_himpunan[$i]);
                    $array_master = explode(",", $data->gejala_string);
                    $array_hasil = array_intersect($array_master, $array_cek);
                    $string_hasil = implode(",", $array_hasil);
                    if ($array_himpunan[$i] == $string_hasil) {
                        $array_value[$i] = ($array_value[$i] * $data->gejala_kepercayaan) + ($array_value[$i] * $data->gejala_ketidakpastian);
                    } else {
                        // in_array($string_hasil,$array_himpunan)
                        if (in_array($string_hasil, $array_himpunan)) {
                            $key = array_search($string_hasil, $array_himpunan);
                            $array_value[$key] = $array_value[$key] + ($array_value[$i] * $data->gejala_kepercayaan);
                            $array_value[$i] = $array_value[$i] * $data->gejala_ketidakpastian;
                        } else {
                            array_push($array_himpunan, $string_hasil);
                            array_push($array_value, $array_value[$i] * $data->gejala_kepercayaan);
                            $array_value[$i] = $array_value[$i] * $data->gejala_ketidakpastian;
                        }
                    }
                }
                if (in_array($data->gejala_string, $array_himpunan)) {
                    $key = array_search($data->gejala_string, $array_himpunan);
                    $array_value[$key] = $array_value[$key] + ($teta * $data->gejala_kepercayaan);
                } else {
                    array_push($array_himpunan, $data->gejala_string);
                    array_push($array_value, $teta * $data->gejala_kepercayaan);
                }
                $teta = $teta * $data->gejala_ketidakpastian;
            }
            $no = $no + 1;
            // echo "<pre>";
            // print_r($array_himpunan);
            // echo "</pre>";
            // echo "<pre>";
            // print_r($array_value);
            // echo "</pre>";
        }
        $d['id'] = $id;
        $d['himpunan'] = $array_himpunan;
        $d['nilai'] = $array_value;
        $d['teta'] = $teta;
        $keys = array_keys($array_value, max($array_value));
        $key = $keys[0];
        $this->m_vic->update_data(['pasien_uji_id' => $id], ['penyakit_kode_ds' => $array_himpunan[$key]], 'tbl_pasien_uji');
        $this->mylib->aview('v_hasil_ds', $d);
    }
}
