<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * User controllers class
 *
 * @package     GROOT
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy@artikulpi.com>
 */
class Customer_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_admin') == null) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('Customer_model');
        $this->load->model('activity_log/Activity_log_model');
        $this->load->helper(array('form', 'url'));
    }

    public function index($offset = null)
    {
        $this->load->library('pagination');
        $data['customer']     = $this->Customer_model->get(array('limit' => 10, 'offset' => $offset, 'status' => 0));
        $config['base_url']   = site_url('admin/customer/index');
        $config['total_rows'] = count($this->Customer_model->get());
        $this->pagination->initialize($config);

        $data['title'] = 'Customer';
        $data['page']  = 'customer/customer_list';
        $this->load->view('admin/layout/main', $data);
    }

    public function add($id = null)
    {
        $this->load->library('form_validation');

        if (!$this->input->post('customer_id')) {
            $this->form_validation->set_rules('customer_password', 'Password', 'required|matches[passconf]|min_length[6]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|min_length[6]|max_length[20]');
        }

        $this->form_validation->set_rules('customer_email', 'User Email', 'required|valid_email');
        $this->form_validation->set_rules('customer_phone', 'No. Telepon', 'required');
        $this->form_validation->set_rules('customer_full_name', 'Name', 'required');
        $this->form_validation->set_rules('customer_address', 'Alamat', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

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
                    'user_id'    => $this->session->userdata('user_id_admin'),
                    'log_date'   => date('Y-m-d H:i:s'),
                    'log_module' => 'Customer',
                    'log_action' => $data['operation'],
                    'log_info'   => 'ID:' . $status . ';Title:' . $this->input->post('customer_full_name'),
                )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' Customer berhasil');
            redirect('admin/customer');
        } else {
            if ($this->input->post('customer_id')) {
                redirect('admin/customer/edit/' . $this->input->post('customer_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                if ($this->Customer_model->get(array('id' => $id)) == null) {
                    redirect('admin/customer');
                } else {
                    $data['customer'] = $this->Customer_model->get(array('id' => $id));
                }
            }

            $data['title']   = $data['operation'] . ' Customer';
            $data['widgets'] = ['widgets/tinymce'];
            $data['page']    = 'customer/customer_add';
            $this->load->view('admin/layout/main', $data);
        }
    }

    public function view($id = null)
    {
        if ($this->Customer_model->get(array('id' => $id)) == null) {
            redirect('admin/customer');
        }
        $data['customer'] = $this->Customer_model->get(array('id' => $id));
        $data['title']    = 'Detail customer';
        $data['page']     = 'customer/customer_view';
        $this->load->view('admin/layout/main', $data);
    }

    public function rpw($id = null)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('customer_password', 'Password', 'required|matches[passconf]|min_length[6]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|min_length[6]');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>', '</div>');

        if ($_POST and $this->form_validation->run() == true) {
            $id                          = $this->input->post('customer_id');
            $params['customer_password'] = password_hash($this->input->post('customer_password'), PASSWORD_BCRYPT);
            $status                      = $this->Customer_model->change_password($id, $params);

            $this->Activity_log_model->add(
                array(
                    'user_id'    => $this->session->userdata('user_id_admin'),
                    'log_date'   => date('Y-m-d H:i:s'),
                    'log_module' => 'Customer',
                    'log_action' => 'Reset Password',
                    'log_info'   => 'ID:null;Title:' . $this->input->post('customer_full_name'),
                )
            );
            $this->session->set_flashdata('success', 'Reset password customer berhasil');
            redirect('admin/customer');
        } else {
            if ($this->Customer_model->get(array('id' => $id)) == null) {
                redirect('admin/customer');
            }
            $data['customer'] = $this->Customer_model->get(array('id' => $id));
            $data['title']    = 'Ganti Password Customer';
            $data['page']     = 'customer/change_pass';
            $this->load->view('admin/layout/main', $data);
        }
    }

    public function delete($id = null)
    {
        if ($this->Customer_model->get(array('id' => $id)) == null) {
            redirect('admin/customer');
        }
        if ($_POST) {
            $this->Customer_model->delete($this->input->post('del_id'));

            $this->Activity_log_model->add(
                array(
                    'user_id'    => $this->session->userdata('user_id_admin'),
                    'log_date'   => date('Y-m-d H:i:s'),
                    'log_module' => 'Customer',
                    'log_action' => 'Hapus',
                    'log_info'   => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name'),
                )
            );
            $this->session->set_flashdata('success', 'Hapus customer berhasil');
            redirect('admin/customer');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/customer/edit/' . $id);
        }
    }

    public function getAjax()
    {
        $res['results'] = array();
        $res['more']    = false;
        if ($this->input->get('q')) {
            $params['customer_full_name'] = $this->input->get('q');
            $res['results']               = $this->Customer_model->get_select2($params);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }

}

/* End of file user.php */
/* Location: ./application/controllers/ccp/user.php */
