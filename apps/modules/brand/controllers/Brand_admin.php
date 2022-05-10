<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Posting controllers class
 *
 * @package     GROOT
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Brand_admin extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged_admin') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('Brand_model', 'activity_log/Activity_log_model'));
    }

    // Posting view in list
    public function index($offset = NULL) {
        $this->load->library('pagination');
        $data['brand'] = $this->Brand_model->get(array('limit' => 10, 'offset' => $offset));
        $config['base_url'] = site_url('admin/brand/index');
        $config['total_rows'] = $this->db->count_all('brand');
        $this->pagination->initialize($config);

        $data['title'] = 'Brand';
        $data['page'] = 'brand/brand_list';
        $this->load->view('admin/layout/main', $data);
    }

    function view($id = NULL) {
        if ($this->Brand_model->get(array('id' => $id)) == NULL) {
            redirect('admin/brand');
        }
        $data['brand'] = $this->Brand_model->get(array('id' => $id));
        $data['title'] = 'Detail katalog';
        $data['page'] = 'brand/brand_view';
        $this->load->view('admin/layout/main', $data);
    }

    // Add Posting and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('brand_name', 'Name ', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {
            if ($this->input->post('brand_id')) {
                $params['brand_id'] = $this->input->post('brand_id');
            } else {
                $params['brand_created_date'] = date('Y-m-d H:i:s');
            }

            $params['user_id'] = $this->session->userdata('user_id_admin');
            $params['brand_last_update'] = date('Y-m-d H:i:s');
            $params['brand_name'] = $this->input->post('brand_name');
            $status = $this->Brand_model->add($params);


            // activity log
            $this->Activity_log_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('user_id_admin'),
                        'log_module' => 'Brand',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:'.$status.';Title:' . $params['brand_name']
                    )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' brand berhasil');
            redirect('admin/brand');
        } else {
            if ($this->input->post('brand_id')) {
                redirect('admin/brand/edit/' . $this->input->post('brand_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $data['brand'] = $this->Brand_model->get(array('id' => $id));
            }
            $data['title'] = $data['operation'] . ' Brand';
            $data['page'] = 'brand/brand_add';
            $this->load->view('admin/layout/main', $data);
        }
    }

    // Delete Posting
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Brand_model->delete($this->input->post('del_id'));
            // activity log
            $this->Activity_log_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('user_id_admin'),
                        'log_module' => 'Brand',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus brand berhasil');
            redirect('admin/brand');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/brand/edit/' . $id);
        }
    }

}

/* End of file brand.php */
/* Location: ./application/controllers/admin/brand.php */
