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
        $string = $this->db->query("SELECT gejala_id FROM tbl_gejala_uji WHERE pasien_uji_id='2'");
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
            echo "<pre>";
            print_r($array_value);
            echo "</pre>";
        }
    }
}
