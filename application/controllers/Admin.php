<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
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
        // $this->load->view('pages/v_home');
        $this->mylib->aview('v_home');
    }

    //user
    function users()
    {
        // $this->load->database();
        // $data['user'] = $this->m_vic->get_data('tbl_users');
        $this->mylib->aview('v_users');
    }

    function tambah_users()
    {
        $this->load->database();
        $this->mylib->aview('v_tambah_user');
    }

    function tambah_users_act()
    {
        // $this->load->database();
        // $data = array(
        //     'user_name' => $this->input->post('nama'),
        //     'user_email' => $this->input->post('email'),
        //     'user_login' => $this->input->post('username'),
        //     'user_pass' => str_mod(vic_slug_akun($this->input->post('pass'))),
        //     'user_level' => $this->input->post('level'),
        //     'user_status' => $this->input->post('status'),
        //     'h_pengguna' => $this->session->userdata('username'),
        //     'h_tanggal' => date('Y-m-d'),
        //     'h_waktu' => date('h:i:s')
        // );
        // $this->m_vic->insert_data($data, 'tbl_users');
        // $this->session->set_flashdata('suces', 'Data berhasil di tambah!');
        redirect('admin/users');
    }

    function edit_users($id)
    {
        // $this->load->database();
        // $w = array(
        //     'user_id' => $id
        // );
        // $data['user'] = $this->m_vic->edit_data($w, 'tbl_users')->row();
        $this->mylib->aview('v_edit_user');
    }

    function update_users()
    {
        // $this->load->database();
        // $w = array(
        //     'user_id' => $this->input->post('id')
        // );
        // $data = array(
        //     'user_name' => $this->input->post('nama'),
        //     'user_email' => $this->input->post('email'),
        //     'user_login' => $this->input->post('username'),
        //     'user_level' => $this->input->post('level'),
        //     'user_status' => $this->input->post('status'),
        //     'h_pengguna' => $this->session->userdata('username'),
        //     'h_tanggal' => date('Y-m-d'),
        //     'h_waktu' => date('h:i:s')
        // );
        // $this->m_vic->update_data($w, $data, 'tbl_users');
        // if ($this->input->post('pass') != "") {
        //     $pass = array(
        //         'user_pass' => str_mod(vic_slug_akun($this->input->post('pass')))
        //     );
        //     $this->m_vic->update_data($w, $pass, 'tbl_users');
        // }
        // $this->session->set_flashdata('suces', 'Data berhasil di update!');
        redirect('admin/users');
    }

    function delete_users($id)
    {
        // $w = array(
        //     'user_id' => $id
        // );
        // $this->m_vic->delete_data($w, 'tbl_users');
        // $this->session->set_flashdata('suces', 'Data user berhasil dihapus!');
        redirect('admin/user?notif=suces');
    }

    function reset_password($id)
    {
        $this->load->database();
        $w = [
            'td_id' => $id
        ];
        $data = [
            'td_pass' => str_mod(vic_slug_akun('bkd_malikussaleh'))
        ];
        $this->m_vic->update_data($w, $data, 'tbl_pegawai');
        $this->session->set_flashdata('suces', 'Password Berhasil Direset');
        redirect('admin/pegawai?notif=suces');
    }

    function change_pass()
    {
        $this->mylib->aview('v_change_pass');
    }

    function change_pass_act()
    {
        $this->form_validation->set_rules('pass_lama', 'Password Sekarang', 'required|trim|min_length[1]');
        $this->form_validation->set_rules('pass_baru1', 'Password Baru', 'required|trim|min_length[1]|matches[pass_baru2]');
        $this->form_validation->set_rules('pass_baru2', 'Konfirmasi Password Baru', 'required|trim|min_length[1]|matches[pass_baru1]');

        $w = [
            'user_id' => $this->session->userdata('id'),
            'user_pass' => str_mod(vic_slug_akun($this->input->post('pass_lama')))
        ];
        $user_data = $this->m_vic->edit_data($w, 'tbl_users');
        if ($user_data->num_rows() > 0) {
            if ($this->form_validation->run() != true) {
                $this->mylib->aview('v_change_pass');
            } else {
                $data = [
                    'user_pass' => str_mod(vic_slug_akun($this->input->post('pass_baru1'))),
                ];
                $w2 = [
                    'user_id' => $this->session->userdata('id')
                ];
                $this->m_vic->update_data($w2, $data, 'tbl_users');
                $this->session->set_flashdata('suces', 'Password Berhasil Di Ubah');
                redirect('admin/change_pass?notif=suces');
            }
        } else {
            $this->session->set_flashdata('error', 'Pastikan password lama yang anda masukkan telah benar');
            redirect('admin/change_pass?notif=error');
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    // function cetak_password()
    // {
    //     $this->load->database();
    //     $nidn = $this->db->query("SELECT td_nama_depan,td_id FROM tbl_pegawai")->result();
    //     $pass = str_mod(vic_slug_akun('bkd_malikussaleh'));
    //     foreach ($nidn as $n) {
    //        $w = [
    //            'td_id' => $n->td_id
    //        ];

    //        $data =[
    //            'td_pass' => $pass
    //        ];
    //        $this->m_vic->update_data($w,$data,'tbl_pegawai');
    //        echo $n->td_id.'->'.$pass;
    //     }
    // }
}
