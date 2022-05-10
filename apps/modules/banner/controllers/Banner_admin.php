<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Banner controllers class
 *
 * @package     GROOT
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Banner_admin extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged_admin') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('Banner_model', 'activity_log/Activity_log_model'));
    }

    // Banner view in list
    public function index($offset = NULL) {
        $this->load->library('pagination');
        $data['banner'] = $this->Banner_model->get(array('limit' => 10, 'offset' => $offset));
        $config['base_url'] = site_url('admin/banner/index');
        $config['total_rows'] = $this->db->count_all('banner');
        $this->pagination->initialize($config);

        $data['title'] = 'Banner';
        $data['main'] = 'banner/banner_list';
        $this->load->view('admin/layout', $data);
    }

    function view($id = NULL) {
        if ($this->Banner_model->get(array('id' => $id)) == NULL) {
            redirect('admin/banner');
        }
        $data['banner'] = $this->Banner_model->get(array('id' => $id));
        $data['title'] = 'Detail banner';
        $data['main'] = 'banner/banner_view';
        $this->load->view('admin/layout', $data);
    }

    // Add Banner and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('banner_title', 'Title ', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {
            if (!empty($_FILES['inputGambar']['name'])) {
                $params['banner_image'] = $this->do_upload();
            } elseif ($this->input->post('inputGambarExisting')) {
                $params['banner_image'] = $this->input->post('inputGambarExisting');
            } else {
                if ($this->input->post('banner_id')) {
                    $params['banner_image'] = $this->input->post('inputGambarCurrent');
                } else {
                    $params['banner_image'] = '';
                }
            }
            
            if ($this->input->post('banner_id')) {
                $params['banner_id'] = $this->input->post('banner_id');
            } else {
                $params['banner_created_date'] = date('Y-m-d H:i:s');
            }

            $params['user_id'] = $this->session->userdata('user_id_admin');
            $params['banner_last_update'] = date('Y-m-d H:i:s');
            $params['banner_title'] = $this->input->post('banner_title');
            $params['banner_desc'] = $this->input->post('banner_desc');
            $status = $this->Banner_model->add($params);


            // activity log
            $this->Activity_log_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('user_id_admin'),
                        'log_module' => 'Banner',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:'.$status.';Title:' . $params['banner_title']
                    )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' banner berhasil');
            redirect('admin/banner');
        } else {
            if ($this->input->post('banner_id')) {
                redirect('admin/banner/edit/' . $this->input->post('banner_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $data['banner'] = $this->Banner_model->get(array('id' => $id));
            }
            $data['title'] = $data['operation'] . ' Banner';
            $data['main'] = 'banner/banner_add';
            $this->load->view('admin/layout', $data);
        }
    }

    // Delete Banner
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Banner_model->delete($this->input->post('del_id'));
            // activity log
            $this->Activity_log_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('user_id_admin'),
                        'log_module' => 'Banner',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus banner berhasil');
            redirect('admin/banner');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/banner/edit/' . $id);
        }
    }

}

/* End of file banner.php */
/* Location: ./application/controllers/admin/banner.php */
