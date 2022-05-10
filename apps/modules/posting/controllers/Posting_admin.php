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
class Posting_admin extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged_admin') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('Posting_model', 'activity_log/Activity_log_model'));
        $this->load->library('upload');
    }

    // Posting view in list
    public function index($offset = NULL) {
        $this->load->library('pagination');
        $data['posting'] = $this->Posting_model->get(array('limit' => 10, 'offset' => $offset));
        $data['category'] = $this->Posting_model->get_category();
        $config['base_url'] = site_url('admin/posting/index');
        $config['total_rows'] = $this->db->count_all('posting');
        $this->pagination->initialize($config);

        $data['title'] = 'Daftar Ulasan';
        $data['page'] = 'posting/posting_list';
        $this->load->view('admin/layout/main', $data);
    }

    function view($id = NULL) {
        if ($this->Posting_model->get(array('id' => $id)) == NULL) {
            redirect('admin/posting');
        }
        $data['posting'] = $this->Posting_model->get(array('id' => $id));
        $data['title'] = 'Detail Ulasan';
        $data['page'] = 'posting/posting_view';
        $this->load->view('admin/layout/main', $data);
    }

    // Category view in list
    public function category($offset = NULL) {
        $this->load->library('pagination');
        $data['categories'] = $this->Posting_model->get_category(array('limit' => 10, 'offset' => $offset));
        $config['base_url'] = site_url('admin/posting/category');
        $config['total_rows'] = $this->db->count_all('posting_category');
        $this->pagination->initialize($config);
        $data['title'] = 'Daftar Kategori Ulasan';
        $data['page'] = 'posting/category_list';
        $this->load->view('admin/layout/main', $data);
    }

    // Add Posting and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('posting_title', 'Title', 'required');
        $this->form_validation->set_rules('posting_desc', 'Content', 'required');
        $this->form_validation->set_rules('category_id_new', 'Kategori', 'is_unique[posting_category.category_name]');
        $this->form_validation->set_rules('posting_is_published', 'Publish Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {
            if (!empty($_FILES['inputGambar']['name'])) {
                $params['posting_image'] = $this->do_upload('inputGambar');
            } elseif ($this->input->post('inputGambarExisting')) {
                $params['posting_image'] = $this->input->post('inputGambarExisting');
            } else {
                if ($this->input->post('posting_id')) {
                    $params['posting_image'] = $this->input->post('inputGambarCurrent');
                } else {
                    $params['posting_image'] = '';
                }
            }

            if ($this->input->post('posting_id')) {
                $params['posting_id'] = $this->input->post('posting_id');
            } else {
                $params['posting_created_date'] = date('Y-m-d H:i:s');
            }

            $params['user_id'] = $this->session->userdata('user_id_admin');
            $params['posting_last_update'] = date('Y-m-d H:i:s');
            $params['posting_published_date'] = ($this->input->post('posting_published_date')) ? $this->input->post('posting_published_date') : date('Y-m-d H:i:s');
            $params['posting_title'] = $this->input->post('posting_title');
            $params['posting_short_desc'] = stripslashes($this->input->post('posting_short_desc'));
            $params['posting_desc'] = stripslashes($this->input->post('posting_desc'));
            $params['category_id'] = $this->input->post('category_id');
            $params['posting_is_published'] = $this->input->post('posting_is_published');
            $params['posting_is_commentable'] = $this->input->post('posting_is_commentable');
            $status = $this->Posting_model->add($params);


            // activity log
            $this->Activity_log_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('user_id_admin'),
                        'log_module' => 'Posting',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:null;Title:' . $params['posting_title']
                    )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' posting berhasil');
            redirect('admin/posting');
        } else {
            if ($this->input->post('posting_id')) {
                redirect('admin/posting/edit/' . $this->input->post('posting_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $data['posting'] = $this->Posting_model->get(array('id' => $id));
            }

            $data['categories'] = $this->Posting_model->get_category();
            $data['category'] = $this->get_category();
            // echo "<pre>";
            // print_r($data['category']);
            // echo "</pre>";
            // die();
            $data['title'] = $data['operation'] . ' Ulasan';
            $data['page'] = 'posting/posting_add';
            $data['widgets'] = ['widgets/tinymce'];
            $this->load->view('admin/layout/main', $data);
        }
    }

    // Add Category
    public function add_category($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('category_name', 'Name', 'required|is_unique[posting_category.posting_category_name]');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {
            if ($this->input->post('category_id')) {
                $params['category_id'] = $this->input->post('category_id');
            } else {
                $params['category_created_date'] = date('Y-m-d H:i:s');
            }
            $params['category_last_update'] = date('Y-m-d H:i:s');
            $params['category_name'] = $this->input->post('category_name');
            $params['user_id'] = $this->session->userdata('user_id_admin');
            $res = $this->Posting_model->add_category($params);

            // activity log
            $this->Activity_log_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('user_id_admin'),
                        'log_module' => 'Posting',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:'.$res.';Title:' . $params['category_name']
                    )
            );

            if ($this->input->is_ajax_request()) {
                echo $res;
            } else {
            $this->session->set_flashdata('success', $data['operation'] . ' kategori posting berhasil');
            redirect('admin/posting/category');
            }
        } else {
            if ($this->input->post('category_id')) {
                redirect('admin/category/edit/' . $this->input->post('category_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                if ($id == 1) {
                    redirect('admin/posting/category/');
                }
                $data['category'] = $this->Posting_model->get_category(array('id' => $id));
            }
            $data['title'] = $data['operation'].' Kategori Ulasan';
            $data['page'] = 'posting/category_add';
            $this->load->view('admin/layout/main', $data);
        }
    }

    protected function get_category() {
        $res = json_encode($this->Posting_model->get_category());
        return $res;
    }

    // Delete Posting
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Posting_model->delete($this->input->post('del_id'));
            // activity log
            $this->Activity_log_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('user_id_admin'),
                        'log_module' => 'Posting',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus posting berhasil');
            redirect('admin/posting');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/posting/edit/' . $id);
        }
    }

    // Delete Category
    public function delete_category($id = NULL) {
        if ($_POST) {
            $params['posting_category_posting_category_id'] = '1';
            $this->Posting_model->set_default_category($id, $params);

            $this->Posting_model->delete_category($this->input->post('del_id'));
            // activity log
            $this->Activity_log_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('user_id_admin'),
                        'log_module' => 'Kategori Posting',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus kategori posting berhasil');
            redirect('admin/posting/category');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/posting/category/edit/' . $id);
        }
    }

    public function do_upload($name = NULL)
    {
        $this->load->library('upload');

        $config['upload_path'] = FCPATH . 'uploads';

        /* create directory if not exist */
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '32000';
        $this->upload->initialize($config);
        // $this->load->library('upload', $config);

        if (!$this->upload->do_upload($name)) {
            $this->session->set_flashdata('error_upload', $this->upload->display_errors(''));

            redirect(uri_string());
        }

        $upload_data = $this->upload->data();

        return $upload_data['file_name'];
    }
}

/* End of file posting.php */
/* Location: ./application/controllers/admin/posting.php */
