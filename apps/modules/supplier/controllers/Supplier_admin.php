<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Posting controllers class
 *
 * @package     GROOT
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy@artikulpi.com>
 */
class Supplier_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged_admin') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('Supplier_model', 'activity_log/Activity_log_model'));
        $this->load->library('upload');
    }

    public function index($offset = NULL)
    {
        $this->load->library('pagination');
        $data['supplier'] = $this->Supplier_model->get(array('limit' => 10, 'offset' => $offset));
        $config['base_url'] = site_url('admin/supplier/index');
        $config['total_rows'] = $this->db->count_all('supplier');
        $this->pagination->initialize($config);

        $data['title'] = 'Supplier';
        $data['page'] = 'supplier/supplier_list';
        $this->load->view('admin/layout/main', $data);
    }

    function view($id = NULL)
    {
        if ($this->Supplier_model->get(array('id' => $id)) == NULL) {
            redirect('admin/supplier');
        }
        $data['supplier'] = $this->Supplier_model->get(array('id' => $id));
        $data['title'] = 'Detail katalog';
        $data['page'] = 'supplier/supplier_view';
        $this->load->view('admin/layout/main', $data);
    }

    public function add($id = NULL)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('supplier_name', 'Name ', 'required');
        $this->form_validation->set_rules('supplier_email', 'Email', 'required');
        $this->form_validation->set_rules('supplier_phone', 'Phone', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {
            if ($this->input->post('supplier_id')) {
                $params['supplier_id'] = $this->input->post('supplier_id');
            } else {
                $params['supplier_created_date'] = date('Y-m-d H:i:s');
            }

            $params['user_id'] = $this->session->userdata('user_id_admin');
            $params['supplier_last_update'] = date('Y-m-d H:i:s');
            $params['supplier_name'] = $this->input->post('supplier_name');
            $params['supplier_email'] = $this->input->post('supplier_email');
            $params['supplier_phone'] = $this->input->post('supplier_phone');
            $params['supplier_address'] = $this->input->post('supplier_address');
            $status = $this->Supplier_model->add($params);

            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Supplier',
                    'log_action' => $data['operation'],
                    'log_info' => 'ID:'.$status.';Title:' . $params['supplier_name']
                )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' supplier berhasil');
            redirect('admin/supplier');
        } else {
            if ($this->input->post('supplier_id')) {
                redirect('admin/supplier/edit/' . $this->input->post('supplier_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $data['supplier'] = $this->Supplier_model->get(array('id' => $id));
            }
            $data['title'] = $data['operation'] . ' Posting';
            $data['widgets'] = ['widgets/tinymce', 'widgets/datepicker'];
            $data['page'] = 'supplier/supplier_add';
            $this->load->view('admin/layout/main', $data);
        }
    }

    public function delete($id = NULL) {
        if ($_POST) {
            $this->Supplier_model->delete($this->input->post('del_id'));
            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Supplier',
                    'log_action' => 'Hapus',
                    'log_info' => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name')
                )
            );
            $this->session->set_flashdata('success', 'Hapus supplier berhasil');
            redirect('admin/supplier');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/supplier/edit/' . $id);
        }
    }

}

/* End of file supplier.php */
/* Location: ./application/controllers/admin/supplier.php */
