<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/** 
* Auth controllers class
 *
 * @package     GROOT
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->helper('string');
        $this->load->helper('url');
    }

    function index()
    {
        redirect('admin/auth/login');
    }

    function login()
    {
        if ($this->session->userdata('logged_admin')) {
            redirect('admin');
        }
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($_POST AND $this->form_validation->run() == TRUE) {
            if ($this->input->post('location')) {
                $lokasi = $this->input->post('location');
            } else {
                $lokasi = NULL;
            }
            $this->process_login($lokasi);
        } else {
            $this->load->view('user/login');
        }
    }

    function process_login($lokasi = '')
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            if ($this->User_model->check_login($username, $password)) {
                $user = $this->User_model->get_by_username($username);

                $this->session->set_userdata('logged_admin', TRUE);
                $this->session->set_userdata('user_id_admin', $user['user_id']);
                $this->session->set_userdata('user_name_admin', $user['user_name']);
                $this->session->set_userdata('user_role_admin', $user['user_role_role_id']);
                $this->session->set_userdata('user_email_admin', $user['user_email']);
                $this->session->set_userdata('user_full_name_admin', $user['user_full_name']);
                if ($lokasi != '') {
                    header("Location:" . htmlspecialchars($lokasi));
                } else {
                    redirect('admin');
                }
            } else {
                if ($lokasi != '') {
                    $this->session->set_flashdata('failed', 'Sorry, username and password do not match');
                    header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($lokasi));
                } else {
                    $this->session->set_flashdata('failed', 'Sorry, username and password do not match');
                    redirect('admin/auth/login');
                }
            }
        } else {
            $this->session->set_flashdata('failed', 'Maaf, Username dan password belum lengkap!');
            redirect('admin/auth/login');
        }
    }

    function logout()
    {
        $this->session->unset_userdata('logged_admin');
        $this->session->unset_userdata('user_id_admin');
        $this->session->unset_userdata('user_name_admin');
        $this->session->unset_userdata('user_role_admin');
        $this->session->unset_userdata('user_email_admin');
        $this->session->unset_userdata('user_full_name_admin');
        if ($this->input->post('location')) {
            $lokasi = $this->input->post('location');
        } else {
            $lokasi = NULL;
        }
        header("Location:" . $lokasi);
    }

}
