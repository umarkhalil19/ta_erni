<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
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
    }

    public function index()
    {
        // $random_number = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        // $vals = array(
        //     'word' => $random_number,
        //     'img_path' => './captcha/',
        //     'img_url' => base_url() . 'captcha/',
        //     'img_width' => 270,
        //     'img_height' => 32,
        //     //'expiration' => 7200
        //     'expiration' => 20
        // );
        // $data['captcha'] = create_captcha($vals);
        // $this->session->set_userdata('captchaWord', $data['captcha']['word']);
        $this->load->view('v_login.php');
    }

    public function cek()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[100]');
        // $this->form_validation->set_rules('userCaptcha', 'Captcha', 'required|callback_check_captcha');
        $userCaptcha = $this->input->post('userCaptcha');

        if ($this->form_validation->run() != true) {
            $this->index();
        } else {
            $uname = vic_slug_akun($this->input->post('username'));
            $pass = str_mod(vic_slug_akun($this->input->post('password')));
            $where = array(
                'user_login' => $uname,
                'user_pass' => $pass,
                'user_status' => 'Aktif'
            );
            $data = $this->m_vic->edit_data($where, 'tbl_users');
            if ($data->num_rows() > 0) {
                $mydata = $data->row();
                $session = [
                    'id' => $mydata->user_id,
                    'nama' => $mydata->user_name,
                    'login' => $mydata->user_login,
                    'email' => $mydata->user_email,
                    'level' => $mydata->user_level,
                ];
                $this->session->set_userdata($session);
                redirect('Dashboard');
            } else {
                $this->session->set_flashdata('error', 'Username atau Password anda salah');
                redirect('login?notif=error');
            }
        }
    }

    public function check_captcha($str)
    {
        $word = $this->session->userdata('captchaWord');
        if (strcmp(strtoupper($str), strtoupper($word)) == 0) {
            return true;
        } else {
            $this->form_validation->set_message('check_captcha', 'Silakan masukkan angka-angka yang benar!');
            return false;
        }
    }
}
