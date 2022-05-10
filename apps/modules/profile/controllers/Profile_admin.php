<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/** 
* Profile controllers class
 *
 * @package     GROOT
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy@artikulpi.com>
 */

class Profile_admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_admin') == NULL) redirect('admin/auth/login');
        $this->load->model(array('activity_log/Activity_log_model', 'user/User_model'));
        $this->load->helper(array('form', 'url'));
    }

    public function index($offset = NULL)
    {
        $data['user'] = $this->User_model->get(array('id' => $this->session->userdata('user_id_admin')));
        $data['title'] = 'Detail Profil';
        $data['page'] = 'profile/profile';
        $this->load->view('admin/layout/main', $data);
    }

    public function edit()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user_full_name', 'Name', 'required');
        $this->form_validation->set_rules('user_email', 'User Email', 'required|valid_email');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            $params['user_id'] = $this->input->post('user_id');
            $params['user_role'] = $this->input->post('user_role');
            $params['user_last_update'] = date('Y-m-d H:i:s');
            $params['user_name'] = $this->input->post('user_name');
            $params['user_full_name'] = $this->input->post('user_full_name');
            $params['user_short_desc'] = $this->input->post('user_short_desc');
            $params['user_desc'] = $this->input->post('user_desc');
            $params['user_email'] = $this->input->post('user_email');
            $status = $this->User_model->add($params);

            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Pengguna',
                    'log_action' => $data['operation'],
                    'log_info' => 'ID:'.$status.';Title:' . $params['user_name']
                )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' Pengguna berhasil');
            redirect('admin/profile');
        } else {
            $data['user'] = $this->User_model->get(array('id' => $this->session->userdata('user_id_admin')));
            $data['role'] = $this->User_model->get_role();
            $data['title'] = $data['operation'] . ' User';
            $data['widgets'] = ['widgets/tinymce'];
            $data['page'] = 'profile/edit';
            $this->load->view('admin/layout/main', $data);
        }
    }

    function cpw()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_password', 'Password', 'required|matches[passconf]|min_length[6]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|min_length[6]');
        $this->form_validation->set_rules('user_current_password', 'Old Password', 'required|callback_check_current_password');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        if ($_POST AND $this->form_validation->run() == TRUE) {
            $params['user_password'] = password_hash($this->input->post('user_password'), PASSWORD_BCRYPT);
            $status = $this->User_model->change_password($this->session->userdata('user_id_admin'), $params);

            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Pengguna',
                    'log_action' => 'Ganti Password',
                    'log_info' => 'ID:null;Title:' . $this->input->post('user_name')
                )
            );
            $this->session->set_flashdata('success', 'Ubah password pengguna berhasil');
            redirect('admin/profile');
        } else {
            if ($this->User_model->get(array('id' => $this->session->userdata('user_id_admin'))) == NULL) {
                redirect('manage');
            }
            $data['title'] = 'Ganti Password';
            $data['page'] = 'profile/change_pass';
            $this->load->view('admin/layout/main', $data);
        }
    }

    function check_current_password()
    {
        $password = $this->input->post('user_current_password');
        $username = $this->session->userdata('user_name_admin');
        if ($this->User_model->check_login($username, $password)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_current_password', 'The Old Password did not match with the current password');
            return FALSE;
        }
    }

}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */
