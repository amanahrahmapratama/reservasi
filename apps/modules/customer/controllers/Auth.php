<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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
        $this->load->model(array('Customer_model', 'posting/Posting_model', 'activity_log/Activity_log_model'));
        $this->load->library('form_validation');
        $this->load->helper('string');
        $this->load->helper('url');
    }

    public function index()
    {
        redirect('auth/login');
    }

    public function login()
    {
        if ($this->session->userdata('logged_customer')) {
            redirect('catalog');
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($_POST and $this->form_validation->run() == true) {
            if ($this->input->post('location')) {
                $lokasi = $this->input->post('location');
            } else {
                $lokasi = null;
            }
            $this->process_login($lokasi);
        } else {
            $setting                  = $this->setting->general();
            $data['app_name']         = $setting['app_name']['setting_value'];
            $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
            $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
            $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

            $imageSetting        = $this->setting->image();
            $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
            $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

            $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
            $data['title']        = 'Login';
            $data['page']         = 'auth/login';
            $this->load->view('layout', $data);
        }
    }

    public function process_login($lokasi = '')
    {
        $lokasi = $this->session->userdata('last_catalog_url');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
            $email    = $this->input->post('email', true);
            $password = $this->input->post('password', true);

            if ($this->Customer_model->check_login($email, $password)) {
                $user = $this->Customer_model->get_by_email($email);
                $this->session->set_userdata('logged_customer', true);
                $this->session->set_userdata('user_id_customer', $user['customer_id']);
                $this->session->set_userdata('user_email_customer', $user['customer_email']);
                $this->session->set_userdata('user_full_name_customer', $user['customer_full_name']);
                if ($lokasi != '') {
                    header("Location:" . htmlspecialchars($lokasi));
                } else {
                    redirect('catalog');
                }
            } else {
                if ($lokasi != '') {
                    $this->session->set_flashdata('failed', 'Sorry, email and password do not match');
                    header("Location:" . site_url('auth/login') . "?location=" . urlencode($lokasi));
                } else {
                    $this->session->set_flashdata('failed', 'Sorry, email and password do not match');
                    redirect('auth/login');
                }
            }
        } else {
            $this->session->set_flashdata('failed', 'Maaf, email dan password belum lengkap!');
            redirect('auth/login');
        }
    }

    public function register()
    {
        $this->load->library('form_validation');

        if (!$this->input->post('customer_id')) {
            $this->form_validation->set_rules('customer_password', 'Password', 'required|matches[passconf]|min_length[6]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|min_length[6]|max_length[20]');
        }

        $this->form_validation->set_rules('customer_email', 'User Email', 'required|valid_email|is_unique[customer.customer_email]', array('is_unique' => 'Email sudah terdaftar.'));
        $this->form_validation->set_rules('customer_phone', 'No. Telepon', 'required|is_unique[customer.customer_phone]', array('is_unique' => 'No telepon sudah terdaftar.'));
        $this->form_validation->set_rules('customer_full_name', 'Name', 'required');
        $this->form_validation->set_rules('customer_address', 'Alamat', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>', '</div>');

        if ($_POST and $this->form_validation->run() == true) {
            if ($this->input->post('customer_id')) {
                $params['customer_id'] = $this->input->post('customer_id');
            } else {
                $params['customer_deleted']      = 1;
                $params['customer_created_date'] = date('Y-m-d H:i:s');
                $params['customer_password']     = password_hash($this->input->post('customer_password'), PASSWORD_BCRYPT);
            }

            $params['customer_last_update'] = date('Y-m-d H:i:s');
            $params['customer_full_name']   = $this->input->post('customer_full_name');
            $params['customer_phone']       = $this->input->post('customer_phone');
            $params['customer_email']       = $this->input->post('customer_email');
            $params['customer_address']     = $this->input->post('customer_address');

            $status = $this->Customer_model->add($params);

            $this->Activity_log_model->add(
                array(
                    'log_date'   => date('Y-m-d H:i:s'),
                    'log_module' => 'Customer',
                    'log_action' => 'Register',
                    'log_info'   => 'ID:' . $status . ';Title:' . $this->input->post('customer_full_name'),
                    'user_id'    => null,
                )
            );

            $this->session->set_flashdata('register_success', 'registrasi telah berhasil');
            redirect('auth/login');
        } else {
            $setting                  = $this->setting->general();
            $data['app_name']         = $setting['app_name']['setting_value'];
            $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
            $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
            $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

            $imageSetting        = $this->setting->image();
            $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
            $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

            $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
            $data['title']        = 'Register';
            $data['page']         = 'auth/register';
            $this->load->view('layout', $data);
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('logged_customer');
        $this->session->unset_userdata('user_id_customer');
        $this->session->unset_userdata('user_email_customer');
        $this->session->unset_userdata('user_full_name_customer');
        $this->session->unset_userdata('cart_contents');
        if ($this->input->post('location')) {
            $lokasi = $this->input->post('location');
        } else {
            $lokasi = null;
        }
        redirect('/');
        // header("Location:" . $lokasi);
    }

    public function forgot()
    {
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            if ($this->form_validation->run()) {
                $email = $this->input->post('email', true);
                $user  = $this->Customer_model->get_by_email($email);
                if (count($user) == 0) {
                    $this->session->set_flashdata('failed', 'Email tidak ditemukan');
                    redirect(current_url());
                }

                $token                            = md5($user['customer_id'] . date('Y-m-d H:i:s') . uniqid());
                $params['customer_id']            = $user['customer_id'];
                $params['customer_token']         = $token;
                $params['customer_token_expired'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +1 day'));

                $ret = $this->Customer_model->add($params);

                $params['url']   = site_url('auth/reset/?token=' . $token);
                $params['email'] = $user['customer_email'];
                $params['user']  = $user;

                $this->load->library('sendMail');
                $this->sendmail->send($params['email'], 'Reset Password Akun Reservasi Ruangan', $params, 'email/reset_password');

                $this->session->set_flashdata('reset_success', 'Permintaan reset password telah dikirim ke email ' . $params['email'] . '. Silakan cek email anda');
                redirect(current_url());
            }
        }

        $data['page'] = 'auth/forgot';
        $this->load->view('layout', $data);
    }

    public function rpw()
    {
        $token = $this->input->get('token', true);
        if (is_null($token)) {
            redirect('/');
        }
        $params['token']         = $token;
        $params['token_expired'] = date('Y-m-d H:i:s');
        $customer                = $this->Customer_model->get($params);

        if (count($customer) == 0) {
            $this->session->set_flashdata('failed', 'Token expired');
            redirect('/');
        }

        $customer = $customer[0];

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password Baru', 'trim|required|xss_clean');
            $this->form_validation->set_rules('passwordConf', 'Ketik Ulang Password Baru', 'trim|required|xss_clean|matches[password]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            if ($this->form_validation->run()) {

                $params['customer_id']            = $customer['customer_id'];
                $params['customer_password']      = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                $params['customer_token']         = '-';
                $params['customer_token_expired'] = date('Y-m-d H:i:s');
                $ret                              = $this->Customer_model->add($params);

                $this->session->set_flashdata('register_success', 'Reset password berhasil. Silakan login dengan email dan password baru anda');
                redirect('auth/login');
            }
        }

        $data['page'] = 'auth/rpw';
        $this->load->view('layout', $data);
    }

}
