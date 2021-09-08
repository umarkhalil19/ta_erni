<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
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
        $data['user'] = $this->m_vic->get_data('tbl_users');
        $this->mylib->aview('v_users', $data);
    }

    public function user_add()
    {
        $this->mylib->aview('v_user_add');
    }

    public function user_add_act()
    {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('email', 'Email Aktif', 'required|trim|valid_email|is_unique[tbl_users.user_email]', [
            'is_unique' => 'This Email Has Been Registered!'
        ]);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[tbl_users.user_login]', [
            'is_unique' => 'This Username Has Been Registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('level', 'Level Akun', 'required');
        $this->form_validation->set_rules('status', 'Status Akun', 'required');
        if ($this->form_validation->run() != true) {
            $this->user_add();
        } else {
            $data = [
                'user_name' => $this->input->post('nama'),
                'user_email' => $this->input->post('email'),
                'user_login' => $this->input->post('username'),
                'user_pass' => str_mod(vic_slug_akun($this->input->post('password'))),
                'user_level' => $this->input->post('level'),
                'user_status' => $this->input->post('status'),
            ];
            $this->m_vic->insert_data($data, 'tbl_users');
            $this->session->set_flashdata('suces', 'Data akun berhasil ditambah');
            redirect(base_url('users/index?notif=suces'));
        }
    }

    public function user_edit($id = 0)
    {
        if ($id === 0) {
            $this->session->set_flashdata('error', 'Data tidak ditemukkan!!!');
            redirect(base_url('users/index?notif=error'));
        } else {
            $w = ['user_id' => $id];
            $data['user'] = $this->m_vic->edit_data($w, 'tbl_users')->row();
            $this->mylib->aview('v_user_edit', $data);
        }
    }

    public function user_update()
    {
        if ($this->input->post('id') === '') {
            $this->session->set_flashdata('error', 'Data tidak ditemukkan!!!');
            redirect(base_url('users/index?notif=error'));
        } else {
            $w = ['user_id' => $this->input->post('id')];
            $data = [
                'user_name' => $this->input->post('nama'),
                'user_email' => $this->input->post('email'),
                'user_login' => $this->input->post('username'),
                'user_level' => $this->input->post('level'),
                'user_status' => $this->input->post('status'),
            ];
            $this->m_vic->update_data($w, $data, 'tbl_users');
            $this->session->set_flashdata('suces', 'Data akun berhasil diubah');
            redirect(base_url('users/index?notif=suces'));
        }
    }

    public function user_delete($id = 0)
    {
        if ($id === 0) {
            $this->session->set_flashdata('error', 'Data tidak ditemukkan!!!');
            redirect(base_url('users/index?notif=error'));
        } else {
            $w = ['user_id' => $id];
            $this->m_vic->delete_data($w, 'tbl_users');
            $this->session->set_flashdata('suces', 'Data akun berhasil dihapus');
            redirect(base_url('users/index?notif=suces'));
        }
    }
}
