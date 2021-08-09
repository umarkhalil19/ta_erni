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
        // if ($this->session->userdata('level') != 99) {
        //     redirect(base_url());
        // }
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

    //bidang_kegiatan
    public function bidang_kegiatan()
    {
        $this->load->database();
        $data['bidang'] = $this->m_vic->get_data('tbl_bidang');
        $this->mylib->aview('v_bidang_kegiatan', $data);
    }

    public function tambah_bidang_kegiatan()
    {
        $this->mylib->aview('v_tambah_bidang_kegiatan');
    }

    public function tambah_bidang_kegiatan_act()
    {
        $this->load->database();
        $this->form_validation->set_rules('bidang', 'Bidang', 'required');
        if ($this->form_validation->run() != true) {
            $this->tambah_bidang_kegiatan();
        } else {
            $data = [
                'bidang_nama' => $this->input->post('bidang')
            ];
            $this->m_vic->insert_data($data, 'tbl_bidang');
            redirect('admin/bidang_kegiatan');
        }
    }

    public function edit_bidang_kegiatan($id)
    {
        $this->mylib->aview('v_edit_bidang_kegiatan');
    }

    public function update_bidang_kegiatan()
    {
        redirect('admin/bidang_kegiatan');
    }

    //jenis kegiatan
    function jenis_kegiatan($id)
    {
        $this->load->database();
        $data['bidang'] = $this->db->query("SELECT bidang_id,bidang_nama FROM tbl_bidang WHERE bidang_id='$id'")->row();
        $w = [
            'bidang_id' => $id
        ];
        $data['kegiatan'] = $this->m_vic->edit_data($w, 'tbl_kegiatan');
        $this->mylib->aview('v_jenis_kegiatan', $data);
    }

    function tambah_jenis_kegiatan($id)
    {
        $this->load->database();
        $data['bidang'] = $this->db->query("SELECT bidang_id,bidang_nama FROM tbl_bidang WHERE bidang_id='$id'")->row();
        $this->mylib->aview('v_tambah_jenis_kegiatan', $data);
    }

    function tambah_jenis_kegiatan_act()
    {
        $this->load->database();
        $id = $this->input->post('bidang');
        $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'required');
        $this->form_validation->set_rules('sks_bkd', 'SKS BKD', 'required');
        if ($this->form_validation->run() != true) {
            $this->tambah_jenis_kegiatan($id);
        } else {
            $data = [
                'kegiatan_nama' => $this->input->post('kegiatan'),
                'bidang_id' => $id,
                'sks_bkd' => $this->input->post('sks_bkd'),
                'h_pengguna' => 'umar',
                'h_tanggal' => date('Y-m-d'),
                'h_waktu' => date('h:i:s')
            ];
            $this->m_vic->insert_data($data, 'tbl_kegiatan');
            $this->session->set_flashdata('suces', 'Data Berhasil Ditambah');
            redirect('admin/jenis_kegiatan/' . $id);
        }
    }

    function edit_jenis_kegiatan($id)
    {
        // $this->load->database();
        // $w = [
        //     'jenis_id' => $id
        // ];
        // $data['jenis'] = $this->m_vic->edit_data($w, 'tbl_jenis_kegiatan')->row();
        $this->mylib->aview('v_edit_jenis_kegiatan');
    }

    function update_jenis_kegiatan()
    {
        // $w = [
        //     'jenis_id' => $this->input->post('id')
        // ];

        // $data = [
        //     'jenis_id_simbol' => $this->input->post('simbol'),
        //     'jenis_nama' => $this->input->post('nama'),
        //     'kinerja_bidang' => $this->input->post('bidang'),
        //     'h_pengguna' => $this->session->userdata('username'),
        //     'h_tanggal' => date('Y-m-d'),
        //     'h_waktu' => date('h:i:s')
        // ];
        // $this->m_vic->update_data($w, $data, 'tbl_jenis_kegiatan');
        // $this->session->set_flashdata('suces', 'Data Berhasil Diupdate');
        redirect('admin/jenis_kegiatan/1');
    }

    // function delete_jenis($id)
    // {
    //     $w = [
    //         'jenis_id' => $id
    //     ];
    //     $this->m_vic->delete_data($w, 'tbl_jenis_kegiatan');
    //     $this->session->set_flashdata('suces', 'Data Berhasil Dihapus');
    //     redirect('admin/jenis_kegiatan?notif=suces');
    // }

    //sub_kegiatan_1
    public function sub_kegiatan_1($id)
    {
        $this->load->database();
        $w = [
            'kegiatan_id' => $id
        ];
        $data['kegiatan'] = $this->db->query("SELECT kegiatan_id,kegiatan_nama,bidang_id FROM tbl_kegiatan WHERE kegiatan_id='$id'")->row();
        $data['sub1'] = $this->m_vic->edit_data($w, 'tbl_sub_1');
        $this->mylib->aview('v_sub_kegiatan_1', $data);
    }

    public function tambah_sub_kegiatan_1($id)
    {
        $this->load->database();
        $data['kegiatan'] = $this->db->query("SELECT kegiatan_id,kegiatan_nama,bidang_id FROM tbl_kegiatan WHERE kegiatan_id='$id'")->row();
        $this->mylib->aview('v_tambah_sub_kegiatan_1', $data);
    }

    public function tambah_sub_kegiatan_1_act()
    {
        $this->load->database();
        $id = $this->input->post('id');
        $this->form_validation->set_rules('sub_bidang_1', 'Sub Bidang 1', 'required');
        $this->form_validation->set_rules('sks_bkd', 'SKS BKD', 'required');
        if ($this->form_validation->run() != true) {
            $this->tambah_sub_kegiatan_1($id);
        } else {
            $data = [
                'kegiatan_id' => $id,
                'sub_1_nama' => $this->input->post('sub_bidang_1'),
                'sks_bkd' => $this->input->post('sks_bkd'),
                'h_pengguna' => 'umar',
                'h_tanggal' => date('Y-m-d'),
                'h_waktu' => date('h:i:s')
            ];
            $this->m_vic->insert_data($data, 'tbl_sub_1');
            $this->session->set_flashdata('suces', 'Data Berhasil Ditambah');
            redirect('admin/sub_kegiatan_1/' . $id);
        }
    }

    public function edit_sub_kegiatan_1($id)
    {
        $this->mylib->aview('v_edit_sub_kegiatan_1');
    }

    public function update_sub_kegiatan_1()
    {
        redirect('admin/sub_kegiatan_1/1');
    }

    //sub_kegiatan_2
    public function sub_kegiatan_2($id)
    {
        $this->load->database();
        $w = [
            'sub_1_id' => $id
        ];
        $data['sub1'] = $this->db->query("SELECT sub_1_id,sub_1_nama,kegiatan_id FROM tbl_sub_1 WHERE sub_1_id='$id'")->row();
        $data['sub2'] = $this->m_vic->edit_data($w, 'tbl_sub_2');
        $this->mylib->aview('v_sub_kegiatan_2', $data);
    }

    public function tambah_sub_kegiatan_2($id)
    {
        $this->load->database();
        $data['sub1'] = $this->db->query("SELECT sub_1_id,sub_1_nama,kegiatan_id FROM tbl_sub_1 WHERE sub_1_id='$id'")->row();
        $this->mylib->aview('v_tambah_sub_kegiatan_2', $data);
    }

    public function tambah_sub_kegiatan_2_act()
    {
        $this->load->database();
        $id = $this->input->post('id');
        $this->form_validation->set_rules('sub_bidang_2', 'Sub Bidang 2', 'required');
        $this->form_validation->set_rules('sks_bkd', 'SKS BKD', 'required');
        if ($this->form_validation->run() != true) {
            $this->tambah_sub_kegiatan_2($id);
        } else {
            $data = [
                'sub_1_id' => $id,
                'sub_2_nama' => $this->input->post('sub_bidang_2'),
                'sks_bkd' => $this->input->post('sks_bkd'),
                'h_pengguna' => 'umar',
                'h_tanggal' => date('Y-m-d'),
                'h_waktu' => date('h:i:s')
            ];
            $this->m_vic->insert_data($data, 'tbl_sub_2');
            $this->session->set_flashdata('suces', 'Data Berhasil Ditambah');
            redirect('admin/sub_kegiatan_2/' . $id);
        }
    }

    public function edit_sub_kegiatan_2($id)
    {
        $this->mylib->aview('v_edit_sub_kegiatan_2');
    }

    public function update_sub_kegiatan_2()
    {
        redirect('admin/sub_kegiatan_2/1');
    }
    //end_sub_kegiatan_2

    //sub_kegiatan_3
    public function sub_kegiatan_3($id)
    {
        $this->load->database();
        $w = [
            'sub_2_id' => $id
        ];
        $data['sub2'] = $this->db->query("SELECT sub_2_id,sub_2_nama,sub_1_id FROM tbl_sub_2 WHERE sub_2_id='$id'")->row();
        $data['sub3'] = $this->m_vic->edit_data($w, 'tbl_sub_3');
        $this->mylib->aview('v_sub_kegiatan_3', $data);
    }

    public function tambah_sub_kegiatan_3($id)
    {
        $this->load->database();
        $data['sub2'] = $this->db->query("SELECT sub_2_id,sub_2_nama,sub_1_id FROM tbl_sub_2 WHERE sub_2_id='$id'")->row();
        $this->mylib->aview('v_tambah_sub_kegiatan_3', $data);
    }

    public function tambah_sub_kegiatan_3_act()
    {
        $this->load->database();
        $id = $this->input->post('id');
        $this->form_validation->set_rules('sub_bidang_3', 'Sub Bidang 3', 'required');
        $this->form_validation->set_rules('sks_bkd', 'SKS BKD', 'required');
        if ($this->form_validation->run() != true) {
            $this->tambah_sub_kegiatan_3($id);
        } else {
            $data = [
                'sub_2_id' => $id,
                'sub_3_nama' => $this->input->post('sub_bidang_3'),
                'sks_bkd' => $this->input->post('sks_bkd'),
                'h_pengguna' => 'umar',
                'h_tanggal' => date('Y-m-d'),
                'h_waktu' => date('h:i:s')
            ];
            $this->m_vic->insert_data($data, 'tbl_sub_3');
            $this->session->set_flashdata('suces', 'Data Berhasil Ditambah');
            redirect('admin/sub_kegiatan_3/' . $id);
        }
    }

    public function edit_sub_kegiatan_3($id)
    {
        $this->mylib->aview('v_edit_sub_kegiatan_3');
    }

    public function update_sub_kegiatan_3()
    {
        redirect('admin/sub_kegiatan_3/1');
    }
    //end_sub_kegiatan_3

    //tahun akademik
    public function tahun_akademik()
    {
        $this->load->database();
        $data['tahun'] = $this->db->query("SELECT * FROM tbl_tahun_akademik ORDER BY tahun_id DESC");
        $this->mylib->aview('v_tahun_akademik', $data);
    }

    function tambah_tahun_akademik()
    {
        $this->mylib->aview('v_tambah_tahun_akademik');
    }

    function tambah_tahun_akademik_act()
    {
        $this->load->database();
        $this->form_validation->set_rules('tahun_akademik', 'Tahun', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required');
        if ($this->form_validation->run() != true) {
            $this->tambah_tahun_akademik();
        } else {
            $data = [
                'tahun_akademik' => $this->input->post('tahun_akademik'),
                'tahun_semester' => $this->input->post('semester'),
                'tahun_status' => 0,
                'h_pengguna' => 'umar',
                'h_tanggal' => date('Y-m-d'),
                'h_waktu' => date('h:i:s')
            ];
            $this->m_vic->insert_data($data, 'tbl_tahun_akademik');
            $this->session->set_flashdata('suces', 'Data Berhasil Ditambah');
            redirect('admin/tahun_akademik?notif=suces');
        }
    }

    function edit_tahun_akademik($id)
    {
        // $this->load->database();
        // $w = [
        //     'tahun_id' => $id
        // ];
        // $data['tahun'] = $this->m_vic->edit_data($w, 'tbl_tahun_akademik')->row();
        $this->mylib->aview('v_edit_tahun_akademik');
    }

    function update_tahun_akademik()
    {
        // $this->load->database();
        // $data = [
        //     'tahun_akademik' => $this->input->post('tahun'),
        //     'tahun_semester' => $this->input->post('semester'),
        //     'h_pengguna' => $this->session->userdata('username'),
        //     'h_tanggal' => date('Y-m-d'),
        //     'h_waktu' => date('h:i:s')
        // ];
        // $w = [
        //     'tahun_id' => $this->input->post('id')
        // ];
        // $this->m_vic->update_data($w, $data, 'tbl_tahun_akademik');
        // $this->session->set_flashdata('suces', 'Data Berhasil Diubah');
        redirect('admin/tahun_akademik?notif=suces');
    }

    function selesai_tahun_akademik($id)
    {
        $this->load->database();
        $w = [
            'tahun_id' => $id
        ];
        $data = [
            'tahun_status' => 1
        ];
        $this->m_vic->update_data($w, $data, 'tbl_tahun_akademik');
        $this->session->set_flashdata('suces', 'Tahun Akademik Selesai');
        redirect('admin/tahun_akademik?notif=suces');
    }

    function delete_tahun_akademik($id)
    {
        $this->load->database();
        $w = [
            'tahun_id' => $id
        ];
        $this->m_vic->delete_data($w, 'tbl_tahun_akademik');
        $this->session->set_flashdata('suces', 'Tahun Akademik Berhasil Dihapus');
        redirect('admin/tahun_akademik?notif=suces');
    }

    //timeline
    public function tahun_timeline($id)
    {
        $this->load->database();
        $w_rbkd = [
            'tahun_id' => $id,
            'timeline_kegiatan' => 'RBKD'
        ];
        $w_bkd = [
            'tahun_id' => $id,
            'timeline_kegiatan' => 'BKD'
        ];
        $data['tahun'] = $this->db->query("SELECT tahun_id,tahun_akademik,tahun_semester FROM tbl_tahun_akademik WHERE tahun_id ='$id'")->row();
        $data['rbkd'] = $this->m_vic->edit_data($w_rbkd, 'tbl_tahun_timeline');
        $data['bkd'] = $this->m_vic->edit_data($w_bkd, 'tbl_tahun_timeline');
        $this->mylib->aview('v_tahun_timeline', $data);
    }

    public function tambah_timeline($type, $id)
    {
        $data['timeline'] = [
            'kegiatan' => $type,
            'tahun_id' => $id
        ];
        $this->mylib->aview('v_tambah_timeline', $data);
    }

    public function tambah_timeline_act()
    {
        $this->load->database();
        $type = $this->input->post('kegiatan');
        $id = $this->input->post('id');
        $this->form_validation->set_rules('buka', 'Tanggal Buka', 'required|trim');
        $this->form_validation->set_rules('tutup', 'Tanggal Tutup', 'required|trim');
        if ($this->form_validation->run() != true) {
            $this->tambah_timeline($type, $id);
        } else {
            $data = [
                'tahun_id' => $id,
                'timeline_buka' => $this->input->post('buka'),
                'timeline_tutup' => $this->input->post('tutup'),
                'timeline_kegiatan' => $type,
                'timeline_status' => 'Aktif',
                'h_pengguna' => 'umar',
                'h_tanggal' => date('Y-m-d'),
                'h_waktu' => date('h:i:s')
            ];
            $this->m_vic->insert_data($data, 'tbl_tahun_timeline');
            redirect('admin/tahun_timeline/' . $id);
        }
    }

    //endtimeline

    function asesor()
    {
        $w = [
            'td_nidn' => $this->input->post('nidn')
        ];
        $mydata = $this->m_vic->edit_data($w, 'tbl_pegawai')->row();
        if ($mydata->td_nama_tengah == '' && $mydata->td_nama_depan != '') {
            $nama = $mydata->td_nama_depan . ' ' . $mydata->td_nama_belakang;
        } elseif ($mydata->td_nama_tengah != '' && $mydata->td_nama_depan == '') {
            $nama = $mydata->td_nama_depan . ' ' . $mydata->td_nama_tengah;
        } elseif ($mydata->td_nama_tengah == '' && $mydata->td_nama_depan == '') {
            $nama = $mydata->td_nama_depan;
        } elseif ($mydata->td_nama_tengah != '' && $mydata->td_nama_depan != '') {
            $nama = $mydata->td_nama_depan . ' ' . $mydata->td_nama_tengah . ' ' . $mydata->td_nama_belakang;
        }

        if ($mydata->td_gelar_depan == '' && $mydata->td_gelar_belakang != '') {
            $nama_gelar = $nama . ' ' . $mydata->td_gelar_belakang;
        } elseif ($mydata->td_gelar_depan != '' && $mydata->td_gelar_belakang == '') {
            $nama_gelar = $mydata->td_gelar_depan . ' ' . $nama;
        } elseif ($mydata->td_gelar_depan == '' && $mydata->td_gelar_belakang == '') {
            $nama_gelar = $nama;
        } elseif ($mydata->td_gelar_depan != '' && $mydata->td_gelar_belakang != '') {
            $nama_gelar = $mydata->td_gelar_depan . ' ' . $nama . ' ' . $mydata->td_gelar_belakang;
        }

        $data = [
            'nama' => $nama_gelar,
            'email' => $mydata->td_email
        ];
        echo json_encode($data);
    }

    function pegawai()
    {
        $this->load->database();
        $data['pegawai'] = $this->m_vic->get_data('tbl_pegawai');
        $this->mylib->aview('v_pegawai', $data);
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
